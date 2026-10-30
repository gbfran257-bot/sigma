


CREATE TABLE `catalogo_lineas_cr` (
  `id_l` bigint(20) NOT NULL,
  `nombre_l` varchar(250) NOT NULL,
  `descripcion_l` text,
  `usuario_l` int(10) DEFAULT NULL,
  `fecha_l` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `catalogo_lineas_cr`
  ADD PRIMARY KEY (`id_l`);


--
-- Volcado de datos para la tabla `catalogo_lineas_cr`
--

INSERT INTO `catalogo_lineas_cr` (`id_l`, `nombre_l`, `descripcion_l`, `usuario_l`, `fecha_l`) VALUES
(1, 'ADMINISTRACION', 'SERVICIOS', 1, '2021-12-07 06:00:00'),
(3, 'SERVICIOS MÉDICOS ESPECIALIDAD', 'CONSULTAS', NULL, NULL),
(4, 'SERVICIOS MEDICOS URGENCIAS', 'CONSULTAS', NULL, NULL),
(5, 'SERVICIOS MÉDICOS DENTAL', 'CONSULTAS', NULL, NULL),
(6, 'BANCO DE SANGRE', 'SERVICIOS', NULL, NULL),
(7, 'CAPACITACION', 'SERVICIOS', NULL, NULL),
(8, 'CAPTACION DE FONDOS', 'SERVICIOS', NULL, NULL),
(9, 'DAMAS VOLUNTARIAS', 'SERVICIOS', NULL, NULL),
(10, 'JUVENTUD', 'SERVICIOS\r\n', NULL, NULL),
(11, 'ULTRA SONIDOS', 'IMAGEN', NULL, NULL),
(12, 'REHABILITACION', 'IMAGEN', NULL, NULL),
(13, 'RAYOS X', 'IMAGEN', NULL, NULL),
(14, 'MEDICAMENTOS', 'INSUMOS', NULL, NULL),
(15, 'MATERIAL DE CURACION', 'INSUMOS', NULL, NULL),
(16, 'ALMACEN', 'INSUMOS', NULL, NULL);

--
-- AUTO_INCREMENT de la tabla `catalogo_descuentos`
--
ALTER TABLE `catalogo_lineas_cr`
  MODIFY `id_l` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;