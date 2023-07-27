/* <---------- TABLA IMPUESTO ----------> */
DROP TABLE IF EXISTS impuesto;
CREATE TABLE impuesto (
    id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    impuesto VARCHAR(45) NOT NULL
);
INSERT INTO impuesto(impuesto)
VALUES('iva'),
    ('ieps'),
    ('isr');
/* <---------- TABLA IMPUESTO_FIJO ----------> */
DROP TABLE IF EXISTS impuesto_fijo;
CREATE TABLE impuesto_fijo (
    id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    porcentaje FLOAT NOT NULL
);
INSERT INTO impuesto_fijo(porcentaje)
VALUES (0),
    (0.06),
    (0.07),
    (0.08),
    (0.09),
    (0.25),
    (0.265),
    (0.3),
    (0.304),
    (0.5),
    (0.53),
    (1.6),
    (8),
    (16);
/* <---------- TABLA IMPUESTO_FACTOR ----------> */
DROP TABLE IF EXISTS impuesto_factor;
CREATE TABLE impuesto_factor (
    id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    factor VARCHAR(45) NOT NULL
);
INSERT INTO impuesto_factor(factor)
VALUES('tasa'),
    ('cuota'),
    ('exento');
/* <---------- TABLA IMPUESTO_TIPO ----------> */
DROP TABLE IF EXISTS impuesto_tipo;
CREATE TABLE impuesto_tipo (
    id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(45) NOT NULL
);
INSERT INTO impuesto_tipo(tipo)
VALUES ('traslado'),
    ('retencion');
/* <---------- TABLA IMPUESTO_CATALOGO ----------> */
DROP TABLE IF EXISTS impuesto_catalogo;
CREATE TABLE impuesto_catalogo (
    id BIGINT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_sat BIGINT(20) NOT NULL,
    id_impuesto BIGINT(20) NOT NULL,
    id_impuesto_fijo BIGINT(20),
    impuesto_libre FLOAT,
    id_factor BIGINT(20) NOT NULL,
    id_tipo BIGINT(20) NOT NULL,
    FOREIGN KEY(id_sat) REFERENCES catalogo_sat(id_sat) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(id_impuesto) REFERENCES impuesto(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(id_impuesto_fijo) REFERENCES impuesto_fijo(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(id_factor) REFERENCES impuesto_factor(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(id_tipo) REFERENCES impuesto_tipo(id) ON DELETE RESTRICT ON UPDATE CASCADE
);