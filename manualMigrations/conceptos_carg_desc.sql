-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2023 a las 07:36:38
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
-- Estructura de tabla para la tabla `conceptos_carg_desc`
--

CREATE TABLE IF NOT EXISTS `conceptos_carg_desc` (
  `id_cd` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id del registro',
  `id_personal_medico_cd` int(11) DEFAULT NULL,
  `tipo` int(10) DEFAULT NULL COMMENT '0 descuento directo 1 descuento porcentaje 2 cargo',
  `no_temp_cd` text CHARACTER SET utf8 COLLATE utf8_spanish_ci COMMENT 'temporal',
  `monto` float DEFAULT NULL COMMENT 'cantidad en pesos',
  `motivo_carg_desc` text CHARACTER SET utf8,
  `tipo_area` text CHARACTER SET utf8 COLLATE utf8_spanish_ci COMMENT 'consultas,estudios,farmacia,insumos',
  PRIMARY KEY (`id_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=390 ;

--
-- Volcado de datos para la tabla `conceptos_carg_desc`
--

INSERT INTO `conceptos_carg_desc` (`id_cd`, `id_personal_medico_cd`, `tipo`, `no_temp_cd`, `monto`, `motivo_carg_desc`, `tipo_area`) VALUES
(331, 24, 1, '2023-07-02-12-51-04-50', 30, 'g', 'imagen'),
(332, 24, 0, '2023-07-02-12-51-04-50', 0, 'g', 'imagen'),
(333, 24, 2, '2023-07-02-12-51-04-50', 0, NULL, 'imagen'),
(334, 24, 2, '2023-07-02-12-51-04-50', 0, NULL, 'imagen'),
(335, 24, 1, '2023-07-02-12-56-00-73', 10, NULL, 'imagen'),
(336, 24, 0, '2023-07-02-12-56-00-73', 0, NULL, 'imagen'),
(337, 24, 2, '2023-07-02-12-56-00-73', 0, NULL, 'imagen'),
(338, 24, 2, '2023-07-02-12-56-00-73', 0, NULL, 'imagen'),
(339, 24, 0, '2023-07-02-13-02-50-70', 0, NULL, 'imagen'),
(340, 24, 2, '2023-07-02-13-02-50-70', 0, NULL, 'imagen'),
(341, 24, 1, '2023-07-02-13-02-50-70', 0, NULL, 'imagen'),
(342, 24, 1, '2023-07-02-13-05-11-52', 0, NULL, 'laboratorio'),
(343, 24, 0, '2023-07-02-13-05-11-52', 0, NULL, 'laboratorio'),
(344, 24, 2, '2023-07-02-13-05-11-52', 0, NULL, 'laboratorio'),
(345, 24, 1, '2023-07-02-13-10-36-56', 0, NULL, 'imagen'),
(346, 24, 0, '2023-07-02-13-10-36-56', 10, NULL, 'imagen'),
(347, 24, 2, '2023-07-02-13-10-36-56', 0, NULL, 'imagen'),
(348, 24, 2, '2023-07-02-13-10-36-56', 0, NULL, 'imagen'),
(349, 24, 0, '2023-07-02-13-12-36-72', 4, NULL, 'imagen'),
(350, 24, 1, '2023-07-02-13-12-36-72', 0, NULL, 'imagen'),
(351, 24, 2, '2023-07-02-13-12-36-72', 0, NULL, 'imagen'),
(352, 24, 1, '2023-07-02-13-12-36-72', 0, NULL, 'imagen'),
(353, 24, 2, '2023-07-02-13-12-36-72', 0, NULL, 'imagen'),
(354, 24, 1, '2023-07-02-13-25-53-34', 0, NULL, 'imagen'),
(355, 24, 0, '2023-07-02-13-25-53-34', 200, NULL, 'imagen'),
(356, 24, 2, '2023-07-02-13-25-53-34', 0, NULL, 'imagen'),
(357, 24, 0, '2023-07-02-13-28-15-38', 10, NULL, 'imagen'),
(358, 24, 1, '2023-07-02-13-28-15-38', 0, NULL, 'imagen'),
(359, 24, 2, '2023-07-02-13-28-15-38', 0, NULL, 'imagen'),
(360, 24, 2, '2023-07-02-13-28-15-38', 0, NULL, 'imagen'),
(361, 24, 1, '2023-07-02-13-29-09-78', 0, NULL, 'imagen'),
(362, 24, 0, '2023-07-02-13-29-09-78', 100, NULL, 'imagen'),
(363, 24, 2, '2023-07-02-13-29-09-78', 0, NULL, 'imagen'),
(364, 24, 0, '2023-07-02-13-29-41-50', 40, NULL, 'imagen'),
(365, 24, 1, '2023-07-02-13-29-41-50', 0, NULL, 'imagen'),
(366, 24, 2, '2023-07-02-13-29-41-50', 0, NULL, 'imagen'),
(367, 24, 1, '2023-07-02-13-29-41-50', 0, NULL, 'imagen'),
(368, 24, 1, '2023-07-02-13-30-26-13', 0, NULL, 'imagen'),
(369, 24, 2, '2023-07-02-13-30-26-13', 0, NULL, 'imagen'),
(370, 24, 0, '2023-07-02-13-30-26-13', 10, NULL, 'imagen'),
(371, 24, 1, '2023-07-02-13-32-45-71', 0, NULL, 'imagen'),
(372, 24, 0, '2023-07-02-13-32-45-71', 90, NULL, 'imagen'),
(373, 24, 2, '2023-07-02-13-32-45-71', 0, NULL, 'imagen'),
(374, 24, 0, '2023-07-02-13-52-58-49', 0, NULL, 'imagen'),
(375, 24, 2, '2023-07-02-13-52-58-49', 0, NULL, 'imagen'),
(376, 24, 2, '2023-07-02-13-52-58-49', 0, NULL, 'imagen'),
(377, 24, 1, '2023-07-02-13-52-58-49', NULL, NULL, 'imagen'),
(378, 24, 1, '2023-07-02-13-52-58-49', NULL, NULL, 'imagen'),
(379, 24, 1, '2023-07-02-14-36-11-33', NULL, NULL, 'laboratorio'),
(380, 24, 2, '2023-07-02-14-36-11-33', 100, NULL, 'laboratorio'),
(381, 24, 0, '2023-07-02-14-36-11-33', 0, NULL, 'laboratorio'),
(382, 24, 1, '2023-07-02-14-44-07-36', 0, NULL, 'imagen'),
(383, 24, 0, '2023-07-02-14-44-07-36', 100, NULL, 'imagen'),
(384, 24, 0, '2023-07-02-14-44-07-36', 100, NULL, 'imagen'),
(385, 24, 2, '2023-07-02-14-44-07-36', 0, NULL, 'imagen'),
(386, 24, 2, '2023-07-02-14-44-07-36', 0, NULL, 'imagen'),
(387, 24, 1, '2023-07-02-15-39-04-43', 0, NULL, 'imagen'),
(388, 24, 0, '2023-07-02-15-39-04-43', 100, NULL, 'imagen'),
(389, 24, 2, '2023-07-02-15-39-04-43', 0, NULL, 'imagen');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
