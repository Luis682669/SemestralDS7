<?php
namespace App\Models;

use App\Core\Integrity;

class Vacacion {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    /**
     * Calcula los días de vacaciones disponibles (Punto 15)
     */
    public function calcularDiasDisponibles(int $colaborador_id, string $fecha_contratacion): int {
        $fecha_inicio = new \DateTime($fecha_contratacion);
        $hoy = new \DateTime();
        $dias_trabajados = $fecha_inicio->diff($hoy)->days;

        // Calculamos los días acumulados (1 por cada 11 trabajados) y redondeamos al entero más cercano
        $dias_acumulados = (int)round($dias_trabajados / 11);

        // Sumamos los días que ya se le han aprobado (usando tu columna dias_disfrutados)
        $stmt = $this->db->prepare("SELECT SUM(dias_disfrutados) as tomados FROM vacaciones WHERE colaborador_id = ? AND estado = 'Aprobada'");
        $stmt->execute([$colaborador_id]);
        $resultado = $stmt->fetch();
        
        $dias_tomados = $resultado['tomados'] ? (int)$resultado['tomados'] : 0;

        return max(0, $dias_acumulados - $dias_tomados);
    }

    /**
     * Registra una nueva solicitud de ausencia (Punto 14)
     */
    public function solicitar(int $colaborador_id, string $fecha_inicio, string $fecha_fin, int $dias_disfrutados, string $motivo = ''): bool {
        $stmt = $this->db->prepare("INSERT INTO vacaciones (colaborador_id, fecha_inicio, fecha_fin, dias_disfrutados, estado, motivo) VALUES (?, ?, ?, ?, 'Pendiente', ?)");
        if ($stmt->execute([$colaborador_id, $fecha_inicio, $fecha_fin, $dias_disfrutados, $motivo])) {
            $id = (int)$this->db->lastInsertId();
            Integrity::refreshRowSignature($this->db, 'vacaciones', 'id', $id);
            return true;
        }

        return false;
    }

    /**
     * Obtiene todas las solicitudes con los datos del colaborador
     */
    public function getAll(): array {
        $sql = "SELECT v.*, c.identificacion, c.primer_nombre, c.primer_apellido, c.fecha_contratacion 
                FROM vacaciones v 
                JOIN colaboradores c ON v.colaborador_id = c.id 
                ORDER BY v.fecha_registro DESC";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            if (!empty($row[Integrity::getSignatureField()])) {
                Integrity::verifyRow($row, 'vacaciones', $row['id'], $this->db);
            }
        }

        return $rows;
    }

    /**
     * Actualiza el estado de la solicitud (Aprobada / Rechazada)
     */
    public function actualizarEstado(int $id, string $estado): bool {
        $row = $this->getById($id);
        if (!$row) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE vacaciones SET estado = ? WHERE id = ?");
        if ($stmt->execute([$estado, $id])) {
            return Integrity::refreshRowSignature($this->db, 'vacaciones', 'id', $id);
        }

        return false;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM vacaciones WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Cuenta las solicitudes de vacaciones pendientes.
     */
    public function countPendingRequests(): int {
        $stmt = $this->db->query("SELECT COUNT(*) FROM vacaciones WHERE estado = 'Pendiente'");
        return (int) $stmt->fetchColumn();
    }
}