<?php
// public/reset.php
require_once __DIR__ . '/../app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance();

    // 1. Reactivar la cuenta (activo = 1) y eliminar cualquier bloqueo temporal
    $db->exec("UPDATE usuarios SET activo = 1, bloqueado_hasta = NULL WHERE username = 'admin'");

    // 2. Limpiar la tabla de logs para que el contador de intentos vuelva a 0
    $db->exec("DELETE FROM login_logs WHERE username = 'admin'");

    // 3. Generar un hash válido y real usando el motor de PHP
    $password_real = 'Admin1234!';
    $hash = password_hash($password_real, PASSWORD_DEFAULT);
    
    // 4. Actualizar la contraseña en la base de datos
    $stmt = $db->prepare("UPDATE usuarios SET password = :hash WHERE username = 'admin'");
    $stmt->execute(['hash' => $hash]);

    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2 style='color: green;'>¡Sistema reparado con éxito!</h2>";
    echo "<p>La cuenta <b>admin</b> ha sido desbloqueada.</p>";
    echo "<p>La contraseña ahora es oficialmente: <b>Admin1234!</b></p>";
    echo "<a href='/login' style='padding: 10px 20px; background: #0056b3; color: white; text-decoration: none; border-radius: 5px;'>Ir al Login</a>";
    echo "</div>";

} catch (Exception $e) {
    echo "Error de base de datos: " . $e->getMessage();
}