<?php
namespace App\Controllers;

use App\Core\Security;
use App\Core\Auth;

class LoginController {
    private $usuarioModel;

    public function __construct($usuarioModel) {
        $this->usuarioModel = $usuarioModel;
    }

    public function index() {
        // Genera el token y lo envía a la vista
        $csrf_token = Security::generateCSRFToken();
        $error = "";
        require_once BASE_PATH . '/app/Views/modules/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Validar el token de seguridad
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');

            // 2. Sanitizar datos
            $username = Security::sanitizeString($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $user = $this->usuarioModel->findByUsername($username);
            $blocked = false;
            $message = 'Usuario o contraseña incorrectos.';

            if ($user) {
                if ($this->usuarioModel->isBlocked($user)) {
                    $blocked = true;
                    $blockedUntil = $this->usuarioModel->getBlockedUntil($user);
                    $message = 'Cuenta bloqueada temporalmente hasta ' . $blockedUntil . '.';
                    $this->usuarioModel->logLoginAttempt($username, $ip, false);
                } elseif ($user['activo'] != 1) {
                    $this->usuarioModel->logLoginAttempt($username, $ip, false);
                    $message = 'Usuario desactivado o no autorizado.';
                } elseif (Auth::verifyPassword($password, $user['password'])) {
                    $this->usuarioModel->logLoginAttempt($username, $ip, true);
                    $this->usuarioModel->clearBlock($username);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['rol_id'] = $user['rol_id'];
                    header('Location: /home');
                    exit;
                } else {
                    $this->usuarioModel->logLoginAttempt($username, $ip, false);

                    $fails = $this->usuarioModel->getConsecutiveFailedAttempts($username, 3);
                    if ($fails >= 3) {
                        $blockUntil = (new \DateTime())->modify('+15 minutes')->format('Y-m-d H:i:s');
                        $this->usuarioModel->blockUserUntil($username, $blockUntil);
                        $message = 'Cuenta bloqueada temporalmente por 15 minutos debido a 3 intentos fallidos consecutivos.';
                    }
                }
            } else {
                $this->usuarioModel->logLoginAttempt($username, $ip, false);
            }

            $error = $message;
            $csrf_token = Security::generateCSRFToken();
            require_once BASE_PATH . '/app/Views/modules/login.php';
        }
    }
}