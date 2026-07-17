<?php
// Script de migración para añadir columnas de API a la tabla de usuarios.

define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/app/Core/IError.php';
require_once BASE_PATH . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    $sql = "
        ALTER TABLE usuarios
        ADD COLUMN api_key_public VARCHAR(255) NULL UNIQUE AFTER rol_id,
        ADD COLUMN api_key_private_hash VARCHAR(255) NULL AFTER api_key_public;
    ";

    try {
        $db->exec($sql);
        echo "Columnas 'api_key_public' y 'api_key_private_hash' añadidas a la tabla 'usuarios'.\n";
    } catch (PDOException $e) {
        if (
            stripos($e->getMessage(), 'duplicate column name') !== false || 
            stripos($e->getMessage(), 'already exists') !== false
        ) {
            echo "Las columnas de API ya existen en la tabla 'usuarios'.\n";
        } else {
            throw $e;
        }
    }

    echo "Migración de claves de API completada.\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}