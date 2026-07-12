<?php
namespace App\Models;

class Reporte {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function countActiveCollaborators(): int {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM colaboradores WHERE empleado_activo = 1");
        return (int) $stmt->fetchColumn();
    }

    public function getActiveCollaboratorsPage(int $offset, int $limit): array {
        $stmt = $this->db->prepare("SELECT id, identificacion, primer_nombre, primer_apellido, sexo, fecha_nacimiento, departamento, estatus
            FROM colaboradores
            WHERE empleado_activo = 1
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCollaboratorGenderCounts(): array {
        $stmt = $this->db->query("SELECT IFNULL(sexo, 'Otro') AS sexo, COUNT(*) AS total FROM colaboradores WHERE empleado_activo = 1 GROUP BY sexo");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCollaboratorAgeRanges(): array {
        $stmt = $this->db->query("SELECT
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 18 AND 24 THEN 1 ELSE 0 END) AS age_18_24,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 25 AND 30 THEN 1 ELSE 0 END) AS age_25_30,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) AS age_31_40,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) AS age_41_50,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 51 THEN 1 ELSE 0 END) AS age_51_plus
            FROM colaboradores
            WHERE empleado_activo = 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getCollaboratorById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM colaboradores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getCollaboratorsListing(): array {
        $stmt = $this->db->query("SELECT identificacion, primer_nombre, primer_apellido, departamento, estatus FROM colaboradores ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getVacationReports(): array {
        $stmt = $this->db->query("SELECT v.id, v.fecha_inicio, v.fecha_fin, v.dias_disfrutados, v.estado, v.motivo, c.identificacion, c.primer_nombre, c.primer_apellido
            FROM vacaciones v
            JOIN colaboradores c ON v.colaborador_id = c.id
            ORDER BY v.fecha_registro DESC");
        return $stmt->fetchAll();
    }
}
