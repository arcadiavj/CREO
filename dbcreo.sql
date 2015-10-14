/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.6.16 : Database - dbcreo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbcreo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `dbcreo`;

/*Table structure for table `consultorio` */

DROP TABLE IF EXISTS `consultorio`;

CREATE TABLE `consultorio` (
  `id_consultorio` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `fch_creacion` date NOT NULL,
  `fch_modificacion` date NOT NULL,
  `fch_baja` date NOT NULL,
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `consultorio` */

/*Table structure for table `especialidad` */

DROP TABLE IF EXISTS `especialidad`;

CREATE TABLE `especialidad` (
  `id_especialidad` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion_especialidad` varchar(50) NOT NULL,
  `fch_creacion` date NOT NULL,
  `fch_modificacion` date NOT NULL,
  `fch_baja` date NOT NULL,
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `especialidad` */

/*Table structure for table `turnollamado` */

DROP TABLE IF EXISTS `turnollamado`;

CREATE TABLE `turnollamado` (
  `id_turno` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_consultorio` int(5) DEFAULT NULL,
  `id_usuario` int(5) DEFAULT NULL,
  `historia_clinica` bigint(11) NOT NULL,
  `fch_inicio` datetime DEFAULT NULL,
  `fch_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `turnollamado` */

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int(5) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `apellido_usuario` varchar(50) NOT NULL,
  `usuario_usuario` varchar(15) NOT NULL,
  `clave_usuario` varchar(50) NOT NULL,
  `tipoAcceso_usuario` int(1) NOT NULL,
  `fch_creacion` date NOT NULL,
  `fch_modificacion` date NOT NULL,
  `fch_baja` date NOT NULL,
  `id_especialidad` int(5) NOT NULL,
  `id_consultorio` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
