DROP TABLE IF EXISTS transferencia_temporal;
CREATE TABLE transferencia_temporal (
    id_temporal VARCHAR(28) NOT NULL,
    producto VARCHAR(45) NOT NULL,
    codigo_barras VARCHAR(45) NOT NULL,
    lote VARCHAR(45) NOT NULL,
    caducidad DATE NOT NULL,
    cantidad_transferir INT(11) NOT NULL,
    id_sucursal_origen INT(10) NOT NULL,
    id_sucursal_destino INT(10) NOT NULL,
    id_producto BIGINT(20) NOT NULL
);
