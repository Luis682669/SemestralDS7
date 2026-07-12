<?php
namespace App\Controllers;

use App\Models\Vacacion;
use App\Models\Colaborador;
use App\Core\Security;

class VacacionController {
    private Vacacion $vacacionModel;
    private Colaborador $colaboradorModel;

    public function __construct(Vacacion $vacacionModel, Colaborador $colaboradorModel) {
        $this->vacacionModel = $vacacionModel;
        $this->colaboradorModel = $colaboradorModel;
    }

    public function create(): void {
        $csrf_token = Security::generateCSRFToken();
        // Obtenemos a los colaboradores activos para el select del formulario
        $colaboradores = $this->colaboradorModel->getAllActive(); 
        require_once BASE_PATH . '/app/Views/modules/vacaciones/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            $colaborador_id = (int)($_POST['colaborador_id'] ?? 0);
            $fecha_inicio = $_POST['fecha_inicio'] ?? '';
            $fecha_fin = $_POST['fecha_fin'] ?? '';
            $motivo = trim($_POST['motivo'] ?? '');
            
            // Calculamos automáticamente cuántos días solicitó
            $inicio = new \DateTime($fecha_inicio);
            $fin = new \DateTime($fecha_fin);
            
            // Nuevo cálculo excluyendo fines de semana (sábados y domingos)
            $periodo_fin = (clone $fin)->modify('+1 day');
            $periodo = new \DatePeriod($inicio, new \DateInterval('P1D'), $periodo_fin);
            $dias_disfrutados = 0;
            foreach ($periodo as $dia) {
                if ($dia->format('N') < 6) { // Contar solo de Lunes (1) a Viernes (5)
                    $dias_disfrutados++;
                }
            }

            // Si no se seleccionó ningún día hábil, no se procesa
            if ($dias_disfrutados <= 0) {
                header('Location: /vacaciones/crear?error=no_work_days');
                exit;
            }

            $this->vacacionModel->solicitar($colaborador_id, $fecha_inicio, $fecha_fin, $dias_disfrutados, $motivo);
            
            // Redirigimos con un mensaje de éxito temporal
            header('Location: /vacaciones?msg=solicitud_enviada');
            exit;
        }
    }

    public function index(): void {
        $solicitudes = $this->vacacionModel->getAll();
        
        // Calculamos los días disponibles para cada solicitud en tiempo real
        foreach ($solicitudes as $key => $solicitud) {
            $solicitudes[$key]['dias_disponibles'] = $this->vacacionModel->calcularDiasDisponibles(
                (int)$solicitud['colaborador_id'], 
                $solicitud['fecha_contratacion']
            );
        }
        
        $csrf_token = Security::generateCSRFToken();
        require_once BASE_PATH . '/app/Views/modules/vacaciones/index.php';
    }

    public function cambiarEstado(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            $id = (int)$_POST['id'];
            $estado = $_POST['estado']; // 'Aprobada' o 'Rechazada'
            
            if (in_array($estado, ['Aprobada', 'Rechazada'])) {
                $this->vacacionModel->actualizarEstado($id, $estado);
            }
            
            header('Location: /vacaciones');
            exit;
        }
    }

    public function derechos(): void {
        $colaboradores = $this->colaboradorModel->getAllActive();

        foreach ($colaboradores as &$col) {
            $fechaContratacion = new \DateTime($col['fecha_contratacion']);
            $hoy = new \DateTime();
            $diff = $fechaContratacion->diff($hoy);

            $diasTrabajados = $diff->days;
            $mesesTrabajados = ($diff->y * 12) + $diff->m;

            $col['dias_trabajados'] = $diasTrabajados;
            $col['dias_vacaciones'] = (int) floor($diasTrabajados / 11);
            $col['meses_trabajados'] = $mesesTrabajados;
            $col['meses_vacaciones'] = (int) floor($mesesTrabajados / 11);
        }
        unset($col);

        require_once BASE_PATH . '/app/Views/modules/vacaciones/derechos.php';
    }
}
