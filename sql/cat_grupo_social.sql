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
/*Table structure for table `cat_grupo_social` */

CREATE TABLE `cat_grupo_social` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='catalogo grupo social';

/*Data for the table `cat_grupo_social` */

insert  into `cat_grupo_social`(`id`,`nombre`) values (1,'Antorcha Campesina'),(2,'Central Campesina Cardenista'),(3,'Convergencia Cívica Democrática'),(4,'Convergencia Social Democrática'),(5,'Federación Nacional De Estudiantes Revolucionarios Rafael Ramírez'),(6,'Frente De Organizaciones Sociales Ecatepec'),(7,'Frente Democrático  30  De Marzo'),(8,'La Colmena'),(9,'Movimiento De Acción Social Amplio'),(10,'Movimiento Propietariado Independiente'),(11,'Movimiento Urbano Popular II'),(12,'Movimiento Vidada Digna'),(13,'Naucopac (America Abaroa Zamora)'),(14,'Organización Movimiento Urbano Popular'),(15,'Organización Nacional Del Poder Popular'),(16,'Organización Popular Democrática Independiente'),(17,'Organización Social Cristo'),(18,'Unión De Colonos De Jardines De Aragon Ecatepec'),(19,'Unión De Lucha Para El Progreso'),(20,'Unión Popular Revolucionaria Emiliano Zapata'),(21,'Varios Grupos'),(22,'Vecinos De La Comunidad De Santiago Cuauxtenco');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
