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
/*Table structure for table `cat_titular` */

CREATE TABLE `cat_titular` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COMMENT='catálogo de titulares';

/*Data for the table `cat_titular` */

insert  into `cat_titular`(`id`,`titulo`,`nombre`,`apellido`,`cargo`) values (1,'PROFESOR','IRINEO','GONZÁLEZ','PRESIDENTE'),(2,'LICENCIADO EN CIENCIAS POLITICAS Y ADMINISTRACIÓN PÚBLICA','VICENTE','ANAYA ÁGUILAR','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(3,'LICENCIADO EN ADMINISTRACIÓN PÚBLICA','SALVADOR','DEL RÍO MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(4,'INGENIERO','ARTEMIO','GOMEZ CRUZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(5,'INGENIERO AGRÓNOMO','VICENTE','ESTRADA INIESTA','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(6,'CIUDADANO','JUAN CARLOS','GUTIÉRREZ BOBADILLA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(7,'PROFESOR','RAFAEL','MERCADO SÁNCHEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(8,'PROFESOR','ALFREDO','VENCES JAIMES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(9,'CONTADOR PÚBLICO','CARLOS','SANTOS AMADOR','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(10,'LICENCIADO EN DERECHO','DANIEL','PARRA ÁNGELES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(11,'CIUDADANO','ILDEFONSO','SILVA VEGA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(12,'CIUDADANO','PAUL','REYES GUTIÉRREZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(13,'LICENCIADO EN ADMINISTRACIÓN DE EMPRESAS','PEDRO DAVID','RODRÍGUEZ VILLEGAS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(14,'MAESTRO EN ADMINISTRACIÓN','ARTURO NEMECIO NICOLÁS','VELEZ ESCAMILLA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(15,'CIUDADANO','RAÚL','NAVARRO RIVERA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(16,'LICENCIADO EN DERECHO','GILBERTO','RAMÍREZ ÁVILA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(17,'CIUDADANO','PEDRO ALFONSO','SÁNCHEZ SOLARES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(18,'TECNICO','OSCAR','VERGARA GÓMEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(19,'LICENCIADA EN DERECHO','LEYDI FABIOLA','LEYVA GARCÍA','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(20,'INGENIERO','FRANCISCO','OSORNO SOBERÓN','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(21,'CIUDADANO','EDUARDO','MARTÍNEZ VÁZQUEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(22,'CIUDADANO','CARLOS GERARDO','SERRANO FLORES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(23,'LICENCIADO EN DERECHO','GONZALO','BOJORQUES CONDE','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(24,'LICENCIADO EN DERECHO','ANDRÉS','AGUIRRE ROMERO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(25,'LICENCIADO EN ADMINISTRACIÓN','JORGE ALBERTO','GALVÁN VELASCO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(26,'INGENIERO AGRÓNOMO','TELÉSFORO','GARCÍA CARREÓN','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(27,'MAESTRO EN ADMINISTRACIÓN PÚBLICA','DAVID','SÁNCHEZ ISIDORO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(28,'CIUDADANO','GILBERTO','MENDEZ DÍAZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(29,'CONTADOR PÚBLICO','MIGUEL','FLORIN GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(30,'CIUDADANO','ALFREDO','ANGUIANO FUENTES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(31,'LICENCIADO EN ADMINISTRACIÓN DE EMPRESAS ','GABRIEL','CASILLAS ZANATTA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(32,'LICENCIADO EN DERECHO','HECTOR KARIM','CARVALLO DELFIN','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(33,'CONTADOR PÚBLICO','TOMAS','SANTIAGO FELIX','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(34,'MAESTRO EN CIENCIAS POLÍTICAS','PABLO','BEDOLLA LÓPEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(35,'CIUDADANO','AARÓN','VILLA CASTILLO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(36,'PASANTE DE LICENCIADO EN ADMINISTRACIÓN DE EMPRESAS','ROGELIO FERNANDO','GARNICA ZALDIVAR','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(37,'CONTADOR PÚBLICO','BENITO','JIMÉNEZ MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(38,'CIUDADANO','FRANCISCO JAVIER','SANTILLÁN SANTILLÁN','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(39,'MAESTRO EN ADMINISTRACIÓN PÚBLICA','CARLOS','IRIARTE MERCADO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(40,'CIUDADANA','ELIZETH VIRIDIANA','GONZÁLEZ MONDRAGÓN','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(41,'CIUDADANA','MARICELA','SERRANO HERNÁNDEZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(42,'CIUDADANO','IGNACIO','ÁVILA NAVARRETE','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(43,'CIUDADANO','FIDELIO DAGOBERTO','OSORIO SAENZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(44,'CIUDADANO','ÁNGEL ALBERTO','REBOLLO MONTES DE OCA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(45,'CIUDADANO','GABINO','PARIONES PARDÍNES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(46,'LICENCIADO EN DERECHO','EDGAR','CASTILLO MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(47,'LICENCIADO EN DERECHO','REYNALDO','TORRES GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(48,'CIUDADANO','JESÚS','AGUILAR HERNÁNDEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(49,'LICENCIADO EN DERECHO','JESÚS','MONROY MONROY','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(50,'CIUDADANO','AUGUSTO','GONZÁLEZ PÉREZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(51,'LICENCIADO EN ECONOMÍA','RAMIRO','RENDON BURGOS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(52,'INGENIERO QUÍMICO INDUSTRIAL','JUAN JOSÉ','MEDINA CABRERA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(53,'LICENCIADO EN CIENCIAS, POLITICAS Y ADMINISTRACIÓN PÚBL','FRANCISCO JAVIER ERIC','SEVILLA MONTES DE OCA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(54,'CIUDADANO','JOSÉ','BENÍTEZ BENÍTEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(55,'CIUDADANO','VIDAL','PÉREZ VARGAS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(56,'LICENCIADO EN DERECHO','ISIDRO','RIVAS JUÁREZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(57,'LICENCIADA EN DERECHO','CAROLINA','MONROY DEL MAZO','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(58,'CIUDADANO','EMIGDIO','VILLANUEVA NAVOR','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(59,'LICENCIADO EN DERECHO','IVAN','TRINIDAD MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(60,'LICENCIADO EN DERECHO','DAVID RICARDO','SÁNCHEZ GUEVARA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(61,'CIUDADANO','SERGIO','JUÁREZ BRIONES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(62,'LICENCIADO EN DERECHO','JUAN MANUEL','ZEPEDA HERNÁNDEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(63,'LICENCIADO EN DERECHO','MARTÍN','SOBREYRA PEÑA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(64,'CIUDADANO','RUBÉN','HERNÁNDEZ INFANTE','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(65,'CIUDADANO','ALFONSO','GONZÁLEZ GARCÍA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(66,'CIUDADANO','RAÚL ABILIO','GONZÁLEZ MÁRQUEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(67,'CIUDADANO','SILVESTRE','VICUÑA CORTÉS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(68,'CIUDADANO','ABELARDO','RODRÍGUEZ MONDRAGÓN','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(69,'LICENCIADO EN CIENCIAS POLITICAS Y ADMINISTRACIÓN PÚBLICA','CESAR','MOLINA PORTILLO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(70,'CONTADOR PÚBLICO','HUGO','GONZÁLEZ CORTÉZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(71,'CIUDADANO','ISAAC','MENDAROZQUETA BUENFIL','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(72,'CIUDADANA','MARÍA SILVIA','BARQUET MUÑOZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(73,'CIUDADANO','ERICK VLADIMIR','CEDILLO HINOJOSA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(74,'CIUDADANO','JOSÉ URIEL','TORRES ALDAMA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(75,'CIUDADANO','ABRAHAM','MONROY ESQUIVEL','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(76,'LICENCIADO','SERGIO ALONSO','VELASCO GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(77,'CIUDADANO','ARISTEO','DÍAZ MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(78,'LICENCIADA EN DERECHO','OLGA','PÉREZ SANABRIA','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(79,'CIUDADANO','MARIO','BERNAL ROSAS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(80,'CIUDADANO','PEDRO','CABRERA GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(81,'LICENCIADO EN DERECHO','GABRIEL','RUÍZ MARTÍNEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(82,'CIUDADANO','JOSÉ IVAN','DÍAZ FLORES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(83,'CIUDADANA','ROCIO','DÍAZ MONTOYA','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(84,'CONTADOR PÚBLICO','MANUEL','SANTÍN HERNÁNDEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(85,'CIUDADANO','JOSÉ ROSALIO','MUÑOZ LÓPEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(86,'CIUDADANO','GUILLERMO','FERNÁNDEZ PALAFOX','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(87,'CIUDADANO','JOSÉ RAMON','REYES RIVERA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(88,'CIUDADANO','JOSÉ ALEJANDRO','GALICIA NUÑEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(89,'LICENCIADO EN DERECHO','EFRAÍN HÉCTOR','VICTORIA FABIÁN','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(90,'PROFESOR','ANTONIO','SÁNCHEZ CASTAÑEDA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(91,'LICENCIADO EN DERECHO','ADIEL','ZERMANN MIGUEL','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(92,'ARQUITECTO','VICTOR MANUEL','AGUILAR TALAVERA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(93,'CIUDADANO','JUAN SALVADOR','MONTOYA MOYA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(94,'CIUDADANO','LUCIO RENE','MONTERRUBIO LÓPEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(95,'CIUDADANO','JOSÉ SALOME DONATO','SÁNCHEZ GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(96,'INGENIERO','JACINTO','PÉREZ PÉREZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(97,'INGENIERO','JUAN JOSÉ','MENDOZA ZUPPA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(98,'CIUDADANO','JUAN CARLOS','GONZÁLEZ HERNÁNDEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(99,'CIUDADANO','DANTE','LUJANO HUERTA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(100,'PROFESORA','TERESA','IZQUIERDO RAMÍREZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(101,'PROFESORA','DELFINA','GÓMEZ ALVAREZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(102,'CIUDADANO','ARTURO','AHUMADA CRUZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(103,'CONTADOR PÚBLICO','JESÚS','ARRATIA GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(104,'CIUDADANO','OSCAR','RODRÍGUEZ RUÍZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(105,'LICENCIADO EN MERCADOTECNIA','RUBÉN','REYES CARDOSO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(106,'LICENCIADO EN CIENCIAS POLITICAS Y ADMINISTRACIÓN PÚBLICA','PABLO','BASAÑEZ GARCÍA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(107,'INGENIERO','ARIEL','MORA ABARCA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(108,'LICENCIADA EN DERECHO','MARTHA HILDA','GONZÁLEZ CALDERÓN','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(109,'CIUDADANO','MIGUEL','MARTÍNEZ ORTÍZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(110,'DOCTOR','ELODIO','GORDILLO MENDEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(111,'PROFESOR','RAMÓN SERGIO','LUNA CORTÉZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(112,'MAESTRA EN DERECHO','SANDRA','MENDEZ HERNÁNDEZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(113,'MÉDICO VETERINARIO ZOOTECNISTA','FRANCISCO','REYNOSO ISRADE','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(114,'DOCTOR','JESÚS','SÁNCHEZ ISIDORO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(115,'PROFESOR','ARTURO','PIÑA GARCÍA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(116,'CIUDADANA','MA LOURDES','MONTIEL PAREDES','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(117,'CIUDADANO','SERGIO','ESTRADA GONZÁLEZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(118,'CIUDADANA','SARA','DOMÍNGUEZ ÁLVAREZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(119,'LICENCIADO EN DERECHO','FERNANDO','FERREYRA OLIVARES','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(120,'CIUDADANO','ARTURO JOAQUÍN','RUÍZ GUTIÉRREZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(121,'CIUDADANO','ODILÓN SAÚL','MEJÍA ARROYO','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(122,'CIUDADANO','JOSÉ','BAHENA GARCÍA','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(123,'CIUDADANA','OLGA','HERNÁNDEZ MARTÍNEZ','PRESIDENTA MUNICIPAL CONSTITUCIONAL'),(124,'TÉCNICO SUPERIOR UNIVERSITARIO','MARTÍN','MANCILLA ARIAS','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(125,'LICENCIADO','ABEL NEFTALI','DOMÍNGUEZ AZUZ','PRESIDENTE MUNICIPAL CONSTITUCIONAL'),(126,'cghg','ghg','gjhg','fdgfd'),(127,'INGENIERO CIVIL','MANUEL','ORTÍZ GARCÍA','SECRETARIO DEL AGUA Y OBRA PÚBLICA'),(128,'LICENCIADA','LUCILA ISABEL','ORIVE GUTIÉRREZ','DIRECTORA GENERAL DEL DIFEM'),(129,'MAESTRO EN ADMÓN. PÚBLICA','APOLINAR','MENA VARGAS','SECRETARIO DE COMUNICACIONES'),(130,'DOCTORA EN DERECHO','LUZ MARÍA','ZARZA DELGADO','CONSEJERA JURÍDICA DEL EJECUTIVO ESTATAL'),(131,'LICENCIADO','ALEJANDRO','HINOJOSA VELASCO','SECRETARIO DE LA CONTRALORÍA'),(132,'DOCTOR EN CIENCIAS','EDUARDO','GASCA PLIEGO','SECRETARIO DE CULTURA'),(133,'LICENCIADO','FÉLIX ADRIAN','FUENTES VILLALOBOS','SECRETARIO DE DESARROLLO ECONÓMICO'),(134,'LICENCIADO','ISIDRO','PASTOR MEDRANO','SECRETARIO DE DESARROLLO METROPOLITANO'),(135,'PROFESOR','ARTURO','OSORNIO SÁNCHEZ','SECRETARIO DE DESARROLLO SOCIAL'),(136,'CIUDADANO','JOSÉ ALFREDO','TORRES MARTÍNEZ','SECRETARIO DE DESARROLLO URBANO'),(137,'LICENCIADO','RAYMUNDO EDGAR','MARTÍNEZ CARBAJAL','SECRETARIO DE EDUCACIÓN'),(138,'LICENCIADO EN DERECHO','LUIS ÁNGEL','SERVÍN TREJO','COORDINADOR ADMINISTRATIVO DE LA SECRETARÍA DE FINANZAS'),(139,'MAESTRO EN DERECHO','JOSÉ SERGIO','MANZUR QUIROGA','SECRETARIO GENERAL DE GOBIERNO'),(140,'x','x','x','x'),(141,'DOCTORA EN DERECHO','JOSEFINA','ROMÁN VERGARA','COMISIONADA PRESIDENTA DEL ITAIPPEMyM'),(142,'LICENCIADO','ALEJANDRO JAIME','GÓMEZ SÁNCHEZ','PROCURADOR GENERAL DE JUSTICIA'),(143,'MAESTRO','CRUZ JUVENAL','ROA SÁNCHEZ','SECRETARIO DEL MEDIO AMBIENTE'),(144,'MAGISTRADO DR.','SERGIO JAVIER','MEDINA PEÑALOZA','PRESIDENTE DEL TRIBUNAL SUPERIOR DE JUSTICIA DEL ESTADO DE MÉXICO'),(145,'LICENCIADA','MARCELA','GONZÁLEZ SALAS','DIRECTORA GENERAL DEL SISTEMA DE RADIO Y TELEVISION MEXIQUENSE'),(146,'MAESTRO','CÉSAR NOMAR','GÓMEZ MONGE','SECRETARIO DE SALUD'),(147,'LICENCIADO','DAMIÁN','CANALES MENA','SECRETARIO DE SEGURIDAD CIUDADANA'),(148,'LICENCIADO','FRANCISCO JAVIER','GARCÍA BEJOS','SECRETARIO DEL TRABAJO'),(149,'P. DE INGENIERO INDUSTRIAL','JAIME HUMBERTO','BARRERA VELÁZQUEZ','SECRETARIO DE TRANSPORTE'),(150,'MAESTRA EN DERECHO FISCAL','ROSALINDA ELIZABETH','BENÍTEZ GONZÁLEZ','SECRETARIA DE TURISMO'),(151,'1','2','3','4'),(152,'gfhgf','hhgf','hg','ghgf'),(153,'1','2','3','4'),(154,'11','22','33','44'),(155,'11 a','22 a','33 a','44 a'),(156,'11','22','ok1','5678'),(159,'hgj','hj','hjh','hjhg'),(160,'df','fdf','dffds','fdsfds'),(161,'dsfds','dfds','dfds','dsf'),(163,'hkijkj','lkjkj','lkkj','lkjlkj'),(164,'oioi','ioi','poipi','poipi'),(165,'reter','ret','rter','trer');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
