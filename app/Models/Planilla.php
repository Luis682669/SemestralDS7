<?php
namespace App\Models;

use App\Core\Integrity;

class Planilla {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    /**
     * Calcula las deducciones, redondea a enteros y guarda el recibo
     */
    public function calcularYGuardar(int $colaborador_id, string $mes, int $anio, int $salario_base): bool {
        
        // 1. Cálculos de porcentajes y redondeo automático a número entero
        $css_sipe = (int)round($salario_base * 0.0975);
        $seguro_educativo = (int)round($salario_base * 0.0125);
        $xiii_mes = (int)round($salario_base / 12);
        
        // 2. Cálculo del salario neto a recibir
        $salario_neto = $salario_base - $css_sipe - $seguro_educativo;

        // 3. Inserción en la base de datos
        $payload = [
            'colaborador_id' => $colaborador_id,
            'mes' => $mes,
            'anio' => $anio,
            'salario_base' => $salario_base,
            'css_sipe' => $css_sipe,
            'seguro_educativo' => $seguro_educativo,
            'xiii_mes' => $xiii_mes,
            'salario_neto' => $salario_neto
        ];

        $stmt = $this->db->prepare("INSERT INTO planillas (colaborador_id, mes, anio, salario_base, css_sipe, seguro_educativo, xiii_mes, salario_neto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$colaborador_id, $mes, $anio, $salario_base, $css_sipe, $seguro_educativo, $xiii_mes, $salario_neto])) {
            $id = (int)$this->db->lastInsertId();
            Integrity::refreshRowSignature($this->db, 'planillas', 'id', $id);
            return true;
        }

        return false;
    }

    /**
     * Obtiene todo el historial de planillas procesadas
     */
    public function getAll(): array {
        $sql = "SELECT p.*, c.identificacion, c.primer_nombre, c.primer_apellido 
                FROM planillas p 
                JOIN colaboradores c ON p.colaborador_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            if (!empty($row[Integrity::getSignatureField()])) {
                Integrity::verifyRow($row, 'planillas', $row['id'], $this->db);
            }
        }

        return $rows;
    }
}