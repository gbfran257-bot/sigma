-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2023 a las 06:25:55
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
-- Estructura de tabla para la tabla `abonos_referencias_hospital`
--

CREATE TABLE IF NOT EXISTS `abonos_referencias_hospital` (
  `id_arh` int(11) NOT NULL AUTO_INCREMENT,
  `id_rh_arh` int(11) NOT NULL,
  `usuario_arh` int(11) NOT NULL,
  `fecha_arh` datetime NOT NULL,
  `cantidad_abonada_arh` float NOT NULL,
  `nom_pers_abona_arh` varchar(120) NOT NULL COMMENT 'nombre de la persona que abona',
  `forma_pago_arh` tinyint(4) NOT NULL COMMENT 'id de la forma de pago',
  PRIMARY KEY (`id_arh`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
