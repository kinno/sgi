-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sgiweb_db
-- ------------------------------------------------------
-- Server version	5.7.9-log

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
-- Table structure for table `cat_departamento`
--

DROP TABLE IF EXISTS `cat_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_departamento` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` tinyint(4) NOT NULL,
  `id_responsable` smallint(6) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `bctivo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='catálogo de los departamentos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_departamento`
--

LOCK TABLES `cat_departamento` WRITE;
/*!40000 ALTER TABLE `cat_departamento` DISABLE KEYS */;
INSERT INTO `cat_departamento` VALUES (1,7,13,'Departamento de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura',1),(2,8,11,'Departamento de Comunicaciones y Transporte',1),(3,9,12,'Departamento de Proyectos de Inversión para el Desarrollo Social',1),(4,10,15,'Departamento de Registro y Control de la Inversión',1),(5,10,14,'Departamento de Registro y Control Municipal',1);
/*!40000 ALTER TABLE `cat_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_responsable_area`
--

DROP TABLE IF EXISTS `cat_responsable_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_responsable_area` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `iniciales` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='catálogo de los responsables por área';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_responsable_area`
--

LOCK TABLES `cat_responsable_area` WRITE;
/*!40000 ALTER TABLE `cat_responsable_area` DISABLE KEYS */;
INSERT INTO `cat_responsable_area` VALUES (1,'M. en A.','Carlos Daniel','Aportela Rodríguez','Subsecretario de Planeación y Presupuesto','CDAR'),(2,'','José Luis','Gómez Martínez','Director General de Inversión','JLGM'),(3,'Ing.','José Samuel','Negrete Lara','Jefe de la Unidad de Sistemas e Informática','JSNL'),(4,'Lic.','Alfonso','Pulido Solares','Jefe de la Unidad de Normatividad','APS'),(5,'Mtro','Tomás','Valladares Maldonado','Director Fondo Metropolitano','TVM'),(6,'C.','Daniel','Romero Manjarrez','Responsable de Evaluación de Proyectos','DRM'),(7,'Lic.','Carlos','González Cruz','Director de proyectos de Inversión para el Desarrollo Económico','CGC'),(8,'Lic.','Abraham Israel','Badia Vargas','Director de Proyectos de Inversión para el Desarrollo Social','ABV'),(9,'Ing.','Luis Guillermo','Moreno Hinojosa','Director de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura','LGMH'),(10,'C.','Victor Manuel','Díaz Reyes','Directo de Registro y Contol de la Inversión','VMDR'),(11,'Arq.','Arturo','Reyes Ramírez','Jefe del Departamento de Comunicaciones y Transporte','ARR'),(12,'C.','Daniel','Romero Manjarrez','Jefe del Departamento de Proyectos de Inversión para el Desarrollo Social','DRM'),(13,'P. L.A.P.','Benito','Serafin Salazar','Jefe del Departamento de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura','BSS'),(14,'C. P.','Mario','Téllez Moreno','Jefe del Departamento de Registro y Control Municipal','MTM'),(15,'Lic','Diana de los Angeles','Gómez Tovar','Jefe del Departamento de Registro y Control de la Inversión','DAGT');
/*!40000 ALTER TABLE `cat_responsable_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_servidor_publico`
--

DROP TABLE IF EXISTS `cat_servidor_publico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_servidor_publico` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(5) DEFAULT NULL,
  `cargo` varchar(85) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `iniciales` varchar(5) DEFAULT NULL,
  `nombre` varchar(70) DEFAULT NULL,
  `id_sector` smallint(2) DEFAULT NULL,
  `bactivo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='catálogo de servidores públicos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_servidor_publico`
--

LOCK TABLES `cat_servidor_publico` WRITE;
/*!40000 ALTER TABLE `cat_servidor_publico` DISABLE KEYS */;
INSERT INTO `cat_servidor_publico` VALUES (1,'spp','Subsecretario de Planeación y Presupuesto','2017-09-15','2011-05-06','CDAR','M. en A. Carlos Daniel Aportela Rodríguez',NULL,1),(2,'scem','Secretario de la Contraloría','2017-09-15','2011-05-06','AHV','Lic. Alejandro Hinojosa Velasco',NULL,1),(3,'gem','Gobernador Constitucional del Estado de México','2017-09-15','2011-09-16','EAV','Dr. Eruviel Ávila Villegas',NULL,1),(4,'dgpgp','Director General de Planeación y Gasto Público','2017-12-30','2011-10-01','OSSS','Mtro. Oscar Sergio Salgado Soto',NULL,1),(5,'secom','Secretario de Comunicaciones','2017-09-15','2011-09-16','AMV','M. en A. P. Apolinar Mena Vargas',NULL,1),(6,'saop','Secretario del Agua y Obra Pública','2017-09-15','2011-09-16','MOG','Ing. Manuel Ortiz García',NULL,1),(7,'dgi','Director General de Inversión','2017-12-31','2012-10-01','JLGM','José Luis Gómez Martínez',NULL,1),(8,'dgids','Director General de Promoción para el Desarrollo Social','2017-12-31','2013-04-10','HBF','Mtro. Heberto Barrera Fortoul',NULL,1),(9,'uaag','Jefe de la Unidad de Apoyo a la Administración General','2017-09-15','2014-01-01','FVG','Arq. Federico Vázquez Gómez',NULL,1),(10,'mdam','Secretario del Medio Ambiente','2017-12-31','2014-05-01','CJRS','M. en D. Cruz Juvenal Roa Sánchez',NULL,1),(11,'sgcd','Secretario de Seguridad Ciudadana','2017-12-31','2014-05-01','DCM','Lic. Damian Canales Mena',NULL,1),(12,'just','Procurador General de Justicia','2017-12-31','2014-05-01','AJGS','Lic. Alejandro Jaime Gómez Sánchez',NULL,1),(13,'dsur','Secretario de Desarrollo Urbano y Metropolitano','2017-09-15','2015-02-28','JATM','C. José Alfredo Torres Martínez',NULL,1),(14,'sf','Encargado del Despacho de la Secretaría de Finanzas','2017-09-15','2015-03-21','JGCT','Lic. Joaquín Guadalupe Castillo Torres',NULL,1),(16,'sscec','Subsecretario de Control y Evaluación de la Secretaría de la Contraloría','2016-02-17','2017-09-15','HSC','Lic. Héctor Solórzano Cruz',NULL,1);
/*!40000 ALTER TABLE `cat_servidor_publico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sgiweb_db'
--

--
-- Dumping routines for database 'sgiweb_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-31 13:17:47
