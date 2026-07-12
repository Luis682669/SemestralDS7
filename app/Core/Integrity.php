<?php
namespace App\Core;

class Integrity {
    private const DEFAULT_SECRET = 'capitalhumano_integrity_secret_2026';
    private static ?string $secretKey = null;
    private static array $tableColumnsCache = [];

    public static function getSecretKey(): string {
        if (self::$secretKey !== null) {
            return self::$secretKey;
        }

        $envKey = getenv('INTEGRITY_SECRET');
        self::$secretKey = $envKey !== false && $envKey !== '' ? $envKey : self::DEFAULT_SECRET;

        return self::$secretKey;
    }

    public static function getTableColumns(\PDO $db, string $table): array {
        $table = self::sanitizeIdentifier($table);

        if (isset(self::$tableColumnsCache[$table])) {
            return self::$tableColumnsCache[$table];
        }

        $columns = [];
        $stmt = $db->query("SHOW COLUMNS FROM {$table}");
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $col) {
            if (!in_array($col['Field'], ['id', self::getSignatureField()], true)) {
                $columns[] = $col['Field'];
            }
        }

        self::$tableColumnsCache[$table] = $columns;
        return $columns;
    }

    public static function buildPayload(array $fields): string {
        ksort($fields);
        $parts = [];
        foreach ($fields as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            $parts[] = $key . '=' . (string)$value;
        }

        return implode('|', $parts);
    }

    public static function getSignatureField(): string {
        return 'integrity_signature';
    }

    public static function signRecord(array $fields): string {
        $payload = self::buildPayload($fields);
        return base64_encode(hash_hmac('sha256', $payload, self::getSecretKey(), true));
    }

    public static function verifyRecord(array $fields, string $signature): bool {
        return hash_equals(self::signRecord($fields), $signature);
    }

    private static function sanitizeIdentifier(string $value): string {
        $clean = preg_replace('/[^a-zA-Z0-9_]/', '', $value);
        if ($clean === '') {
            throw new \InvalidArgumentException('Identificador de tabla/columna inválido para Integrity.');
        }
        return $clean;
    }

    public static function updateSignature(\PDO $db, string $table, string $idColumn, int|string $id, array $payload): bool {
        $table = self::sanitizeIdentifier($table);
        $idColumn = self::sanitizeIdentifier($idColumn);

        $signature = self::signRecord($payload);
        $stmt = $db->prepare("UPDATE {$table} SET " . self::getSignatureField() . " = :signature WHERE {$idColumn} = :id");
        return $stmt->execute(['signature' => $signature, 'id' => $id]);
    }

    public static function refreshRowSignature(\PDO $db, string $table, string $idColumn, int|string $id): bool {
        $table = self::sanitizeIdentifier($table);
        $idColumn = self::sanitizeIdentifier($idColumn);

        $stmt = $db->prepare("SELECT * FROM {$table} WHERE {$idColumn} = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return false;
        }

        $signature = self::signRecord(self::getRowPayloadFields($row, self::getTableColumns($db, $table)));
        $stmt = $db->prepare("UPDATE {$table} SET " . self::getSignatureField() . " = :signature WHERE {$idColumn} = :id");
        return $stmt->execute(['signature' => $signature, 'id' => $id]);
    }

    public static function refreshTableSignatures(\PDO $db, string $table, string $idColumn = 'id'): int {
        $table = self::sanitizeIdentifier($table);
        $idColumn = self::sanitizeIdentifier($idColumn);

        $stmt = $db->query("SELECT {$idColumn} FROM {$table}");
        $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);

        $count = 0;
        foreach ($ids as $id) {
            if (self::refreshRowSignature($db, $table, $idColumn, $id)) {
                $count++;
            }
        }

        return $count;
    }

    public static function getRowPayloadFields(array $row, array $allowedColumns = []): array {
        $signatureKey = self::getSignatureField();
        $payload = [];

        foreach ($row as $key => $value) {
            if (!is_string($key) || $key === $signatureKey || $key === 'id') {
                continue;
            }
            if (!empty($allowedColumns) && !in_array($key, $allowedColumns, true)) {
                continue;
            }
            $payload[$key] = $value;
        }

        return $payload;
    }

    public static function verifyRow(array $row, string $table, string|int $id, ?\PDO $db = null): void {
        $signatureKey = self::getSignatureField();
        if (!array_key_exists($signatureKey, $row) || $row[$signatureKey] === null || $row[$signatureKey] === '') {
            return; // No signature present yet; the row may predate the integrity layer
        }

        $signature = (string)$row[$signatureKey];
        $allowedColumns = [];

        if ($db !== null) {
            $allowedColumns = self::getTableColumns($db, $table);
        }

        $payloadFields = self::getRowPayloadFields($row, $allowedColumns);

        if (!self::verifyRecord($payloadFields, $signature)) {
            $payload = self::buildPayload($payloadFields);
            self::handleViolation($table, $id, $payload, $signature);
        }
    }

    public static function signRow(array $row): string {
        $payloadFields = self::getRowPayloadFields($row);
        return self::signRecord($payloadFields);
    }

    public static function handleViolation(string $table, string|int $id, string $payload, string $signature): void {
        $message = sprintf(
            "[%s] Violación de integridad en tabla %s id=%s payload=%s firma=%s\n",
            date('Y-m-d H:i:s'),
            $table,
            $id,
            $payload,
            $signature
        );

        $logDir = __DIR__ . '/../../logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        error_log($message, 3, $logDir . '/integrity_violations.log');

        http_response_code(500);
        die('Alerta de integridad: registro corrupto detectado en ' . $table . ' #' . $id . '. Operación cancelada.');
    }
}
