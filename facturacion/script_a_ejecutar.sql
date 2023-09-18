CREATE TABLE ordenes_facturadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    referencia_ov VARCHAR(20) NOT NULL,
    estatus ENUM('timbrada', 'cancelada', 'borrador') NOT NULL,
    uuid CHAR(36) BINARY NOT NULL
);
