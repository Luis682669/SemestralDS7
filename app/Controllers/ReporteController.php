<?php
namespace App\Controllers;

require_once BASE_PATH . '/app/Core/fpdf.php'; // Ajusta la ruta según donde guardaste la librería

use App\Models\Reporte;

class ReporteController {
    private Reporte $reporteModel;

    public function __construct(Reporte $reporteModel) {
        $this->reporteModel = $reporteModel;
    }
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $pageSize = 8;

        $total = $this->reporteModel->countActiveCollaborators();
        $totalPages = max(1, (int)ceil($total / $pageSize));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $pageSize;

        $colaboradores = $this->reporteModel->getActiveCollaboratorsPage($offset, $pageSize);
        $colaboradoresBySexo = $this->reporteModel->getCollaboratorGenderCounts();
        $colaboradoresByAge = $this->reporteModel->getCollaboratorAgeRanges();

        require_once BASE_PATH . '/app/Views/modules/reportes/index.php';
    }

    public function generarFichaColaborador() {
        $id = $_GET['id'] ?? 0;
        $colab = $this->reporteModel->getCollaboratorById((int)$id);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Ficha de Colaborador', 0, 1, 'C');
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nombre: ' . $this->encodeText($colab['primer_nombre'] . ' ' . $colab['primer_apellido']), 0, 1);
        $pdf->Cell(0, 10, 'Cedula: ' . $this->encodeText($colab['identificacion']), 0, 1);
        $pdf->Cell(0, 10, 'Departamento: ' . $this->encodeText($colab['departamento']), 0, 1);
        $pdf->Cell(0, 10, 'Estado: ' . $this->encodeText($colab['estatus'] ?? 'Activo'), 0, 1);
        
        $pdf->Output('I', 'Ficha_' . $colab['identificacion'] . '.pdf');
    }
    public function generarListadoColaboradores() {
        // Obtenemos todos los colaboradores
        $colaboradores = $this->reporteModel->getCollaboratorsListing();

        $pdf = new \FPDF();
        $pdf->AddPage();
        
        // Título del documento
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Listado General de Colaboradores', 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezados de la tabla (con color de fondo)
        $pdf->SetFillColor(230, 240, 255);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(35, 10, 'Cedula', 1, 0, 'C', true);
        $pdf->Cell(75, 10, 'Nombre Completo', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Departamento', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', true);

        // Imprimir los datos de cada colaborador
        $pdf->SetFont('Arial', '', 10);
        if ($colaboradores) {
            foreach ($colaboradores as $c) {
                $nombreCompleto = $this->encodeText($c['primer_nombre'] . ' ' . $c['primer_apellido']);
                $departamento = $this->encodeText($c['departamento']);
                $estado = $this->encodeText($c['estatus'] ?? 'Activo');

                $pdf->Cell(35, 10, $this->encodeText($c['identificacion']), 1, 0, 'C');
                $pdf->Cell(75, 10, $nombreCompleto, 1, 0, 'L');
                $pdf->Cell(50, 10, $departamento, 1, 0, 'C');
                $pdf->Cell(30, 10, $estado, 1, 1, 'C');
            }
        } else {
            $pdf->Cell(190, 10, 'No hay colaboradores registrados.', 1, 1, 'C');
        }

        // Generar y mostrar el PDF en el navegador
        $this->ensureNoOutputBeforePDF();
        $pdf->Output('I', 'Listado_Colaboradores.pdf');
    }

    public function generarReporteVacaciones() {
        $solicitudes = $this->reporteModel->getVacationReports();

        $pdf = new \FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Reporte de Resueltos de Vacaciones', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFillColor(230, 240, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 10, 'Cedula', 1, 0, 'C', true);
        $pdf->Cell(55, 10, 'Colaborador', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Inicio', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Fin', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Días', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Estado', 1, 0, 'C', true);
        $pdf->Cell(0, 10, 'Motivo', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 9);
        if ($solicitudes) {
            foreach ($solicitudes as $s) {
                $nombre = $this->encodeText($s['primer_nombre'] . ' ' . $s['primer_apellido']);
                $motivo = $this->encodeText($s['motivo'] ?: '-');
                $estado = $this->encodeText($s['estado']);

                $pdf->Cell(25, 10, $this->encodeText($s['identificacion']), 1, 0, 'C');
                $pdf->Cell(55, 10, $nombre, 1, 0, 'L');
                $pdf->Cell(30, 10, $this->encodeText($s['fecha_inicio']), 1, 0, 'C');
                $pdf->Cell(30, 10, $this->encodeText($s['fecha_fin']), 1, 0, 'C');
                $pdf->Cell(20, 10, $this->encodeText((string)$s['dias_disfrutados']), 1, 0, 'C');
                $pdf->Cell(30, 10, $estado, 1, 0, 'C');
                $pdf->Cell(0, 10, $motivo, 1, 1, 'L');
            }
        } else {
            $pdf->Cell(190, 10, 'No hay solicitudes de vacaciones registradas.', 1, 1, 'C');
        }

        $this->ensureNoOutputBeforePDF();
        $pdf->Output('I', 'Reporte_Vacaciones.pdf');
    }

    private function ensureNoOutputBeforePDF(): void {
        if (headers_sent($file, $line)) {
            throw new \Exception('FPDF error: output already sent before generating PDF in ' . $file . ' on line ' . $line);
        }
        if (ob_get_length() !== false && ob_get_length() > 0) {
            ob_end_clean();
        }
    }

    private function encodeText(string $text): string {
        return mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
    }
}