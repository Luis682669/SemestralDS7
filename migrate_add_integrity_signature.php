<?php
// Script de migración para crear columnas integrity_signature en tablas críticas.

define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/app/Core/IError.php';
require_once BASE_PATH . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    $tables = [
        'usuarios' => 'rol_id',
        'colaboradores' => 'historial_academico_pdf',
        'planillas' => 'salario_neto',
        'vacaciones' => 'motivo',
        'cargos_historial' => 'es_activo'
    ];

    foreach ($tables as $table => $afterColumn) {
        $sql = sprintf(
            'ALTER TABLE %s ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER %s',
            $table,
            $afterColumn
        );

        try {
            $db->exec($sql);
            echo "Columna integrity_signature añadida en tabla {$table}.\n";
        } catch (PDOException $e) {
            if (stripos($e->getMessage(), 'duplicate column name') !== false || stripos($e->getMessage(), 'already exists') !== false) {
                echo "La columna integrity_signature ya existe en tabla {$table}.\n";
            } else {
                throw $e;
            }
        }
    }

    echo "Migración completada.\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}
