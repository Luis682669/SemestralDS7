<?php
namespace App\Controllers;

use App\Models\Colaborador;
use App\Models\Usuario;
use App\Core\Response;
use App\Core\Auth;

class ApiController {
    private Colaborador $colaboradorModel;
    private Usuario $usuarioModel;

    public function __construct(Colaborador $colaboradorModel, Usuario $usuarioModel) {
        $this->colaboradorModel = $colaboradorModel;
        $this->usuarioModel = $usuarioModel;
    }

    private function deny(string $message = 'Acceso no autorizado'): void {
        Response::error($message, 403);
    }

    private function getPublicKeyFromHeader(): ?string {
        // Primero, intenta leer el encabezado estándar 'Authorization: Bearer <token>'
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if (preg_match('/^Bearer\s+(.*)$/i', $authHeader, $matches)) {
                return $matches[1];
            }
        }

        // Como alternativa, lee el encabezado personalizado 'X-Api-Key'
        if (isset($_SERVER['HTTP_X_API_KEY'])) {
            return $_SERVER['HTTP_X_API_KEY'];
        }

        return null;
    }

    public function colaboradoresPorSexo(): void {
        // 1. Obtener las claves de las cabeceras de la solicitud
        $publicKey = $this->getPublicKeyFromHeader();
        $privateKey = $_SERVER['HTTP_X_API_SECRET'] ?? null;

        if (!$publicKey || !$privateKey) {
            $this->deny('Autenticación fallida: Faltan claves de API. Se requiere "Authorization: Bearer <clave_publica>" y "X-Api-Secret: <clave_privada>".');
        }

        // 2. Buscar al usuario por su clave pública
        $user = $this->usuarioModel->findByPublicKey($publicKey);

        // 3. Verificar la clave privada y el rol del usuario
        if (!$user) {
            $this->deny('Autenticación fallida: La clave pública proporcionada no fue encontrada o el usuario está inactivo.');
        }

        if (empty($user['api_key_private_hash']) || !Auth::verifyPassword($privateKey, $user['api_key_private_hash'])) {
            $this->deny('Autenticación fallida: La clave privada es incorrecta.');
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
