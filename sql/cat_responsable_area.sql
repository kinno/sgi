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
/*Table structure for table `cat_responsable_area` */

CREATE TABLE `cat_responsable_area` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='catálogo de los responsables por área';

/*Data for the table `cat_responsable_area` */

insert  into `cat_responsable_area`(`id`,`titulo`,`nombre`,`apellido`,`cargo`) values (1,'M. en A.','Carlos Daniel','Aportela Rodríguez','Subsecretario de Planeación y Presupuesto'),(2,'','José Luis','Gómez Martínez','Director General de Inversión'),(3,'Ing.','José Samuel','Negrete Lara','Jefe de la Unidad de Sistemas e Informática'),(4,'Lic.','Alfonso','Pulido Solares','Jefe de la Unidad de Normatividad'),(5,'Mtro','Tomás','Valladares Maldonado','Director Fondo Metropolitano'),(6,'C.','Daniel','Romero Manjarrez','Responsable de Evaluación de Proyectos'),(7,'Lic.','Carlos','González Cruz','Director de proyectos de Inversión para el Desarrollo Económico'),(8,'Lic.','Abraham Israel','Badia Vargas','Director de Proyectos de Inversión para el Desarrollo Social'),(9,'Ing.','Luis Guillermo','Moreno Hinojosa','Director de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura'),(10,'C.','Victor Manuel','Díaz Reyes','Directo de Registro y Contol de la Inversión'),(11,'Arq.','Arturo','Reyes Ramírez','Jefe del Departamento de Comunicaciones y Transporte'),(12,'C.','Daniel','Romero Manjarrez','Jefe del Departamento de Proyectos de Inversión para el Desarrollo Social'),(13,'P. L.A.P.','Benito','Serafin Salazar','Jefe del Departamento de Proyectos de Inversión para Agua, Medio Ambiente y Agricultura'),(14,'C. P.','Mario','Téllez Moreno','Jefe del Departamento de Registro y Control Municipal'),(15,'Lic','Diana de los Angeles','Gómez Tovar','Jefe del Departamento de Registro y Control de la Inversión');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
