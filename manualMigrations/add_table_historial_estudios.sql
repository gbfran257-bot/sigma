-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2024 a las 01:32:38
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
-- Estructura de tabla para la tabla `historial_estudios`
--

CREATE TABLE IF NOT EXISTS `historial_estudios` (
  `id_usuario` int(11) NOT NULL,
  `id_estudio` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `id_estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial_estudios`
--

INSERT INTO `historial_estudios` (`id_usuario`, `id_estudio`, `fecha_hora`, `id_estatus`) VALUES
(24, 1787, '2024-01-04 18:30:06', 1),
(24, 1790, '2024-01-04 18:30:54', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
