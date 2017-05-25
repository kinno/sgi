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
/*Table structure for table `cat_region` */

CREATE TABLE `cat_region` (
  `id` tinyint(2) unsigned NOT NULL,
  `clave` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='catálogo de regiones';

/*Data for the table `cat_region` */

insert  into `cat_region`(`id`,`clave`,`nombre`) values (1,'I','Amecameca'),(2,'II','Atlacomulco'),(3,'III','Chimalhuacán'),(4,'IV','Cuautitlán Izcalli'),(5,'V','Ecatepec'),(6,'VI','Ixtapan de la Sal'),(7,'VII','Lerma'),(8,'VIII','Naucalpan'),(9,'IX','Nezahualcóyotl'),(10,'X','Tejupilco'),(11,'XI','Texcoco'),(12,'XII','Tlalnepantla'),(13,'XIII','Toluca'),(14,'XIV','Tultitlán'),(15,'XV','Valle de Bravo'),(16,'XVI','Zumpango');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
