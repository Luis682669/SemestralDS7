<?php
namespace App\Controllers;

use App\Models\Planilla;
use App\Models\Colaborador;
use App\Core\Security;

class PlanillaController {
    private Planilla $planillaModel;
    private Colaborador $colaboradorModel;

    public function __construct(Planilla $planillaModel, Colaborador $colaboradorModel) {
        $this->planillaModel = $planillaModel;
        $this->colaboradorModel = $colaboradorModel;
    }

    public function index(): void {
        $planillas = $this->planillaModel->getAll();
        $colaboradores = $this->colaboradorModel->getAllActive();
        $csrf_token = Security::generateCSRFToken();
        
        require_once BASE_PATH . '/app/Views/modules/planillas/index.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            $colaborador_id = (int)$_POST['colaborador_id'];
            $mes = $_POST['mes'];
            $anio = (int)$_POST['anio'];
            
            // Buscamos el salario actual del colaborador en su historial de cargos
            $cargos = $this->colaboradorModel->getCargos($colaborador_id);
            $salario_base = 0;
            
            foreach($cargos as $cargo) {
                if($cargo['es_activo'] == 1) {
                    $salario_base = (int)$cargo['sueldo'];
                    break;
                }
            }

            if ($salario_base > 0) {
                $this->planillaModel->calcularYGuardar($colaborador_id, $mes, $anio, $salario_base);
                header('Location: /planillas?msg=exito');
            } else {
                header('Location: /planillas?msg=error_salario');
            }
            exit;
        }
    }

    public function exportExcel(): void {
        $planillas = $this->planillaModel->getAll();
        $filename = 'planilla_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head><body>";
        echo "<table border=\"1\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Recibo #</th>";
        echo "<th>Identificación</th>";
        echo "<th>Colaborador</th>";
        echo "<th>Periodo</th>";
        echo "<th>Salario Base</th>";
        echo "<th>CSS SIPE</th>";
        echo "<th>Seguro Educativo</th>";
        echo "<th>XIII Mes</th>";
        echo "<th>Salario Neto</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($planillas as $p) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars(str_pad($p['id'], 5, '0', STR_PAD_LEFT)) . "</td>";
            echo "<td>" . htmlspecialchars($p['identificacion']) . "</td>";
            echo "<td>" . htmlspecialchars($p['primer_nombre'] . ' ' . $p['primer_apellido']) . "</td>";
            echo "<td>" . htmlspecialchars($p['mes'] . ' ' . $p['anio']) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($p['salario_base'], 0, ',', '.')) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($p['css_sipe'], 0, ',', '.')) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($p['seguro_educativo'], 0, ',', '.')) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($p['xiii_mes'], 0, ',', '.')) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($p['salario_neto'], 0, ',', '.')) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</body></html>";
        exit;
    }
}