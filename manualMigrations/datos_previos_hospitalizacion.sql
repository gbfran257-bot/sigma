-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2023 a las 20:25:26
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sigma_nuevo2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_previos_hospitalizacion`
--

CREATE TABLE IF NOT EXISTS `datos_previos_hospitalizacion` (
  `id_dph` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_p_dph` bigint(20) NOT NULL COMMENT 'id del paciente',
  `id_u_dph` bigint(20) NOT NULL COMMENT 'id del usuario quien registra',
  `id_vc_dph` bigint(20) NOT NULL COMMENT 'id de venta_conceptos',
  `motivo_dph` varchar(200) COLLATE latin1_spanish_ci NOT NULL COMMENT 'notivo de hospitalizacion',
  PRIMARY KEY (`id_dph`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `datos_previos_hospitalizacion` ADD `fecha_registro_dph` DATETIME NOT NULL ;
