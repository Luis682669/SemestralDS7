<?php
namespace App\Core;

use App\Models\Usuario;

class Auth {
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    public static function attempt(Usuario $usuarioModel, string $username, string $password) {
        $user = $usuarioModel->findByUsername($username);
        if (!$user) {
            return false;
        }

        if (empty($user['password']) || !self::verifyPassword($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}
