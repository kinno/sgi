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
/*Table structure for table `cat_municipio_reporte` */

CREATE TABLE `cat_municipio_reporte` (
  `id` smallint(3) unsigned NOT NULL,
  `id_partido_politico` tinyint(2) DEFAULT NULL,
  `id_region` tinyint(2) DEFAULT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='catálogo de municipios';

/*Data for the table `cat_municipio_reporte` */

insert  into `cat_municipio_reporte`(`id`,`id_partido_politico`,`id_region`,`nombre`) values (1,0,0,'Cobertura Estatal'),(2,0,0,'Cobertura Regional'),(3,0,0,'Cobertura Municipal'),(4,3,2,'Acambay'),(5,3,5,'Acolman'),(6,3,2,'Aculco'),(7,3,6,'Almoloya de Alquisiras'),(8,3,13,'Almoloya de Juárez'),(9,3,13,'Almoloya del Río'),(10,3,15,'Amanalco'),(11,3,10,'Amatepec'),(12,3,1,'Amecameca'),(13,1,16,'Apaxco'),(14,3,11,'Atenco'),(15,3,7,'Atizapán'),(16,1,12,'Atizapán de Zaragoza'),(17,3,2,'Atlacomulco'),(18,1,1,'Atlautla'),(19,3,5,'Axapusco'),(20,3,1,'Ayapango'),(21,4,13,'Calimaya'),(22,3,7,'Capulhuac'),(23,3,1,'Chalco'),(24,1,2,'Chapa de Mota'),(25,3,13,'Chapultepec'),(26,3,11,'Chiautla'),(27,3,3,'Chicoloapan'),(28,1,11,'Chiconcuac'),(29,3,3,'Chimalhuacán'),(30,3,14,'Coacalco'),(31,1,6,'Coatepec Harinas'),(32,3,1,'Cocotitlán'),(33,3,4,'Coyotepec'),(34,3,14,'Cuautitlán'),(35,3,4,'Cuautitlán Izcalli'),(36,3,15,'Donato Guerra'),(37,3,5,'Ecatepec'),(38,3,1,'Ecatzingo'),(39,3,2,'El Oro'),(40,1,4,'Huehuetoca'),(41,1,16,'Hueypoxtla'),(42,3,8,'Huixquilucan'),(43,3,8,'Isidro Fabela'),(44,3,3,'Ixtapaluca'),(45,2,6,'Ixtapan de la Sal'),(46,3,15,'Ixtapan del Oro'),(47,3,2,'Ixtlahuaca'),(48,3,16,'Jaltenco'),(49,3,2,'Jilotepec'),(50,3,8,'Jilotzingo'),(51,3,7,'Jiquipilco'),(52,3,2,'Jocotitlán'),(53,1,6,'Joquicingo'),(54,3,1,'Juchitepec'),(55,3,3,'La Paz'),(56,3,7,'Lerma'),(57,2,10,'Luvianos'),(58,3,6,'Malinalco'),(59,3,14,'Melchor Ocampo'),(60,3,13,'Metepec'),(61,3,13,'Mexicaltzingo'),(62,3,2,'Morelos'),(63,3,8,'Naucalpan'),(64,1,16,'Nextlalpan'),(65,2,9,'Nezahualcóyotl'),(66,3,8,'Nicolás Romero'),(67,3,5,'Nopaltepec'),(68,3,7,'Ocoyoacac'),(69,3,6,'Ocuilan'),(70,1,5,'Otumba'),(71,3,15,'Otzoloapan'),(72,3,7,'Otzolotepec'),(73,3,1,'Ozumba'),(74,3,11,'Papalotla'),(75,3,2,'Polotitlán'),(76,4,13,'Rayón'),(77,3,13,'San Antonio la Isla'),(78,3,2,'San Felipe del Progreso'),(79,3,2,'San José del Rincón'),(80,3,5,'San Martín de las Pirámides'),(81,3,7,'San Mateo Atenco'),(82,2,6,'San Simón de Guerrero'),(83,2,15,'Santo Tomás'),(84,3,2,'Soyaniquilpan'),(85,3,6,'Sultepec'),(86,3,5,'Tecámac'),(87,3,10,'Tejupilco'),(88,4,1,'Temamatla'),(89,3,5,'Temascalapa'),(90,3,2,'Temascalcingo'),(91,3,6,'Temascaltepec'),(92,3,7,'Temoaya'),(93,3,6,'Tenancingo'),(94,3,1,'Tenango del Aire'),(95,3,13,'Tenango del Valle'),(96,3,14,'Teoloyucan'),(97,2,5,'Teotihuacán'),(98,3,11,'Tepetlaoxtoc'),(99,3,1,'Tepetlixpa'),(100,3,4,'Tepotzotlán'),(101,1,16,'Tequixquiac'),(102,1,6,'Texcaltitlán'),(103,3,13,'Texcalyacac'),(104,4,11,'Texcoco'),(105,3,11,'Tezoyuca'),(106,3,7,'Tianguistenco'),(107,3,2,'Timilpan'),(108,3,1,'Tlalmanalco'),(109,3,12,'Tlalnepantla'),(110,2,10,'Tlatlaya'),(111,3,13,'Toluca'),(112,3,16,'Tonanitla'),(113,2,6,'Tonatico'),(114,2,14,'Tultepec'),(115,3,14,'Tultitlán'),(116,1,15,'Valle de Bravo'),(117,2,1,'Valle de Chalco Solidaridad'),(118,2,15,'Villa de Allende'),(119,3,4,'Villa del Carbón'),(120,3,6,'Villa Guerrero'),(121,3,15,'Villa Victoria'),(122,3,7,'Xalatlaco'),(123,4,7,'Xonacatlán'),(124,3,15,'Zacazonapan'),(125,1,6,'Zacualpan'),(126,3,13,'Zinacantepec'),(127,1,6,'Zumpahuacán'),(128,3,16,'Zumpango');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
