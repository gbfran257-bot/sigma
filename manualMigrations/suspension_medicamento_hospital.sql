
CREATE TABLE `suspension_medicamento_hospital` (
  `id_s` int(20) NOT NULL,
  `id_user_s` int(20) NOT NULL,
  `fecha_s` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_mh_s` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `suspension_medicamento_hospital`
  ADD PRIMARY KEY (`id_s`);