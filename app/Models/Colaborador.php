<?php
namespace App\Models;

use App\Core\Integrity;

class Colaborador {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    /**
     * Obtiene todos los colaboradores activos (Punto 4)
     */
    public function getAllActive(): array {
        $stmt = $this->db->query("SELECT * FROM colaboradores WHERE empleado_activo = 1 ORDER BY id DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            if (!empty($row[Integrity::getSignatureField()])) {
                Integrity::verifyRow($row, 'colaboradores', $row['id'], $this->db);
            }
        }

        return $rows;
    }

    public function getActiveGenderCounts(): array {
        $stmt = $this->db->query("SELECT IFNULL(sexo, 'Otro') AS sexo, COUNT(*) AS total FROM colaboradores WHERE empleado_activo = 1 GROUP BY sexo");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Registra un nuevo colaborador con su historial (Punto 4, 6)
     */
    public function create(array $data, string $pdfPath, string $photoPath): int|false {
        // Verificar si la identificación ya existe para prevenir duplicados
        $stmtCheck = $this->db->prepare("SELECT id FROM colaboradores WHERE identificacion = ?");
        $stmtCheck->execute([$data['identificacion']]);
        if ($stmtCheck->fetch()) {
            // Retorna false si la identificación ya está registrada
            return false;
        }

        $payload = [
            'identificacion' => $data['identificacion'],
            'primer_nombre' => $data['primer_nombre'],
            'segundo_nombre' => $data['segundo_nombre'],
            'primer_apellido' => $data['primer_apellido'],
            'segundo_apellido' => $data['segundo_apellido'],
            'sexo' => $data['sexo'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'foto_perfil' => $photoPath,
            'direccion' => $data['direccion'],
            'correo_personal' => $data['correo_personal'],
            'telefono' => $data['telefono'],
            'celular' => $data['celular'],
            'departamento' => $data['departamento'],
            'fecha_contratacion' => $data['fecha_contratacion'],
            'tipo_contrato' => $data['tipo_contrato'],
            'ocupacion' => $data['ocupacion'],
            'estatus' => $data['estatus'],
            'historial_academico_pdf' => $pdfPath,
            'empleado_activo' => 1
        ];

        $signature = Integrity::signRecord($payload);

        $sql = "INSERT INTO colaboradores (identificacion, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                sexo, fecha_nacimiento, foto_perfil, direccion, correo_personal, telefono, celular, departamento, 
                fecha_contratacion, tipo_contrato, ocupacion, estatus, historial_academico_pdf, integrity_signature) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([
            $data['identificacion'], $data['primer_nombre'], $data['segundo_nombre'], $data['primer_apellido'], $data['segundo_apellido'],
            $data['sexo'], $data['fecha_nacimiento'], $photoPath, $data['direccion'], $data['correo_personal'], $data['telefono'], $data['celular'],
            $data['departamento'], $data['fecha_contratacion'], $data['tipo_contrato'], $data['ocupacion'], $data['estatus'], $pdfPath, $signature
        ])) {
            $id = (int)$this->db->lastInsertId();
            Integrity::refreshRowSignature($this->db, 'colaboradores', 'id', $id);
            return $id;
        }

        return false;
    }
    /**
     * Busca colaboradores por cédula, nombre o apellido (Puntos 7 y 8)
     */
    public function search(string $termino): array {
        $termino = "%{$termino}%";
        $sql = "SELECT * FROM colaboradores 
                WHERE empleado_activo = 1 
                AND (identificacion LIKE ? OR primer_nombre LIKE ? OR primer_apellido LIKE ?)
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$termino, $termino, $termino]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los datos de un colaborador específico por su ID
     */
    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM colaboradores WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row && !empty($row[Integrity::getSignatureField()])) {
            Integrity::verifyRow($row, 'colaboradores', $row['id'], $this->db);
        }
        return $row;
    }

    /**
     * Obtiene el historial de cargos de un colaborador (Punto 5)
     */
    public function getCargos(int $colaborador_id): array {
        $stmt = $this->db->prepare("SELECT * FROM cargos_historial WHERE colaborador_id = ? ORDER BY fecha_inicio DESC");
        $stmt->execute([$colaborador_id]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            if (!empty($row[Integrity::getSignatureField()])) {
                Integrity::verifyRow($row, 'cargos_historial', $row['id'], $this->db);
            }
        }

        return $rows;
    }

    private function getActiveCargoRow(int $colaborador_id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM cargos_historial WHERE colaborador_id = ? AND es_activo = 1 LIMIT 1");
        $stmt->execute([$colaborador_id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row && !empty($row[Integrity::getSignatureField()])) {
            Integrity::verifyRow($row, 'cargos_historial', $row['id'], $this->db);
        }
        return $row ?: null;
    }

    /**
     * Desactiva el cargo activo actual de un colaborador, estableciendo su fecha de fin.
     * Esto es crucial para mantener un historial de cargos cuando se produce un cambio de salario o puesto.
     *
     * @param int $colaborador_id El ID del colaborador.
     * @param string $fecha_inicio_nuevo_cargo La fecha en que comienza el nuevo cargo.
     * @return bool Devuelve true si la operación fue exitosa o si no había cargo que desactivar.
     */
    public function deactivateCurrentCargo(int $colaborador_id, string $fecha_inicio_nuevo_cargo): bool {
        // La fecha de fin del cargo anterior es un día antes del inicio del nuevo.
        $fecha_fin_cargo_anterior = (new \DateTime($fecha_inicio_nuevo_cargo))->modify('-1 day')->format('Y-m-d');

        // Primero, obtenemos el ID del cargo que está activo para poder actualizar su firma de integridad.
        $findStmt = $this->db->prepare("SELECT id FROM cargos_historial WHERE colaborador_id = ? AND es_activo = 1");
        $findStmt->execute([$colaborador_id]);
        $cargo_a_desactivar = $findStmt->fetch();

        // Si no se encuentra un cargo activo, no hay nada que hacer. Se considera un éxito.
        if (!$cargo_a_desactivar) {
            return true;
        }

        $cargo_id = $cargo_a_desactivar['id'];

        // Ahora, actualizamos el cargo para marcarlo como inactivo y establecer su fecha de fin.
        $updateStmt = $this->db->prepare(
            "UPDATE cargos_historial 
             SET es_activo = 0, fecha_fin = ? 
             WHERE id = ?"
        );
        
        if ($updateStmt->execute([$fecha_fin_cargo_anterior, $cargo_id])) {
            // Finalmente, refrescamos la firma de integridad de la fila que acabamos de modificar.
            return \App\Core\Integrity::refreshRowSignature($this->db, 'cargos_historial', 'id', $cargo_id);
        }

        return false;
    }

    /**
     * Añade un nuevo registro de cargo para un colaborador.
     * Este nuevo cargo se marca como activo por defecto (es_activo = 1).
     */
    public function addCargo(int $colaborador_id, string $nombre_cargo, int $sueldo, string $fecha_inicio): bool {
        $sql = "INSERT INTO cargos_historial (colaborador_id, nombre_cargo, sueldo, fecha_inicio, fecha_fin, es_activo) 
                VALUES (?, ?, ?, ?, NULL, 1)";
        
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$colaborador_id, $nombre_cargo, $sueldo, $fecha_inicio])) {
            $id = (int)$this->db->lastInsertId();
            return \App\Core\Integrity::refreshRowSignature($this->db, 'cargos_historial', 'id', $id);
        }

        return false;
    }
}