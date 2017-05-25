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
/*Table structure for table `cat_sector` */

CREATE TABLE `cat_sector` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clave` char(10) DEFAULT NULL,
  `unidad_responsable` varchar(80) DEFAULT NULL,
  `id_titular` smallint(6) NOT NULL,
  `id_departamento` tinyint(4) NOT NULL,
  `bactivo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='catálogo de sectores';

/*Data for the table `cat_sector` */

insert  into `cat_sector`(`id`,`nombre`,`clave`,`unidad_responsable`,`id_titular`,`id_departamento`,`bactivo`) values (1,'Agropecuario y Forestal','2070000000','Secretaría de Desarrollo Agropecuario',126,1,1),(2,'Agua y Obra Pública','2290000000','Secretaría de Infraestructura',127,1,1),(3,'Asistencia Social','2020000000','Secretaría General de Gobierno',128,3,1),(4,'Ayuntamientos',NULL,NULL,0,5,1),(5,'Comunicaciones','2290000000','Secretaría de Infraestructura',129,2,0),(6,'Consejería Jurídica','2270000000','Consejería Jurídica del Ejecutivo Estatal',130,3,1),(7,'Contraloría','2100000000','Secretaría de la Contraloría',131,3,1),(8,'Cultura','2280000000','Secretaría de Cultura',132,3,1),(9,'Desarrollo Económico','2080000000','Secretaría de Desarrollo Económico',133,2,1),(10,'Desarrollo Metropolitano','2160000000','Secretaría de Desarrollo Metropolitano',134,1,1),(11,'Desarrollo Social','2150000000','Secretaría de Desarrollo Social',135,1,1),(12,'Desarrollo Urbano y Metropolitano','2240000000','Secretaría de Desarrollo Urbano Y Metropolitano',136,2,1),(13,'Educación','2050000000','Secretaría de Educación',137,3,1),(14,'Finanzas','2030000000','Secretaría de Finanzas',138,3,1),(15,'Gobierno','2020000000','Secretaría General de Gobierno',139,3,1),(16,'ISSEMYM','2030000000','Secretaría de Finanzas',140,3,1),(17,'ITAIPPEMyM',NULL,NULL,141,3,1),(18,'Justicia','2130000000','Fiscalía General de Justicia',142,3,1),(19,'Medio Ambiente','2120000000','Secretaría del Medio Ambiente',143,1,1),(20,'Poder Judicial',NULL,NULL,144,3,1),(21,'Radio y Tv Mexiquense','2010000000','Gubernatura',145,2,1),(22,'Salud','2170000000','Secretaría de Salud',146,3,1),(23,'Seguridad Ciudadana','2260000000','Comisión Estatal de Seguridad Ciudadana del Estado de México',147,3,1),(24,'Trabajo','2040000000','Secretaría del Trabajo',148,3,1),(25,'Transporte','2230000000','Secretaría de Movilidad',149,2,1),(26,'Turismo','2250000000','Secretaría de Turismo',150,2,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
