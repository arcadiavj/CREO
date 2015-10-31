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
  `descripcion_consultorio` varchar(50) NOT NULL,
  `fch_creacion` date NOT NULL,
  `fch_modificacion` date NOT NULL DEFAULT '0000-00-00',
  `fch_baja` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `consultorio` */

insert  into `consultorio`(`id_consultorio`,`descripcion_consultorio`,`fch_creacion`,`fch_modificacion`,`fch_baja`) values (1,'Consultorio 1','2015-10-14','0000-00-00','0000-00-00'),(2,'Consultorio 2','2015-10-19','2015-10-19','0000-00-00'),(3,'Consultorio 3','2015-10-19','0000-00-00','0000-00-00'),(4,'pepito','2015-10-19','0000-00-00','2015-10-19');

/*Table structure for table `especialidad` */

DROP TABLE IF EXISTS `especialidad`;

CREATE TABLE `especialidad` (
  `id_especialidad` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion_especialidad` varchar(50) NOT NULL,
  `fch_creacion` date NOT NULL,
  `fch_modificacion` date NOT NULL DEFAULT '0000-00-00',
  `fch_baja` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `especialidad` */

insert  into `especialidad`(`id_especialidad`,`descripcion_especialidad`,`fch_creacion`,`fch_modificacion`,`fch_baja`) values (1,'Cardiología','2015-10-14','0000-00-00','0000-00-00'),(6,'Radiología','2015-10-17','2015-10-19','0000-00-00'),(7,'espec','2015-10-19','0000-00-00','2015-10-19'),(8,'Psicología','2015-10-19','0000-00-00','0000-00-00');

/*Table structure for table `turno` */

DROP TABLE IF EXISTS `turno`;

CREATE TABLE `turno` (
  `id_turno` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_consultorio` int(5) DEFAULT NULL,
  `id_usuario` int(5) DEFAULT NULL,
  `historia_clinica_turno` bigint(11) NOT NULL,
  `estado_turno` varchar(1) DEFAULT NULL,
  `fch_llegada_turno` datetime DEFAULT NULL,
  `fch_inicio_turno` datetime DEFAULT NULL,
  `fch_fin_turno` datetime DEFAULT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `turno` */

insert  into `turno`(`id_turno`,`id_consultorio`,`id_usuario`,`historia_clinica_turno`,`estado_turno`,`fch_llegada_turno`,`fch_inicio_turno`,`fch_fin_turno`) values (1,1,1,31,'0','2015-10-24 22:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,1,427,'0','2015-10-24 22:01:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,1,555,'0','2015-10-24 22:10:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,1,323,'0','2015-10-24 22:32:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,3,1,767,'0','2015-10-24 22:02:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,3,1,245,'0','2015-10-24 22:03:00','0000-00-00 00:00:00','0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`nombre_usuario`,`apellido_usuario`,`usuario_usuario`,`clave_usuario`,`tipoAcceso_usuario`,`fch_creacion`,`fch_modificacion`,`fch_baja`,`id_especialidad`,`id_consultorio`) values (1,'emanuel','guirao','flaco','cb064534dc67b8ab137b5259de85b2e7c927b502',1,'2015-10-14','0000-00-00','0000-00-00',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
