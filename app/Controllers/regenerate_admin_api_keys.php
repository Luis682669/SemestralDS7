<?php
// Script para regenerar las claves de API para el usuario 'admin'.

define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/app/Core/IError.php';
require_once BASE_PATH . '/app/Core/Database.php';
require_once BASE_PATH . '/app/Core/Auth.php';

use App\Core\Database;
use App\Core\Auth;

try {
    $db = Database::getInstance();
    $username = 'admin';

    // 1. Generar nuevas claves de API
    $new_public_key = 'pub_' . bin2hex(random_bytes(16));
    $new_private_key_plain = 'priv_' . bin2hex(random_bytes(24));
    $new_private_key_hash = Auth::hashPassword($new_private_key_plain);

    // 2. Actualizar el usuario en la base de datos
    $stmt = $db->prepare(
        "UPDATE usuarios 
         SET api_key_public = :api_key_public, api_key_private_hash = :api_key_private_hash, activo = 1 
         WHERE username = :username"
    );

    $stmt->execute([
        'api_key_public' => $new_public_key,
        'api_key_private_hash' => $new_private_key_hash,
        'username' => $username
    ]);

    if ($stmt->rowCount() > 0) {
        echo "¡Claves de API para el usuario '{$username}' regeneradas con éxito!\n\n";
        echo "Por favor, usa estas nuevas claves en Postman:\n";
        echo "--------------------------------------------------\n";
        echo "Cabecera X-Api-Key:   {$new_public_key}\n";
        echo "Cabecera X-Api-Secret: {$new_private_key_plain}\n";
        echo "--------------------------------------------------\n";
    } else {
        echo "Error: No se pudo encontrar al usuario '{$username}' o no se realizaron cambios.\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}