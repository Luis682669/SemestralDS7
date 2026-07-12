<?php
namespace App\Core;

class Security {
    
    /**
     * Genera un token único para evitar ataques CSRF (OWASP)
     */
    public static function generateCSRFToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verifica que el token enviado desde el formulario sea válido
     */
    public static function validateCSRFToken(string $token): void {
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            die('Error de seguridad: Token CSRF inválido. Posible ataque zdetectado.');
        }
    }

    /**
     * Verifica que la longitud de la contraseña sea válida.
     */
    public static function validatePasswordLength(string $password): bool {
        $length = mb_strlen($password);
        return $length >= 8 && $length <= 12;
    }

    /**
     * Sanitiza los datos de entrada para evitar ataques XSS y de Inyección (Punto 19)
     */
    public static function sanitizeString(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}