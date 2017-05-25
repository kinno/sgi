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
/*Table structure for table `cat_municipio` */

CREATE TABLE `cat_municipio` (
  `id` smallint(3) unsigned NOT NULL,
  `id_partido_politico` tinyint(2) DEFAULT NULL,
  `id_region` tinyint(2) DEFAULT NULL,
  `clave_federal` smallint(3) DEFAULT NULL,
  `clave_estatal` smallint(3) DEFAULT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_federal` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='catálogo de municipios';

/*Data for the table `cat_municipio` */

insert  into `cat_municipio`(`id`,`id_partido_politico`,`id_region`,`clave_federal`,`clave_estatal`,`nombre`,`nombre_federal`) values (1,3,2,1,0,'Acambay','Acambay de Ruíz Castañeda'),(2,3,5,2,0,'Acolman','Acolman'),(3,3,2,3,0,'Aculco','Aculco'),(4,3,6,4,0,'Almoloya de Alquisiras','Almoloya de Alquisiras'),(5,3,13,5,0,'Almoloya de Juárez','Almoloya de Juárez'),(6,3,13,6,0,'Almoloya del Río','Almoloya del Río'),(7,3,15,7,0,'Amanalco','Amanalco'),(8,3,10,8,0,'Amatepec','Amatepec'),(9,3,1,9,0,'Amecameca','Amecameca'),(10,1,16,10,0,'Apaxco','Apaxco'),(11,3,11,11,0,'Atenco','Atenco'),(12,3,7,12,0,'Atizapán','Atizapán'),(13,1,12,13,0,'Atizapán de Zaragoza','Atizapán de Zaragoza'),(14,3,2,14,0,'Atlacomulco','Atlacomulco'),(15,1,1,15,0,'Atlautla','Atlautla'),(16,3,5,16,0,'Axapusco','Axapusco'),(17,3,1,17,0,'Ayapango','Ayapango'),(18,4,13,18,0,'Calimaya','Calimaya'),(19,3,7,19,0,'Capulhuac','Capulhuac'),(20,3,1,25,0,'Chalco','Chalco'),(21,1,2,26,0,'Chapa de Mota','Chapa de Mota'),(22,3,13,27,0,'Chapultepec','Chapultepec'),(23,3,11,28,0,'Chiautla','Chiautla'),(24,3,3,29,0,'Chicoloapan','Chicoloapan'),(25,1,11,30,0,'Chiconcuac','Chiconcuac'),(26,3,3,31,0,'Chimalhuacán','Chimalhuacán'),(27,3,14,20,0,'Coacalco','Coacalco de Berriozábal'),(28,1,6,21,0,'Coatepec Harinas','Coatepec Harinas'),(29,3,1,22,0,'Cocotitlán','Cocotitlán'),(30,3,4,23,0,'Coyotepec','Coyotepec'),(31,3,14,24,0,'Cuautitlán','Cuautitlán'),(32,3,4,121,0,'Cuautitlán Izcalli','Cuautitlán Izcalli'),(33,3,15,32,0,'Donato Guerra','Donato Guerra'),(34,3,5,33,0,'Ecatepec','Ecatepec de Morelos'),(35,3,1,34,0,'Ecatzingo','Ecatzingo'),(36,3,2,64,0,'El Oro','El Oro'),(37,1,4,35,0,'Huehuetoca','Huehuetoca'),(38,1,16,36,0,'Hueypoxtla','Hueypoxtla'),(39,3,8,37,0,'Huixquilucan','Huixquilucan'),(40,3,8,38,0,'Isidro Fabela','Isidro Fabela'),(41,3,3,39,0,'Ixtapaluca','Ixtapaluca'),(42,2,6,40,0,'Ixtapan de la Sal','Ixtapan de la Sal'),(43,3,15,41,0,'Ixtapan del Oro','Ixtapan del Oro'),(44,3,2,42,0,'Ixtlahuaca','Ixtlahuaca'),(45,3,16,44,0,'Jaltenco','Jaltenco'),(46,3,2,45,0,'Jilotepec','Jilotepec'),(47,3,8,46,0,'Jilotzingo','Jilotzingo'),(48,3,7,47,0,'Jiquipilco','Jiquipilco'),(49,3,2,48,0,'Jocotitlán','Jocotitlán'),(50,1,6,49,0,'Joquicingo','Joquicingo'),(51,3,1,50,0,'Juchitepec','Juchitepec'),(52,3,3,70,0,'La Paz','La Paz'),(53,3,7,51,0,'Lerma','Lerma'),(54,2,10,123,0,'Luvianos','Luvianos'),(55,3,6,52,0,'Malinalco','Malinalco'),(56,3,14,53,0,'Melchor Ocampo','Melchor Ocampo'),(57,3,13,54,0,'Metepec','Metepec'),(58,3,13,55,0,'Mexicaltzingo','Mexicaltzingo'),(59,3,2,56,0,'Morelos','Morelos'),(60,3,8,57,0,'Naucalpan','Naucalpan de Juárez'),(61,1,16,59,0,'Nextlalpan','Nextlalpan'),(62,2,9,58,0,'Nezahualcóyotl','Nezahualcóyotl'),(63,3,8,60,0,'Nicolás Romero','Nicolás Romero'),(64,3,5,61,0,'Nopaltepec','Nopaltepec'),(65,3,7,62,0,'Ocoyoacac','Ocoyoacac'),(66,3,6,63,0,'Ocuilan','Ocuilan'),(67,1,5,65,0,'Otumba','Otumba'),(68,3,15,66,0,'Otzoloapan','Otzoloapan'),(69,3,7,67,0,'Otzolotepec','Otzolotepec'),(70,3,1,68,0,'Ozumba','Ozumba'),(71,3,11,69,0,'Papalotla','Papalotla'),(72,3,2,71,0,'Polotitlán','Polotitlán'),(73,4,13,72,0,'Rayón','Rayón'),(74,3,13,73,0,'San Antonio la Isla','San Antonio la Isla'),(75,3,2,74,0,'San Felipe del Progreso','San Felipe del Progreso'),(76,3,2,124,0,'San José del Rincón','San José del Rincón'),(77,3,5,75,0,'San Martín de las Pirámides','San Martín de las Pirámides'),(78,3,7,76,0,'San Mateo Atenco','San Mateo Atenco'),(79,2,6,77,0,'San Simón de Guerrero','San Simón de Guerrero'),(80,2,15,78,0,'Santo Tomás','Santo Tomás'),(81,3,2,79,0,'Soyaniquilpan','Soyaniquilpan de Juárez'),(82,3,6,80,0,'Sultepec','Sultepec'),(83,3,5,81,0,'Tecámac','Tecámac'),(84,3,10,82,0,'Tejupilco','Tejupilco'),(85,4,1,83,0,'Temamatla','Temamatla'),(86,3,5,84,0,'Temascalapa','Temascalapa'),(87,3,2,85,0,'Temascalcingo','Temascalcingo'),(88,3,6,86,0,'Temascaltepec','Temascaltepec'),(89,3,7,87,0,'Temoaya','Temoaya'),(90,3,6,88,0,'Tenancingo','Tenancingo'),(91,3,1,89,0,'Tenango del Aire','Tenango del Aire'),(92,3,13,90,0,'Tenango del Valle','Tenango del Valle'),(93,3,14,91,0,'Teoloyucan','Teoloyucan'),(94,2,5,92,0,'Teotihuacán','Teotihuacán'),(95,3,11,93,0,'Tepetlaoxtoc','Tepetlaoxtoc'),(96,3,1,94,0,'Tepetlixpa','Tepetlixpa'),(97,3,4,95,0,'Tepotzotlán','Tepotzotlán'),(98,1,16,96,0,'Tequixquiac','Tequixquiac'),(99,1,6,97,0,'Texcaltitlán','Texcaltitlán'),(100,3,13,98,0,'Texcalyacac','Texcalyacac'),(101,4,11,99,0,'Texcoco','Texcoco'),(102,3,11,100,0,'Tezoyuca','Tezoyuca'),(103,3,7,101,0,'Tianguistenco','Tianguistenco'),(104,3,2,102,0,'Timilpan','Timilpan'),(105,3,1,103,0,'Tlalmanalco','Tlalmanalco'),(106,3,12,104,0,'Tlalnepantla','Tlalnepantla de Baz'),(107,2,10,105,0,'Tlatlaya','Tlatlaya'),(108,3,13,106,0,'Toluca','Toluca'),(109,3,16,125,0,'Tonanitla','Tonanitla'),(110,2,6,107,0,'Tonatico','Tonatico'),(111,2,14,108,0,'Tultepec','Tultepec'),(112,3,14,109,0,'Tultitlán','Tultitlán'),(113,1,15,110,0,'Valle de Bravo','Valle de Bravo'),(114,2,1,122,0,'Valle de Chalco Solidaridad','Valle de Chalco Solidaridad'),(115,2,15,111,0,'Villa de Allende','Villa de Allende'),(116,3,4,112,0,'Villa del Carbón','Villa del Carbón'),(117,3,6,113,0,'Villa Guerrero','Villa Guerrero'),(118,3,15,114,0,'Villa Victoria','Villa Victoria'),(119,3,7,43,0,'Xalatlaco','Xalatlaco'),(120,4,7,115,0,'Xonacatlán','Xonacatlán'),(121,3,15,116,0,'Zacazonapan','Zacazonapan'),(122,1,6,117,0,'Zacualpan','Zacualpan'),(123,3,13,118,0,'Zinacantepec','Zinacantepec'),(124,1,6,119,0,'Zumpahuacán','Zumpahuacán'),(125,3,16,120,0,'Zumpango','Zumpango');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
