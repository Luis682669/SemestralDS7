-- Agregar columna de firma de integridad a las tablas críticas
-- Estas columnas almacenarán la firma HMAC generada por PHP en el backend.

ALTER TABLE usuarios
    ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER rol_id;

ALTER TABLE colaboradores
    ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER historial_academico_pdf;

ALTER TABLE planillas
    ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER salario_neto;

ALTER TABLE vacaciones
    ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER motivo;

ALTER TABLE cargos_historial
    ADD COLUMN integrity_signature VARCHAR(512) NULL AFTER es_activo;

-- Nota: los registros existentes no tendrán firma hasta que se vuelvan a procesar
-- mediante la lógica del backend o un script de backfill que calcule la firma.
