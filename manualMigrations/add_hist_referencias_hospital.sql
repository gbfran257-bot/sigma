-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2023 a las 05:04:25
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
-- Estructura de tabla para la tabla `hist_referencias_hospital`
--

CREATE TABLE IF NOT EXISTS `hist_referencias_hospital` (
  `id_hrh` int(11) NOT NULL AUTO_INCREMENT,
  `referencia_rh_hrh` varchar(20) NOT NULL,
  `usuario_hrh` int(11) NOT NULL,
  `fecha_alta_hrh` datetime NOT NULL,
  `estado_hrh` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_hrh`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
