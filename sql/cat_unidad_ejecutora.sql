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
/*Table structure for table `cat_unidad_ejecutora` */

CREATE TABLE `cat_unidad_ejecutora` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_sector` smallint(6) NOT NULL,
  `id_clasificacion_sectorial` tinyint(4) DEFAULT NULL,
  `clave` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `id_titular` smallint(6) NOT NULL,
  `bactivo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='catálogo de las unidades ejecutoras';

/*Data for the table `cat_unidad_ejecutora` */

insert  into `cat_unidad_ejecutora`(`id`,`id_sector`,`id_clasificacion_sectorial`,`clave`,`nombre`,`id_titular`,`bactivo`) values (1,1,2,NULL,'Coordinación de Delegaciones Regionales de Desarrollo Agropecuario',0,1),(2,1,2,NULL,'Dirección General de Agricultura',0,1),(3,1,2,NULL,'Dirección General de Desarrollo Rural y Comercialización',0,1),(4,1,2,NULL,'Dirección General de Infraestructura Rural',0,1),(5,1,2,NULL,'Dirección General Pecuaria',0,1),(6,1,1,NULL,'Instituto de Investigación y Capacitación Agropecuaria, Acuícola y Forestal del Estado de México',0,1),(7,2,1,NULL,'Comisión del Agua del Estado de México',0,1),(8,2,2,NULL,'Dirección General de Administración de Obra Publica',0,1),(9,2,2,NULL,'Dirección General de Construcción de Obra Pública',0,1),(10,2,2,NULL,'Dirección General de Electrificacion',0,1),(11,2,2,NULL,'Oficina del C. Srio. Agua y OP.',0,1),(12,2,2,NULL,'Subsecretaría del Agua y Obra Pública',0,1),(13,3,1,NULL,'Sistema para el Desarrollo Integral de la Familia del Estado de Mexico',0,1),(14,4,3,NULL,'Acambay',1,1),(15,4,3,NULL,'Acolman',2,1),(16,4,3,NULL,'Aculco',3,1),(17,4,3,NULL,'Almoloya de Alquisiras',4,1),(18,4,3,NULL,'Almoloya de Juárez',5,1),(19,4,3,NULL,'Almoloya del Río',6,1),(20,4,3,NULL,'Amanalco',7,1),(21,4,3,NULL,'Amatepec',8,1),(22,4,3,NULL,'Amecameca',9,1),(23,4,3,NULL,'Apaxco',10,1),(24,4,3,NULL,'Atenco',11,1),(25,4,3,NULL,'Atizapán',12,1),(26,4,3,NULL,'Atizapán de Zaragoza',13,1),(27,4,3,NULL,'Atlacomulco',14,1),(28,4,3,NULL,'Atlautla',15,1),(29,4,3,NULL,'Axapusco',16,1),(30,4,3,NULL,'Ayapango',17,1),(31,4,3,NULL,'Calimaya',18,1),(32,4,3,NULL,'Capulhuac',19,1),(33,4,3,NULL,'Chalco',20,1),(34,4,3,NULL,'Chapa de Mota',21,1),(35,4,3,NULL,'Chapultepec',22,1),(36,4,3,NULL,'Chiautla',23,1),(37,4,3,NULL,'Chicoloapan',24,1),(38,4,3,NULL,'Chiconcuac',25,1),(39,4,3,NULL,'Chimalhuacán',26,1),(40,4,3,NULL,'Coacalco',27,1),(41,4,3,NULL,'Coatepec Harinas',28,1),(42,4,3,NULL,'Cocotitlán',29,1),(43,4,3,NULL,'Coyotepec',30,1),(44,4,3,NULL,'Cuautitlán',31,1),(45,4,3,NULL,'Cuautitlán Izcalli',32,1),(46,4,3,NULL,'Donato Guerra',33,1),(47,4,3,NULL,'Ecatepec',34,1),(48,4,3,NULL,'Ecatzingo',35,1),(49,4,3,NULL,'El Oro',36,1),(50,4,3,NULL,'Huehuetoca',37,1),(51,4,3,NULL,'Hueypoxtla',38,1),(52,4,3,NULL,'Huixquilucan',39,1),(53,4,3,NULL,'Isidro Fabela',40,1),(54,4,3,NULL,'Ixtapaluca',41,1),(55,4,3,NULL,'Ixtapan de la Sal',42,1),(56,4,3,NULL,'Ixtapan del Oro',43,1),(57,4,3,NULL,'Ixtlahuaca',44,1),(58,4,3,NULL,'Jaltenco',45,1),(59,4,3,NULL,'Jilotepec',46,1),(60,4,3,NULL,'Jilotzingo',47,1),(61,4,3,NULL,'Jiquipilco',48,1),(62,4,3,NULL,'Jocotitlán',49,1),(63,4,3,NULL,'Joquicingo',50,1),(64,4,3,NULL,'Juchitepec',51,1),(65,4,3,NULL,'La Paz',52,1),(66,4,3,NULL,'Lerma',53,1),(67,4,3,NULL,'Luvianos',54,1),(68,4,3,NULL,'Malinalco',55,1),(69,4,3,NULL,'Melchor Ocampo',56,1),(70,4,3,NULL,'Metepec',57,1),(71,4,3,NULL,'Mexicaltzingo',58,1),(72,4,3,NULL,'Morelos',59,1),(73,4,3,NULL,'Naucalpan',60,1),(74,4,3,NULL,'Nextlalpan',61,1),(75,4,3,NULL,'Nezahualcóyotl',62,1),(76,4,3,NULL,'Nicolás Romero',63,1),(77,4,3,NULL,'Nopaltepec',64,1),(78,4,3,NULL,'Ocoyoacac',65,1),(79,4,3,NULL,'Ocuilan',66,1),(80,4,3,NULL,'Otumba',67,1),(81,4,3,NULL,'Otzoloapan',68,1),(82,4,3,NULL,'Otzolotepec',69,1),(83,4,3,NULL,'Ozumba',70,1),(84,4,3,NULL,'Papalotla',71,1),(85,4,3,NULL,'Polotitlán',72,1),(86,4,3,NULL,'Rayón',73,1),(87,4,3,NULL,'San Antonio la Isla',74,1),(88,4,3,NULL,'San Felipe del Progreso',75,1),(89,4,3,NULL,'San José del Rincón',76,1),(90,4,3,NULL,'San Martín de las Pirámides',77,1),(91,4,3,NULL,'San Mateo Atenco',78,1),(92,4,3,NULL,'San Simón de Guerrero',79,1),(93,4,3,NULL,'Santo Tomás',80,1),(94,4,3,NULL,'Soyaniquilpan',81,1),(95,4,3,NULL,'Sultepec',82,1),(96,4,3,NULL,'Tecámac',83,1),(97,4,3,NULL,'Tejupilco',84,1),(98,4,3,NULL,'Temamatla',85,1),(99,4,3,NULL,'Temascalapa',86,1),(100,4,3,NULL,'Temascalcingo',87,1),(101,4,3,NULL,'Temascaltepec',88,1),(102,4,3,NULL,'Temoaya',89,1),(103,4,3,NULL,'Tenancingo',90,1),(104,4,3,NULL,'Tenango del Aire',91,1),(105,4,3,NULL,'Tenango del Valle',92,1),(106,4,3,NULL,'Teoloyucan',93,1),(107,4,3,NULL,'Teotihuacán',94,1),(108,4,3,NULL,'Tepetlaoxtoc',95,1),(109,4,3,NULL,'Tepetlixpa',96,1),(110,4,3,NULL,'Tepotzotlán',97,1),(111,4,3,NULL,'Tequixquiac',98,1),(112,4,3,NULL,'Texcaltitlán',99,1),(113,4,3,NULL,'Texcalyacac',100,1),(114,4,3,NULL,'Texcoco',101,1),(115,4,3,NULL,'Tezoyuca',102,1),(116,4,3,NULL,'Tianguistenco',103,1),(117,4,3,NULL,'Timilpan',104,1),(118,4,3,NULL,'Tlalmanalco',105,1),(119,4,3,NULL,'Tlalnepantla',106,1),(120,4,3,NULL,'Tlatlaya',107,1),(121,4,3,NULL,'Toluca',108,1),(122,4,3,NULL,'Tonanitla',109,1),(123,4,3,NULL,'Tonatico',110,1),(124,4,3,NULL,'Tultepec',111,1),(125,4,3,NULL,'Tultitlán',112,1),(126,4,3,NULL,'Valle de Bravo',113,1),(127,4,3,NULL,'Valle de Chalco Solidaridad',114,1),(128,4,3,NULL,'Villa de Allende',115,1),(129,4,3,NULL,'Villa del Carbón',116,1),(130,4,3,NULL,'Villa Guerrero',117,1),(131,4,3,NULL,'Villa Victoria',118,1),(132,4,3,NULL,'Xalatlaco',119,1),(133,4,3,NULL,'Xonacatlán',120,1),(134,4,3,NULL,'Zacazonapan',121,1),(135,4,3,NULL,'Zacualpan',122,1),(136,4,3,NULL,'Zinacantepec',123,1),(137,4,3,NULL,'Zumpahuacán',124,1),(138,4,3,NULL,'Zumpango',125,1),(139,5,2,NULL,'Dirección General de Infraestructura  para el Transporte de Alta Capacidad.',0,1),(140,5,2,NULL,'Dirección General de Vialidad',0,1),(141,5,1,NULL,'Junta de Caminos del Estado de México',0,0),(142,5,1,'2290000001','Sistema de Autopistas, Aeropuertos, Servicios Conexos y Auxiliares del Estado de México',0,1),(143,5,1,NULL,'Sistema de Transporte Masivo y Teleférico del Estado de México',0,1),(144,6,2,NULL,'Dirección General del Registro Civil',0,1),(145,7,4,NULL,'Inspección General de las Instituciones de Seguridad Pública del Estado de México',0,1),(146,8,2,NULL,'Dirección General de Cultura Física y Deporte',0,1),(147,8,2,NULL,'Direccíon General de Patrimonio y Servicios Culturales',0,1),(148,9,2,NULL,'Comisión Estatal de Mejora Regulatoria',0,1),(149,9,2,NULL,'Coordinación de Fomento Económico y Competividad',0,1),(150,9,2,NULL,'Dirección General de Atención Empresarial',0,1),(151,9,2,NULL,'Dirección General de Comercio',0,1),(152,9,2,NULL,'Dirección General de Industria',0,1),(153,9,1,NULL,'Fideicomiso para el Desarrollo de Parques y Zonas Industriales en el Estado de México',0,1),(154,9,1,NULL,'Instituto de Fomento Minero y Estudios Geológicos del Estado de México',0,1),(155,9,1,NULL,'Instituto Mexiquense del Emprendedor',0,1),(156,9,2,NULL,'Oficina del C. Srio. Económico',0,1),(157,10,2,NULL,'Dirección General de Coordinación Metropolitana',0,1),(158,11,1,NULL,'Consejo de Investigación y Evaluación de la Politica Social',0,1),(159,11,1,NULL,'Consejo Estatal de la Mujer y Bienestar Social',0,1),(160,11,1,NULL,'Consejo Estatal para el Desarrollo Integral de los Pueblos Indigenas del Estado de México',0,1),(161,11,2,NULL,'Dirección General de Programas Sociales',0,1),(162,11,2,NULL,'Dirección General de Promoción para el Desarrollo Social',0,1),(163,11,1,NULL,'Instituto Mexiquense de la Juventud',0,1),(164,11,1,NULL,'Junta de Asistencia Privada del Estado de México',0,1),(165,12,2,NULL,'Dirección General de Operación Urbana',0,1),(166,12,2,NULL,'Dirección General de Planeación Urbana',0,1),(167,12,1,NULL,'Instituto Mexiquense de la Vivienda Social',0,1),(168,13,1,NULL,'Colegio de Bachilleres del Estado de Mexico',0,1),(169,13,1,NULL,'Colegio de Educación Profesional Técnica del Estado de México',0,1),(170,13,1,NULL,'Colegio de Estudios Cientificos y Tecnologicos del Estado de Mexico',0,1),(171,13,2,NULL,'Dirección General de Administración y Finanzas',0,1),(172,13,2,NULL,'Dirección General de Educación Media Superior',0,1),(173,13,2,NULL,'Dirección General de Educación Normal y Desarrollo Docente',0,1),(174,13,2,NULL,'Dirección General de Educación Superior',0,1),(175,13,1,NULL,'El Colegio Mexiquense, A.C.',0,1),(176,13,1,NULL,'Instituto Mexiquense de Cultura',0,1),(177,13,1,NULL,'Instituto Mexiquense de Cultura Física y Deporte',0,1),(178,13,1,NULL,'Instituto Mexiquense de la Infraestructura Física Educativa',0,1),(179,13,1,NULL,'Servicios Educativos Integrados al Estado de Mexico',0,1),(180,13,2,NULL,'Subsecretaría de Eduacion Basica y Normal',0,1),(181,13,2,NULL,'Subsecretaría de Educacion Media Superior y Superior',0,1),(182,13,2,NULL,'Subsecretaria de Planeación y Administración',0,1),(183,13,1,NULL,'Tecnológico de Estudios Superiores de Chalco',0,1),(184,13,1,NULL,'Tecnológico de Estudios Superiores de Chimalhuacán',0,1),(185,13,1,NULL,'Tecnológico de Estudios Superiores de Coacalco',0,1),(186,13,1,NULL,'Tecnológico de Estudios Superiores de Cuautitlan Izcalli',0,1),(187,13,1,NULL,'Tecnológico de Estudios Superiores de Ecatepec',0,1),(188,13,1,NULL,'Tecnológico de Estudios Superiores de Huixquilucan',0,1),(189,13,1,NULL,'Tecnológico de Estudios Superiores de Ixtapaluca',0,1),(190,13,1,NULL,'Tecnológico de Estudios Superiores de Jilotepec',0,1),(191,13,1,NULL,'Tecnológico de Estudios Superiores de Jocotitlán',0,1),(192,13,1,NULL,'Tecnológico de Estudios Superiores de San Felipe del Progreso',0,1),(193,13,1,NULL,'Tecnológico de Estudios Superiores de Tianguistenco',0,1),(194,13,1,NULL,'Tecnológico de Estudios Superiores de Valle de Bravo',0,1),(195,13,1,NULL,'Tecnológico de Estudios Superiores de Villa Guerrero',0,1),(196,13,1,NULL,'Tecnológico de Estudios Superiores del Oriente del Estado de Mexico',0,1),(197,13,4,NULL,'Universidad Autonoma del Estado de Mexico',0,1),(198,13,1,NULL,'Universidad Estatal del Valle de Ecatepec',0,1),(199,13,1,NULL,'Universidad Estatal del Valle de Toluca',0,1),(200,13,1,NULL,'Universidad Intercultural del Estado de Mexico',0,1),(201,13,1,NULL,'Universidad Mexiquense del Bicentenario',0,1),(202,13,1,NULL,'Universidad Politécnica de Atlautla',0,1),(203,13,1,NULL,'Universidad Politécnica de Otzolotepec',0,1),(204,13,1,NULL,'Universidad Politécnica de Tecámac',0,1),(205,13,1,NULL,'Universidad Politécnica de Texcoco',0,1),(206,13,1,NULL,'Universidad Politécnica del Valle de Mexico',0,1),(207,13,1,NULL,'Universidad Politécnica del Valle de Toluca',0,1),(208,13,1,NULL,'Universidad Tecnológica \"Fidel Velázquez\"',0,1),(209,13,1,NULL,'Universidad Tecnológica de Nezahualcóyotl',0,1),(210,13,1,NULL,'Universidad Tecnológica de Tecamac',0,1),(211,13,1,NULL,'Universidad Tecnológica de Zinacantepec',0,1),(212,13,1,NULL,'Universidad Tecnológica del Sur del Estado de México',0,1),(213,13,1,NULL,'Universidad Tecnológica del Valle de Toluca',0,1),(214,14,1,NULL,'Comité de Planeación para el Desarrollo del Estado de México',0,1),(215,14,1,NULL,'Consejo Mexiquense de Ciencia y Tecnología',0,1),(216,14,2,NULL,'Contaduría General Gubernamental',0,1),(217,14,2,NULL,'Coordinación Administrativa de Finanzas',0,1),(218,14,2,NULL,'Coordinación de Gestion Gubernamental',0,1),(219,14,2,NULL,'Coordinación de Información y Estrategia',0,1),(220,14,2,NULL,'Coordinación de Servicios Aereos',0,1),(221,14,2,NULL,'Dirección General de  Personal',0,1),(222,14,2,NULL,'Dirección General de Crédito',0,1),(223,14,2,NULL,'Dirección General de Financiamiento de Proyectos',0,1),(224,14,2,NULL,'Dirección General de Fiscalización',0,1),(225,14,2,NULL,'Dirección General de Innovación',0,1),(226,14,2,NULL,'Dirección General de Inversión',0,1),(227,14,2,NULL,'Dirección General de Planeacion y Gasto Público',0,1),(228,14,2,NULL,'Dirección General de Recaudación',0,1),(229,14,2,NULL,'Dirección General de Recursos Materiales',0,1),(230,14,2,NULL,'Dirección General del Sistema Estatal de Informatica',0,1),(231,14,2,NULL,'Fideicomiso Público para la Construcción de Centros Preventivos y de Readaptación Social en el Estado de México Denominado \"Fideicomiso C3\"',0,1),(232,14,1,NULL,'Instituto de Información e Investigación Geográfica, Estadística y Catastral del Estado de México',0,1),(233,14,1,NULL,'Instituto Hacendario del Estado de México',0,1),(234,14,2,NULL,'Secretaría Técnica del Consejo Mexiquense de Infraestructura',0,1),(235,14,2,NULL,'Subsecretaría de Ingresos',0,1),(236,14,2,NULL,'Subsecretaría de Planeación y Presupuesto',0,1),(237,14,2,NULL,'Subsecretaría de Tesoreria',0,1),(238,14,2,NULL,'Unidad de Apoyo a la Administración General',0,1),(239,15,2,NULL,'Centro de Control de Confianza del Estado de México',0,1),(240,15,2,NULL,'Comisión Estatal de Seguridad Ciudadana del Estado de México',0,1),(241,15,2,NULL,'Coordinación Administrativa',0,1),(242,15,2,NULL,'Coordinación General de Protección Civil',0,1),(243,15,2,NULL,'Dirección General de Prevencion y Readaptación Social',0,1),(244,15,2,NULL,'Dirección General de Seguridad Pública y Transito',0,1),(245,15,2,NULL,'Dirección General del Registro Publico de la Propiedad',0,1),(246,15,2,NULL,'Dirección General Jurídica y Consultiva',0,1),(247,15,2,NULL,'Instituto de la Defensoría Pública del Estado de México',0,1),(248,15,1,NULL,'Instituto de la Función Registral del Estado de México',0,1),(249,15,2,NULL,'Oficina del C. Srio. Gral. Gobierno',0,1),(250,15,2,NULL,'Secretariado Ejecutivo del Sistema Estatal de Seguridad Pública',0,1),(251,15,2,NULL,'Subsecretaría de Asuntos Jurídicos',0,1),(252,15,2,NULL,'Subsecretaría de Desarrollo Municipal',0,1),(253,15,2,NULL,'Subsecretaría de Desarrollo Politico',0,1),(254,15,2,NULL,'Subsecretaría General de Gobierno',0,1),(255,16,1,NULL,'Instituto de Seguridad Social del Estado de Mexico y Municipios',0,1),(256,17,4,NULL,'Instituto de Transparencia, Acceso a la Información Pública y Protección de Datos Personales del Estado de México y Municipios',0,1),(257,18,2,NULL,'Dirección General de Administración',0,1),(258,19,1,NULL,'Comision Estatal de Parques Naturales y de la Fauna',0,1),(259,19,2,NULL,'Coordinación General de Conservación Ecologica',0,1),(260,19,2,NULL,'Dirección General de Ordenamiento e Impacto Ambiental',0,1),(261,19,2,NULL,'Dirección General de Prevención y Control de la Contaminacion Atmosférica',0,1),(262,19,2,NULL,'Instituto Estatal de Energía y Cambio Climático',0,1),(263,19,2,NULL,'Oficina del C. Srio. Medio Ambiente',0,1),(264,19,1,NULL,'Procuraduría de Protección al Ambiente del Estado de México',0,1),(265,19,1,NULL,'Protectora de Bosques del Estado de Mexico',0,1),(266,19,1,NULL,'Reciclagua Ambiental, S.A. de C.V.',0,1),(267,20,1,NULL,'Poder Judicial',0,1),(268,21,1,NULL,'Sistema de Radio y Televisión Mexiquense',0,1),(269,22,1,'2150000000','Banco de Tejidos del Estado de México',0,1),(270,22,1,NULL,'Hospital Regional de Alta Especialidad de Zumpango',0,1),(271,22,1,NULL,'Instituto de Salud del Estado de México',0,1),(272,22,1,NULL,'Instituto Materno Infantil del Estado de Mexico',0,1),(273,23,2,NULL,'Centro de Mando y Comunicación',0,1),(274,23,2,NULL,'Dirección General de Administración y Servicios',0,1),(275,23,2,NULL,'Dirección General de Prevención y Readaptación social',0,1),(276,23,2,NULL,'Dirección General de Protección Civil',0,1),(277,23,2,NULL,'Secretaría Técnica',0,1),(278,24,2,NULL,'Dirección General de la Previsión Social',0,1),(279,24,1,NULL,'Instituto de Capacitación y Adiestramiento para el Trabajo Industrial',0,1),(280,24,2,NULL,'Procuraduria de la Defensa del Trabajo',0,1),(281,25,2,NULL,'Instituto del Transporte del Estado de México',0,1),(282,25,2,NULL,'Oficina del C. Srio. Transporte',0,1),(283,26,1,NULL,'Comisión para el Desarrollo Turistico del Valle de Teotihuacán',0,1),(284,26,2,NULL,'Dirección General de Turismo',0,1),(285,26,1,NULL,'Instituto de Investigacion y Fomento de las Artesanias del Estado de Mexico',0,1),(286,1,2,NULL,'Subsecretaría de Desarrollo Agropecuario',0,1),(287,5,2,NULL,'Coordinación de Seguimiento y Evaluación Sectorial',0,1),(289,25,2,NULL,'Coordinación de Política Regional',0,1),(290,25,2,NULL,'Dirección General de Asuntos Jurídicos',0,1),(291,25,2,NULL,'Dirección General del Registro Estatal de Transporte Público',0,1),(292,25,2,NULL,'Dirección General de Movilidad Zona I',0,1),(293,25,2,NULL,'Dirección General de Movilidad Zona II',0,1),(294,25,2,NULL,'Dirección General de Movilidad Zona III',0,1),(295,25,2,NULL,'Dirección General de Movilidad Zona IV',0,1),(296,18,2,NULL,'Procuraduría General de Justicia',0,1),(297,6,NULL,'2050000000','prueba1',0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
