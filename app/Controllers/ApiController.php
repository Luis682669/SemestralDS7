<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Core\Response;
use App\Models\Colaborador;
use App\Core\Auth;

class ApiController {
    private Colaborador $colaboradorModel;

    public function __construct(Colaborador $colaboradorModel) {
        $this->colaboradorModel = $colaboradorModel;
    }

    private function deny(string $message = 'Acceso no autorizado'): void {
        Response::error($message, 403);
    }

    public function colaboradoresPorSexo(): void {
        // 1. Obtener las claves de las cabeceras de la solicitud
        $publicKey = $_SERVER['HTTP_X_API_KEY'] ?? null;
        $privateKey = $_SERVER['HTTP_X_API_SECRET'] ?? null;

        if (!$publicKey || !$privateKey) {
            $this->deny('Autenticación fallida: Faltan claves de API.');
        }

        // 2. Buscar al usuario por su clave pública
        $userModel = new Usuario($this->colaboradorModel->db); // Asumiendo que el modelo tiene una propiedad pública `db`
        $user = $userModel->findByPublicKey($publicKey);

        // 3. Verificar la clave privada y el rol del usuario
        if (!$user || !Auth::verifyPassword($privateKey, $user['api_key_private_hash'])) {
            $this->deny('Autenticación fallida: Claves de API inválidas.');
        }

        // 4. Aplicar la lógica de negocio: solo Contraloría puede acceder
        if ($user['rol_id'] !== 3) {
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
