<?php
namespace App\Controllers;

use App\Models\Reporte;
use App\Models\Vacacion;

class HomeController {
    private Reporte $reporteModel;
    private Vacacion $vacacionModel;

    public function __construct(Reporte $reporteModel, Vacacion $vacacionModel) {
        $this->reporteModel = $reporteModel;
        $this->vacacionModel = $vacacionModel;
    }

    public function index(): void {
        // Obtenemos los datos para las tarjetas de estadísticas
        $totalColaboradores = $this->reporteModel->countActiveCollaborators();
        $solicitudesPendientes = $this->vacacionModel->countPendingRequests();

        // Obtenemos datos para la gráfica de distribución por sexo
        $distribucionSexo = $this->reporteModel->getCollaboratorGenderCounts();
        $chartSexoLabels = json_encode(array_column($distribucionSexo, 'sexo'));
        $chartSexoData = json_encode(array_column($distribucionSexo, 'total'));

        // Obtenemos datos para la gráfica de distribución por edad
        $distribucionEdad = $this->reporteModel->getCollaboratorAgeRanges();
        // Limpiamos y preparamos los datos para la gráfica
        $chartEdadLabels = json_encode(array_keys($distribucionEdad));
        $chartEdadData = json_encode(array_values($distribucionEdad));

        // Obtenemos las últimas 5 solicitudes de vacaciones para la tabla de actividad reciente
        $actividadReciente = array_slice($this->vacacionModel->getAll(), 0, 5);

        require_once BASE_PATH . '/app/Views/modules/home.php';
    }
}