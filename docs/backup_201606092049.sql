-- MySQL dump 10.13  Distrib 5.6.30, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: projeto
-- ------------------------------------------------------
-- Server version	5.6.30-0ubuntu0.15.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cat_categorias`
--

CREATE SCHEMA IF NOT EXISTS `projeto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `projeto` ;


DROP TABLE IF EXISTS `cat_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_categorias` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_titulo` varchar(100) NOT NULL,
  `cat_ativo` tinyint(1) NOT NULL DEFAULT '1',
  `cat_criado_em` timestamp NULL DEFAULT "0000-00-00",
  `cat_alterado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usr_id_autor` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `fk_cat_categorias_usr_usuarios_idx` (`usr_id_autor`),
  CONSTRAINT `fk_cat_categorias_usr_usuarios` FOREIGN KEY (`usr_id_autor`) REFERENCES `usr_usuarios` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_categorias`
--

LOCK TABLES `cat_categorias` WRITE;
/*!40000 ALTER TABLE `cat_categorias` DISABLE KEYS */;
INSERT INTO `cat_categorias` VALUES (1,'PHP',1,'2016-06-09 22:39:30',NULL,1),(2,'JAVA',1,'2016-06-09 22:39:40',NULL,1),(3,'BD',1,'2016-06-09 22:39:49',NULL,1),(4,'Engenharia de Software',1,'2016-06-09 22:40:04',NULL,1);
/*!40000 ALTER TABLE `cat_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `con_conteudos`
--

DROP TABLE IF EXISTS `con_conteudos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `con_conteudos` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_titulo` varchar(100) NOT NULL,
  `con_descricao` varchar(100) NOT NULL,
  `con_corpo` longtext NOT NULL,
  `con_ativo` tinyint(1) NOT NULL DEFAULT '1',
  `con_criado_em` timestamp NOT NULL DEFAULT "0000-00-00",
  `con_alterado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usr_id_autor` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`con_id`),
  KEY `fk_con_conteudos_usr_usuarios1_idx` (`usr_id_autor`),
  KEY `fk_con_conteudos_cat_categorias1_idx` (`cat_id`),
  CONSTRAINT `fk_con_cat` FOREIGN KEY (`cat_id`) REFERENCES `cat_categorias` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_con_usr` FOREIGN KEY (`usr_id_autor`) REFERENCES `usr_usuarios` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `con_conteudos`
--

LOCK TABLES `con_conteudos` WRITE;
/*!40000 ALTER TABLE `con_conteudos` DISABLE KEYS */;
INSERT INTO `con_conteudos` VALUES (1,'Introducao','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:41:18',NULL,1,1),(2,'Introducao','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:41:32',NULL,1,2),(3,'Introducao','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:41:43',NULL,1,3),(4,'Introducao','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:41:53',NULL,1,4),(5,'JDK','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:42:25',NULL,1,1),(6,'Eclipse IDE','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:42:35',NULL,1,1),(7,'Oracle','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:42:46',NULL,1,1),(8,'Javac','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:42:58',NULL,1,1),(9,'Objeto','Lorem ipsum','Mussum Ipsum',1,'2016-06-09 22:43:07',NULL,1,1);
/*!40000 ALTER TABLE `con_conteudos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usr_usuarios`
--

DROP TABLE IF EXISTS `usr_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usr_usuarios` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `usr_nome` varchar(100) NOT NULL,
  `usr_login` varchar(100) NOT NULL,
  `usr_password` varchar(100) NOT NULL,
  `usr_ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '	',
  `usr_criado_em` timestamp NOT NULL DEFAULT "0000-00-00",
  `usr_alterado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usr_usuarios`
--

LOCK TABLES `usr_usuarios` WRITE;
/*!40000 ALTER TABLE `usr_usuarios` DISABLE KEYS */;
INSERT INTO `usr_usuarios` VALUES (1,'Argel Goncalves','argelgoncalves','81dc9bdb52d04dc20036dbd8313ed055',1,'2016-06-09 21:38:07',NULL),(2,'Rafael Magno','rafaelmagno','81dc9bdb52d04dc20036dbd8313ed055',1,'2016-06-09 23:47:15',NULL),(3,'Leonardo Cavalcante','leonardocavalcante','81dc9bdb52d04dc20036dbd8313ed055',1,'2016-06-09 23:47:42',NULL);
/*!40000 ALTER TABLE `usr_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-09 20:49:28
