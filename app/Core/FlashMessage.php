<?php
namespace App\Core;

/**
 * Clase para gestionar mensajes flash (notificaciones de sesión).
 * Los mensajes se muestran una vez y luego se eliminan.
 */
class FlashMessage {
    private const FLASH_KEY = 'flash_messages';

    /**
     * Establece un mensaje flash en la sesión.
     * @param string $key Tipo de mensaje (ej: 'success', 'error', 'warning').
     * @param string $message El mensaje a mostrar.
     */
    public static function set(string $key, string $message): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::FLASH_KEY][$key] = $message;
    }

    /**
     * Muestra un mensaje flash si existe para una clave dada.
     * El mensaje se elimina de la sesión después de ser obtenido.
     * @param string $key La clave del mensaje a mostrar.
     */
    public static function display(string $key): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            $message = $_SESSION[self::FLASH_KEY][$key];
            unset($_SESSION[self::FLASH_KEY][$key]);

            $alertClass = 'alert-info'; // Clase por defecto
            if ($key === 'success') $alertClass = 'alert-success';
            if ($key === 'error') $alertClass = 'alert-danger';
            if ($key === 'warning') $alertClass = 'alert-warning';

            // Usamos un estilo similar al de la aplicación para consistencia visual.
            echo "<div class='alert {$alertClass}' role='alert' style='margin-bottom: 20px; border-radius: 10px; padding: 15px; border: 1px solid transparent;'>{$message}</div>";
        }
    }
}