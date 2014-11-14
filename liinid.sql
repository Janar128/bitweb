-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bitweb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bitweb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bitweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `bitweb` ;

-- -----------------------------------------------------
-- Table `bitweb`.`line`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitweb`.`line` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` MEDIUMTEXT NULL,
  `added` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bitweb`.`busstop`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitweb`.`busstop` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `lat` FLOAT(10,6) NULL,
  `lng` FLOAT(10,6) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bitweb`.`line_busstop`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitweb`.`line_busstop` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `line_id` INT NULL,
  `busstop_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `liin_id` (`line_id` ASC),
  INDEX `peatus_id` (`busstop_id` ASC),
  CONSTRAINT `liin_id`
    FOREIGN KEY (`line_id`)
    REFERENCES `bitweb`.`line` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `peatus_id`
    FOREIGN KEY (`busstop_id`)
    REFERENCES `bitweb`.`busstop` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `bitweb`.`line`
-- -----------------------------------------------------
START TRANSACTION;
USE `bitweb`;
INSERT INTO `bitweb`.`line` (`id`, `name`, `description`, `added`) VALUES (1, 'Liin 1', NULL, '08-11-2014');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bitweb`.`busstop`
-- -----------------------------------------------------
START TRANSACTION;
USE `bitweb`;
INSERT INTO `bitweb`.`busstop` (`id`, `name`, `lat`, `lng`) VALUES (1, 'Peatus 1', 10.2, 2.4);
INSERT INTO `bitweb`.`busstop` (`id`, `name`, `lat`, `lng`) VALUES (2, 'Peatus 2', 14.3, 5.6);
INSERT INTO `bitweb`.`busstop` (`id`, `name`, `lat`, `lng`) VALUES (3, 'Peatus 3', 2.6, 2.9);

COMMIT;


-- -----------------------------------------------------
-- Data for table `bitweb`.`line_busstop`
-- -----------------------------------------------------
START TRANSACTION;
USE `bitweb`;
INSERT INTO `bitweb`.`line_busstop` (`id`, `line_id`, `busstop_id`) VALUES (1, 1, 1);
INSERT INTO `bitweb`.`line_busstop` (`id`, `line_id`, `busstop_id`) VALUES (2, 1, 2);
INSERT INTO `bitweb`.`line_busstop` (`id`, `line_id`, `busstop_id`) VALUES (3, 1, 3);

COMMIT;

