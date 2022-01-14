CREATE TABLE `catalogo_descuentos` (
  `id_des` bigint(20) NOT NULL,
  `nombre_des` varchar(250) NOT NULL,
  `tipo_des` varchar(50) NOT NULL,
  `descuento_des` float(8,2) NOT NULL,
  `usuario_des` bigint(20) DEFAULT NULL,
  `fecha_des` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `catalogo_descuentos`
  ADD PRIMARY KEY (`id_des`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_descuentos`
--
ALTER TABLE `catalogo_descuentos`
  MODIFY `id_des` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
