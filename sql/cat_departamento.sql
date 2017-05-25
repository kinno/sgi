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
/*Table structure for table `cat_departamento` */

CREATE TABLE `cat_departamento` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` tinyint(4) NOT NULL,
  `id_reponsable` smallint(6) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `bctivo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='catálogo de los departamentos';

/*Data for the table `cat_departamento` */

insert  into `cat_departamento`(`id`,`id_area`,`id_reponsable`,`nombre`,`bctivo`) values (1,7,13,'Departamento de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura',1),(2,8,11,'Departamento de Comunicaciones y Transporte',1),(3,9,12,'Departamento de Proyectos de Inversión para el Desarrollo Social',1),(4,10,15,'Departamento de Registro y Control de la Inversión',1),(5,10,14,'Departamento de Registro y Control Municipal',1),(6,1,0,'Oficina del Subsecretario',1),(7,2,0,'Oficina del C. Director General',1),(8,3,0,'Departamento de Sistemas',1),(9,4,0,'Departamento de Normatividad',1),(10,5,0,'Fondo Metropolitano',1),(11,6,0,'Evaluación de Proyectos',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
