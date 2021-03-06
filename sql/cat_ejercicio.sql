/*
SQLyog Community v8.71 
MySQL - 5.5.29 : Database - sgiweb_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cat_ejercicio` */

CREATE TABLE `cat_ejercicio` (
  `ejercicio` smallint(4) unsigned NOT NULL COMMENT 'Ejercicio fiscal',
  `frase` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Frase',
  PRIMARY KEY (`ejercicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='catálogo de ejercicios';

/*Data for the table `cat_ejercicio` */

insert  into `cat_ejercicio`(`ejercicio`,`frase`) values (2017,'\"2017, Año del Cententenario de las Constituciones Mexicana y Mexiquense de 1917\"');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
