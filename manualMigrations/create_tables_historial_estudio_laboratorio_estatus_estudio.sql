-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

use `sigma`;

-- -----------------------------------------------------
-- Table `historial_estudios_laboratorio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `historial_estudios_laboratorio` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL comment "id del usuario que realiza la accion",
  `id_estudio_laboratorio` BIGINT(20) UNSIGNED NOT NULL comment "id del registro en la tabla venta_concepto",
  `fecha_hora` DATETIME NOT NULL,
  `id_estatus` INT UNSIGNED NOT NULL comment "id del estatus asignado al estudio",
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estatus_estudio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estatus_estudio` (
  `id` INT UNSIGNED NOT NULL,
  `estatus` VARCHAR(20) NOT NULL comment 'Estatus que se le asigna al estudio (PENDIENTE, PROCESO, CAPTURADO, AUTORIZADO, FINALIZADO)',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
