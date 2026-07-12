<?php
/**
 * Sistema de Gestión de Capital Humano
 * @author Luis Alberto De Los Rios
 * @colaboradores Jeremías Donoso, Juan Segundo
 * Institución: Universidad Tecnológica de Panamá
 */

namespace App\Core;

use PDO;
use PDOException;
use App\Core\IError;

// Implementamos la interfaz para cumplir con el Criterio 20
class Database implements IError {
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            // OWASP: En un entorno real, esto vendría de un archivo config.php o .env
            $config = [
                'host' => 'localhost',
                'db_name' => 'capital_humano',
                'username' => 'root',
                'password' => '07280408luis'
            ];

            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset=utf8mb4"; 
                self::$instance = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false 
                ]);
            } catch (PDOException $e) {
                // Instanciamos la clase para poder usar el método de la interfaz
                $logger = new self();
                $logger->logError($e->getMessage(), $e->getFile(), $e->getLine());
                die($logger->displayError()); 
            }
        }
        return self::$instance;
    }

    protected function __clone() {}

    // --- Implementación de los métodos de la Interfaz IError ---
    public function logError(string $message, string $file, int $line): void {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] ERROR BDD: $message en $file (Línea $line)\n";
        // Guardar el error en un archivo txt oculto para que no lo vean los usuarios
        error_log($logMessage, 3, __DIR__ . '/../../logs/db_errors.log');
    }

    public function displayError(): string {
        return "Ha ocurrido un error crítico al conectar con la base de datos. Por favor, contacte a soporte.";
    }
}