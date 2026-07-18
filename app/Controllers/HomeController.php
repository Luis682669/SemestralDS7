<?php
namespace App\Controllers;

use App\Models\Reporte;
use App\Models\Vacacion;
use App\Models\Usuario;
use App\Models\Planilla;

class HomeController {
    private Reporte $reporteModel;
    private Vacacion $vacacionModel;
    private Usuario $usuarioModel;
    private Planilla $planillaModel;

    public function __construct(Reporte $reporteModel, Vacacion $vacacionModel, Usuario $usuarioModel, Planilla $planillaModel) {
        $this->reporteModel = $reporteModel;
        $this->vacacionModel = $vacacionModel;
        $this->usuarioModel = $usuarioModel;
        $this->planillaModel = $planillaModel;
    }

    public function index() {
        // Datos para la barra lateral y el saludo
        $username = $_SESSION['username'] ?? 'Usuario';
        $rol_nombre = $_SESSION['rol_nombre'] ?? 'Rol';

        // --- Obtener los contadores para el dashboard ---
        // NOTA: Para que esto funcione, tus modelos deben tener métodos para contar registros.
        // He usado `method_exists` para evitar errores si los métodos aún no han sido creados.
        // Si un método no existe, se usará el valor que tenías antes.

        // Este método ya existe en tu ReporteModel, así que funcionará de inmediato.
        $totalColaboradores = $this->reporteModel->countActiveCollaborators();

        // Para los demás, necesitarás métodos como `countActiveUsers()`, `countCurrentActive()`, etc.
        $totalUsuarios = method_exists($this->usuarioModel, 'countActiveUsers') ? $this->usuarioModel->countActiveUsers() : 8;
        $totalVacacionesActivas = method_exists($this->vacacionModel, 'countCurrentActive') ? $this->vacacionModel->countCurrentActive() : 14;
        $totalPlanillasRecientes = method_exists($this->planillaModel, 'countRecent') ? $this->planillaModel->countRecent() : 0;

        // --- Datos para el Gráfico de Reportes ---
        $reportesChartData = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            'heights' => [38, 55, 70, 48, 90, 60],
            'total_current_month' => 6,
            'comparison_text' => '↓ 2 vs. mes anterior',
            'comparison_class' => 'negative'
        ];
        if (method_exists($this->reporteModel, 'getMonthlyReportCounts')) {
            $reportCountsRaw = $this->reporteModel->getMonthlyReportCounts();
            $monthlyData = [];
            foreach ($reportCountsRaw as $row) {
                $monthlyData[$row['month']] = (int)$row['total'];
            }

            $reportesChartData['labels'] = [];
            $reportesChartData['values'] = [];
            $maxVal = 0;
            for ($i = 5; $i >= 0; $i--) {
                $date = (new \DateTime())->modify("-$i months");
                $monthKey = $date->format('Y-m');
                $monthLabel = mb_substr($this->getSpanishMonthName((int)$date->format('n')), 0, 3);
                
                $count = $monthlyData[$monthKey] ?? 0;
                
                $reportesChartData['labels'][] = $monthLabel;
                $reportesChartData['values'][] = $count;
                if ($count > $maxVal) $maxVal = $count;
            }
            
            $reportesChartData['heights'] = [];
            foreach ($reportesChartData['values'] as $value) {
                $reportesChartData['heights'][] = ($maxVal > 0) ? round(($value / $maxVal) * 100) : 0;
            }

            $currentMonthCount = end($reportesChartData['values']);
            $previousMonthCount = $reportesChartData['values'][count($reportesChartData['values']) - 2] ?? 0;
            $reportesChartData['total_current_month'] = $currentMonthCount;
            $diff = $currentMonthCount - $previousMonthCount;

            if ($diff > 0) {
                $reportesChartData['comparison_text'] = "↑ $diff vs. mes anterior";
                $reportesChartData['comparison_class'] = 'positive';
            } elseif ($diff < 0) {
                $reportesChartData['comparison_text'] = "↓ " . abs($diff) . " vs. mes anterior";
                $reportesChartData['comparison_class'] = 'negative';
            } else {
                $reportesChartData['comparison_text'] = "↔ igual al mes anterior";
                $reportesChartData['comparison_class'] = 'neutral';
            }
        }

        // --- Datos para el Calendario ---
        $hoy = new \DateTime();
        $anioActual = (int)$hoy->format('Y');
        $mesActual = (int)$hoy->format('n');
        $nombreMesActual = $this->getSpanishMonthName($mesActual);
        $diasEnMes = (int)$hoy->format('t');
        $diasVacaciones = method_exists($this->vacacionModel, 'getApprovedVacationDaysForMonth') 
            ? $this->vacacionModel->getApprovedVacationDaysForMonth($anioActual, $mesActual) 
            : [7, 8, 9, 10, 13, 14];

        // Cargar la vista del home, pasando las variables
        require_once BASE_PATH . '/app/Views/modules/home.php';
    }

    private function getSpanishMonthName(int $monthNumber): string {
        $months = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
        return $months[$monthNumber] ?? 'Desconocido';
    }
}