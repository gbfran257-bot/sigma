-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2023 a las 23:23:30
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sigma_nuevo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias_hospital`
--

CREATE TABLE IF NOT EXISTS `referencias_hospital` (
  `id_rh` int(11) NOT NULL AUTO_INCREMENT,
  `referencia_rh` varchar(20) NOT NULL,
  `usuario_rh` int(11) NOT NULL,
  `fecha_rh` datetime NOT NULL,
  `estado_rh` tinyint(4) NOT NULL DEFAULT '0',
  `id_paciente_rh` int(11) NOT NULL,
  `contador_rh` int(11) NOT NULL,
  `contador_global` int(11) NOT NULL,
  `id_sucursal_rh` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_rh`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
