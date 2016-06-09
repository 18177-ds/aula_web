-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema projeto
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema projeto
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `projeto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `projeto` ;

-- -----------------------------------------------------
-- Table `projeto`.`usr_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`usr_usuarios` (
  `usr_id` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `usr_nome` VARCHAR(100) NOT NULL COMMENT '',
  `usr_login` VARCHAR(100) NOT NULL COMMENT '',
  `usr_password` VARCHAR(100) NOT NULL COMMENT '',
  `usr_ativo` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '	',
  `usr_criado_em` TIMESTAMP NOT NULL COMMENT '',
  `usr_alterado_em` TIMESTAMP NULL COMMENT '',
  PRIMARY KEY (`usr_id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto`.`cat_categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`cat_categorias` (
  `cat_id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `cat_titulo` VARCHAR(100) NOT NULL COMMENT '',
  `cat_ativo` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `cat_criado_em` TIMESTAMP NOT NULL COMMENT '',
  `cat_alterado_em` TIMESTAMP NULL COMMENT '',
  `usr_id_autor` INT NOT NULL COMMENT '',
  PRIMARY KEY (`cat_id`)  COMMENT '',
  INDEX `fk_cat_categorias_usr_usuarios_idx` (`usr_id_autor` ASC)  COMMENT '',
  CONSTRAINT `fk_cat_categorias_usr_usuarios`
    FOREIGN KEY (`usr_id_autor`)
    REFERENCES `projeto`.`usr_usuarios` (`usr_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projeto`.`con_conteudos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projeto`.`con_conteudos` (
  `con_id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `con_titulo` VARCHAR(100) NOT NULL COMMENT '',
  `con_descricao` VARCHAR(100) NOT NULL COMMENT '',
  `con_corpo` LONGTEXT NOT NULL COMMENT '',
  `con_ativo` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
  `con_criado_em` TIMESTAMP NOT NULL COMMENT '',
  `con_alterado_em` TIMESTAMP NULL COMMENT '',
  `usr_id_autor` INT NOT NULL COMMENT '',
  `cat_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`con_id`)  COMMENT '',
  INDEX `fk_con_conteudos_usr_usuarios1_idx` (`usr_id_autor` ASC)  COMMENT '',
  INDEX `fk_con_conteudos_cat_categorias1_idx` (`cat_id` ASC)  COMMENT '',
  CONSTRAINT `fk_con_usr`
    FOREIGN KEY (`usr_id_autor`)
    REFERENCES `projeto`.`usr_usuarios` (`usr_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_con_cat`
    FOREIGN KEY (`cat_id`)
    REFERENCES `projeto`.`cat_categorias` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
