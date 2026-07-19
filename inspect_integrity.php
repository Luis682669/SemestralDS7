<?php
require_once __DIR__ . '/app/Core/IError.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance();
// Verificar la integridad de la tabla cargos_historial
$tables = ['cargos_historial', 'colaboradores', 'vacaciones', 'planillas', 'usuarios'];
foreach ($tables as $table) {
    echo "\n--- $table schema ---\n";
    foreach ($db->query("SHOW COLUMNS FROM $table") as $col) {
        echo $col['Field'] . ' ' . $col['Type'] . ' ' . $col['Null'] . ' ' . $col['Key'] . ' ' . ($col['Default'] ?? 'NULL') . ' ' . ($col['Extra'] ?? '') . "\n";
    }
}

echo "\n--- cargos_historial row #4 ---\n";
$stmt = $db->prepare('SELECT * FROM cargos_historial WHERE id = ?');
$stmt->execute([4]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "not found\n";
    exit;
}
print_r($row);

require_once __DIR__ . '/app/Core/Integrity.php';
$payload = [];
foreach ($row as $key => $value) {
    if ($key === 'integrity_signature' || $key === 'id') {
        continue;
    }
    $payload[$key] = $value;
}
ksort($payload);

$expected = App\Core\Integrity::signRecord($payload);
echo "expected_signature={$expected}\n";
echo "stored_signature={$row['integrity_signature']}\n";
var_export($payload);
