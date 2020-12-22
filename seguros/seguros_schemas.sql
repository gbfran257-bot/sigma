--
-- Table structure for table `seguros`
--

DROP TABLE IF EXISTS `seguros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguros` (
  `id_su` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clave_su` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_su` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `p_tabulador_i_su` tinyint(3) unsigned NOT NULL DEFAULT 100,
  `p_tabulador_l_su` tinyint(3) unsigned NOT NULL DEFAULT 100,
  `p_tabulador_s_su` tinyint(3) unsigned NOT NULL DEFAULT 100,
  `usuario_su` int(10) unsigned DEFAULT NULL,
  `fecha_su` datetime DEFAULT NULL,
  `estado_su` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `municipio_su` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `ciudad_su` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `colonia_su` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `calle_su` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `cp_su` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `coordenadas_su` point DEFAULT NULL,
  `telefono_su` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `email_su` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `sitio_su` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `link_pacs_su` varchar(200) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'http://localhost:8080/',
  `horario_e_lu` time NOT NULL,
  `horario_s_lu` time NOT NULL,
  `horario_e_ma` time NOT NULL,
  `horario_s_ma` time NOT NULL,
  `horario_e_mi` time NOT NULL,
  `horario_s_mi` time NOT NULL,
  `horario_e_ju` time NOT NULL,
  `horario_s_ju` time NOT NULL,
  `horario_e_vi` time NOT NULL,
  `horario_s_vi` time NOT NULL,
  `horario_e_sa` time NOT NULL,
  `horario_s_sa` time NOT NULL,
  `horario_e_do` time NOT NULL,
  `horario_s_do` time NOT NULL,
  `no_temp_su` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `clues_su` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `tipo_tabulador_su` tinyint(1) unsigned NOT NULL COMMENT 'maquila 1 laboratorio 2',
  `tipo_tabulador_i_su` tinyint(1) unsigned NOT NULL,
  `p_boni_monedero_c` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `p_boni_monedero_i` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `p_boni_monedero_l` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `p_boni_monedero_s` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `p_boni_monedero_f` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `margen_e_cm` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_cm` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_cm` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_rm` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_rm` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_rm` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_la` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_la` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_la` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_im` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_im` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_im` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_en` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_en` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_en` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_ul` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_ul` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_ul` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_co` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_co` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_co` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `margen_e_sm` float(4,2) unsigned NOT NULL DEFAULT 2.80,
  `tamano_h_sm` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `margen_p_sm` float(4,2) unsigned NOT NULL DEFAULT 2.30,
  `formato_co_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_nm_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_la_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_im_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_en_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_ul_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_cp_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `formato_sm_su` text COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_su`),
  UNIQUE KEY `no_temp_su` (`no_temp_su`,`clues_su`),
  KEY `p_tabulador_i_su` (`p_tabulador_i_su`,`p_tabulador_l_su`,`p_tabulador_s_su`),
  KEY `tipo_tabulador_su` (`tipo_tabulador_su`),
  KEY `tipo_tabulador_i_su` (`tipo_tabulador_i_su`,`p_boni_monedero_c`,`p_boni_monedero_i`,`p_boni_monedero_l`,`p_boni_monedero_s`,`p_boni_monedero_f`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seguros_pacientes`
--

DROP TABLE IF EXISTS `seguros_pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguros_pacientes` (
  `id_su` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sucursal_su` smallint(5) unsigned NOT NULL,
  `id_usuario_su` int(10) unsigned DEFAULT NULL,
  `usuario_su` int(10) unsigned NOT NULL,
  `fecha_su` datetime NOT NULL,
  `primaria_su` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `acceso_su` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `aleatorio_su` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_su`),
  KEY `id_sucursal_su` (`id_sucursal_su`,`id_usuario_su`,`aleatorio_su`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

