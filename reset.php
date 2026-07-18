<?php
// public/reset.php
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Integrity.php';

try {
    $db = \App\Core\Database::getInstance();

    // Obtener el ID del usuario admin para asegurar la operación
    $stmt = $db->prepare("SELECT id FROM usuarios WHERE username = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch();

    if (!$admin) {
        die("Error: Usuario 'admin' no encontrado.");
    }
    $admin_id = $admin['id'];

    // 1. Reactivar la cuenta y limpiar bloqueos
    $db->exec("UPDATE usuarios SET activo = 1, bloqueado_hasta = NULL WHERE id = {$admin_id}");
    // 2. Limpiar historial de intentos de login
    $db->exec("DELETE FROM login_logs WHERE username = 'admin'");
    
    // 3. Actualizar la contraseña
    $password_real = 'Admin1234!';
    $hash = password_hash($password_real, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE usuarios SET password = :hash WHERE id = :id");
    $stmt->execute(['hash' => $hash, 'id' => $admin_id]);

    // 4. **CRÍTICO**: Refrescar la firma de integridad del registro modificado
    \App\Core\Integrity::refreshRowSignature($db, 'usuarios', 'id', $admin_id);

    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2 style='color: green;'>¡Sistema reparado con éxito!</h2>";
    echo "<p>La cuenta <b>admin</b> ha sido desbloqueada.</p>";
    echo "<p>La contraseña ahora es oficialmente: <b>Admin1234!</b></p>";
    echo "<a href='/login' style='padding: 10px 20px; background: #0056b3; color: white; text-decoration: none; border-radius: 5px;'>Ir al Login</a>";
    echo "</div>";
} catch (Exception $e) {
    echo "Error de base de datos: " . $e->getMessage();
}