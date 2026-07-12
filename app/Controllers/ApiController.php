<?php
namespace App\Controllers;

use App\Core\Response;
use App\Models\Colaborador;

class ApiController {
    private Colaborador $colaboradorModel;

    public function __construct(Colaborador $colaboradorModel) {
        $this->colaboradorModel = $colaboradorModel;
    }

    private function deny(string $message = 'Acceso no autorizado'): void {
        Response::error($message, 403);
    }

    public function colaboradoresPorSexo(): void {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol_id'])) {
            $this->deny('No autenticado');
        }

        if ($_SESSION['rol_id'] !== 3) {
            $this->deny('Solo Contraloría General puede acceder a esta API');
        }

        $data = $this->colaboradorModel->getActiveGenderCounts();

        $response = [
            'meta' => [
                'endpoint' => '/api/colaboradores/sexo',
                'timestamp' => date('c'),
                'total_sexo' => array_sum(array_column($data, 'total'))
            ],
            'data' => $data
        ];

        Response::json($response);
    }
}
