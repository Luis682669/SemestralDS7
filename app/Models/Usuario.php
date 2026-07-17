<?php
/**
 * Copyright (c) 2026.
 * Proyecto Semestral Capital Humano
 * Universidad Tecnológica de Panamá
 * Autores: Luis De Los Rios, Jeremías Donoso, Lionel Cordoba, Juan Segundo
 */
 
namespace App\Models;

use PDO;
use App\Core\Auth;
use App\Core\Integrity;

class Usuario {
    private PDO $db;

    // SOLID: Recibimos la conexión ya lista desde afuera
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByUsername(string $username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch();
        if ($row && !empty($row[Integrity::getSignatureField()])) {
            Integrity::verifyRow($row, 'usuarios', $row['id']);
        }
        return $row;
    }

    public function logLoginAttempt(string $username, string $ip, bool $exitoso): void {
        $estado = $exitoso ? 1 : 0;
        $stmt = $this->db->prepare("INSERT INTO login_logs (username, ip, exitoso) VALUES (:username, :ip, :exitoso)");
        $stmt->execute([
            'username' => $username,
            'ip' => $ip,
            'exitoso' => $estado
        ]);
    }

    /**
     * Cuenta los intentos fallidos en los últimos 15 minutos (Versión MySQL)
     */
    public function countFailedAttempts(string $username): int {
        // En MySQL usamos DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM login_logs 
            WHERE username = :username 
            AND exitoso = 0 
            AND fecha >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        ");
        $stmt->execute(['username' => $username]);
        return (int) $stmt->fetchColumn();
    }

    public function getConsecutiveFailedAttempts(string $username, int $limit = 3): int {
        $limit = max(1, min(10, $limit));
        $sql = "SELECT exitoso FROM login_logs WHERE username = :username ORDER BY fecha DESC LIMIT $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        $rows = $stmt->fetchAll();

        $consecutiveFails = 0;
        foreach ($rows as $row) {
            if ((int)$row['exitoso'] === 0) {
                $consecutiveFails++;
            } else {
                break;
            }
        }

        return $consecutiveFails;
    }

    public function blockUserUntil(string $username, string $datetime): void {
        $stmt = $this->db->prepare("UPDATE usuarios SET bloqueado_hasta = :datetime WHERE username = :username");
        $stmt->execute(['datetime' => $datetime, 'username' => $username]);
    }

    public function clearBlock(string $username): void {
        $stmt = $this->db->prepare("UPDATE usuarios SET bloqueado_hasta = NULL WHERE username = :username");
        $stmt->execute(['username' => $username]);
    }

    public function isBlocked(array $user): bool {
        if (empty($user['bloqueado_hasta'])) {
            return false;
        }

        $blockedUntil = new \DateTime($user['bloqueado_hasta']);
        return $blockedUntil > new \DateTime();
    }

    public function getBlockedUntil(array $user): ?string {
        return $user['bloqueado_hasta'] ?? null;
    }

    public function blockUser(string $username): void {
        $stmt = $this->db->prepare("UPDATE usuarios SET activo = 0 WHERE username = :username");
        $stmt->execute(['username' => $username]);
    }
    /**
     * Obtiene todos los usuarios con su rol correspondiente (CRUD - Consultas)
     */
    public function getAllUsers(): array {
        $stmt = $this->db->query("
            SELECT u.id, u.username, u.activo, u.creado_en, r.nombre as rol_nombre 
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.id
            ORDER BY u.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene todos los roles disponibles para el formulario de Alta
     */
    public function getRoles(): array {
        $stmt = $this->db->query("SELECT * FROM roles ORDER BY nivel_acceso ASC");
        return $stmt->fetchAll();
    }

    /**
     * Registra un nuevo usuario encriptando su contraseña (CRUD - Create)
     */
    public function createUser(string $username, string $password, int $rol_id): array|false {
        // 1. Verificar que el usuario no exista previamente
        $stmtCheck = $this->db->prepare("SELECT id FROM usuarios WHERE username = :username LIMIT 1");
        $stmtCheck->execute(['username' => $username]);
        if ($stmtCheck->fetch()) {
            return false;
        }

        // 2. Encriptar la contraseña (Regla de Seguridad OWASP)
        $hash = Auth::hashPassword($password);

        // 3. Generar claves de API únicas para el nuevo usuario
        $api_key_public = 'pub_' . bin2hex(random_bytes(16));
        $api_key_private_plain = 'priv_' . bin2hex(random_bytes(24));
        $api_key_private_hash = Auth::hashPassword($api_key_private_plain);

        // 4. Insertar en la base de datos
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (username, password, rol_id, api_key_public, api_key_private_hash) 
             VALUES (:username, :password, :rol_id, :api_key_public, :api_key_private_hash)"
        );

        if ($stmt->execute([
            'username' => $username,
            'password' => $hash,
            'rol_id' => $rol_id,
            'api_key_public' => $api_key_public,
            'api_key_private_hash' => $api_key_private_hash
        ])) {
            $id = (int)$this->db->lastInsertId();
            Integrity::refreshRowSignature($this->db, 'usuarios', 'id', $id);
            
            // Devolvemos las claves para que se puedan mostrar al usuario UNA SOLA VEZ.
            return [
                'success' => true,
                'api_key_public' => $api_key_public,
                'api_key_private_plain' => $api_key_private_plain
            ];
        }

        return false;
    }

    /**
     * Desactiva un usuario de forma lógica sin eliminarlo (Soft Delete - Punto 2)
     */
    public function deactivateUser(int $id): bool {
        $user = $this->findById($id);
        if (!$user) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE usuarios SET activo = 0 WHERE id = :id");
        if ($stmt->execute(['id' => $id])) {
            return Integrity::refreshRowSignature($this->db, 'usuarios', 'id', $id);
        }

        return false;
    }

    public function findById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if ($row && !empty($row[Integrity::getSignatureField()])) {
            Integrity::verifyRow($row, 'usuarios', $row['id']);
        }
        return $row;
    }
    /**
     * Verifica las credenciales del usuario para el Login
     */
    public function authenticate(string $username, string $password) {
        $user = $this->findByUsername($username);
        if (!$user || $user['activo'] != 1) {
            return false;
        }

        if (Auth::verifyPassword($password, $user['password'])) {
            return $user; // Credenciales correctas
        }

        return false; // Credenciales incorrectas
    }

    /**
     * Busca un usuario por su API Key pública.
     */
    public function findByPublicKey(string $publicKey) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE api_key_public = :publicKey AND activo = 1 LIMIT 1");
        $stmt->execute(['publicKey' => $publicKey]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}