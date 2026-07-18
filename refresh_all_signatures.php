<?php
/**
 * Script para recalcular y corregir todas las firmas de integridad en la base de datos.
 * Ejecutar desde la línea de comandos: php refresh_all_signatures.php
 */

require_once __DIR__ . '/app/Core/IError.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/Integrity.php';

use App\Core\Database;
use App\Core\Integrity;

try {
    $db = Database::getInstance();
    $tables = [
        'usuarios',
        'colaboradores',
        'planillas',
        'vacaciones',
        'cargos_historial'
    ];

    echo "Iniciando la actualización de firmas de integridad...\n\n";

    foreach ($tables as $table) {
        echo "Procesando tabla: {$table}...\n";
        $refreshed_count = Integrity::refreshTableSignatures($db, $table);
        echo "-> Se actualizaron {$refreshed_count} registros en '{$table}'.\n\n";
    }

    echo "Proceso de actualización de integridad completado.\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}