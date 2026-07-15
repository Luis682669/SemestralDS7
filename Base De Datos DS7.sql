-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: capital_humano
-- ------------------------------------------------------
-- Server version	9.5.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '4fa8602f-bce5-11f0-8596-200b743fdffe:1-302';

--
-- Table structure for table `cargos_historial`
--

DROP TABLE IF EXISTS `cargos_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargos_historial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colaborador_id` int NOT NULL,
  `nombre_cargo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sueldo` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `es_activo` tinyint(1) DEFAULT '1',
  `integrity_signature` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colaborador_id` (`colaborador_id`),
  CONSTRAINT `cargos_historial_ibfk_1` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos_historial`
--

LOCK TABLES `cargos_historial` WRITE;
/*!40000 ALTER TABLE `cargos_historial` DISABLE KEYS */;
INSERT INTO `cargos_historial` VALUES (1,1,'Programador senior',5000.00,'2026-06-01',NULL,1,'T5WpfioZsJPcHVhUnCp6IU90zNlLCV+HJlbSc/LJ60k='),(2,2,'contable',2000.00,'2026-06-15',NULL,1,'BKZW1UlL47ZIl9Pz5OjwDNibbIPpoy2flkULdaEqLqs='),(3,29,'Psicólogo',2500.00,'2024-07-30',NULL,1,'+5H8DgPkOCOr5r/pW7PmE6QSl22RhHhD2ZkXCCHa7fQ='),(4,30,'Programador Frontend',3000.00,'2024-06-07',NULL,1,'PY9uVWMrfA7IWHA6PEKd6RnCysNnER4Tf8liRbCIaE8='),(5,31,'Programador',2344.00,'2026-03-12',NULL,1,'jmy/txc/FzTNFJNB/50fKBZqRt0pNuMjbzt0xc1phIw='),(6,32,'Programador',3000.00,'2024-06-12','2026-07-10',0,'Pv5LcwzoOAqHORQVnQEfKgL7ay7Q0ArsUl3xvl+xmQo='),(7,32,'Programador backend',3500.00,'2026-07-11',NULL,1,'69DxRjAxs21Dq4RQwBKCKn0REbjDvxwDKvjGcx553iU=');
/*!40000 ALTER TABLE `cargos_historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaboradores`
--

DROP TABLE IF EXISTS `colaboradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaboradores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `segundo_apellido` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sexo` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `foto_perfil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_general_ci,
  `correo_personal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departamento` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_contratacion` date NOT NULL,
  `tipo_contrato` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ocupacion` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `estatus` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'Activo',
  `empleado_activo` tinyint(1) DEFAULT '1',
  `historial_academico_pdf` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `integrity_signature` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identificacion` (`identificacion`),
  UNIQUE KEY `correo_personal` (`correo_personal`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaboradores`
--

LOCK TABLES `colaboradores` WRITE;
/*!40000 ALTER TABLE `colaboradores` DISABLE KEYS */;
INSERT INTO `colaboradores` VALUES (1,'8-1011-1708','Luis','Alberto','De Los Rios','Mapp','M','2004-08-07',NULL,'Villa grecia','luis.delosrios@utp.ac.pa','2456789','63476157','Sistemas','2026-02-28','Permanente','Programador','Activo',1,'1782856685_Kroki!.pdf','rX4XXYWVBkx6ZihjtEeKnF7IhRy7Q9muNreMZeU+hfk='),(2,'8-456-678','Pedro','Emmanuel','Gomez','Mendieta','M','2000-02-01',NULL,'Panama, Panama','pedro.gomez@utp.ac.ap','2456783','62222222','Contabilidad','2024-06-04','Eventual','Contable','Activo',1,'1782867005_Kroki!.pdf','93CnLfX1qc//elFJMCq++fxQL+1eSmBWVUW3fOniXFM='),(28,'8-945-345','Lionel','Arturo','Cordoba','Mendieta','M','1998-03-30','1782868640_147e36307f7a.webp','Panama, Panama','lionel.cordoba@utp.ac.pa','2456723','67890453','Sistemas','2025-02-11','Permanente','Programador Backend','Activo',1,'1782868640_Kroki!.pdf','Miu7m2sPuHxNtUbRXKgJ4fPhBH7jD5IwI/0hjaXO/Wg='),(29,'8-234-765','Sofia','Marie','Perez','Gomez','F','1998-02-11','1782868953_5e1a8eeb62d2.jpeg','Villa lucre','sofia.perez@gmail.com','2456743','65433255','Psicología','2024-07-30','Eventual','Psicólogo','Activo',1,'1782868953_Kroki!.pdf','mz7BSz1mszbkmb/hN5zDwoAXZq3aJHzP6SEd1asEF4Y='),(30,'8-234-321','Carla','Sofia','Gomez','Medina','F','2002-02-01','1782907460_e8f25e5f6325.jpeg','Panama, Panama','carla.gonzales@utp.ac.pa','2456745','65433333','Sistemas','2024-06-07','Eventual','Programador Frontend','Activo',1,'1782907460_Kroki!.pdf','6RJomD8iY+CAAeisJpwQlac3LZYUR45OGLaIv7qWppo='),(31,'8-123-654','sonia','maria','rodriguez','lopez','F','2003-02-02','1783026728_f932428a5626.webp','Panama, Panama','sonia.maria@utp.ac.ap','2456741','65433256','Sistemas','2026-03-12','Eventual','Programador','Activo',1,'1783026728_CASO 7.pdf','/tAiJoKDGuu/FwYqEzS5itsoCWBNuVb5fm3xGqP5jQY='),(32,'8-189-987','gael','Alberto','lopez','garcia','M','2002-06-04','1783820611_c5fc41c3dcee.jpeg','Panama, Panama','gael.lopez@gmail.com','2456749','65434564','Sistemas','2024-06-12','Permanente','Programador','Activo',1,'1783820611_enlace 2 (1).pdf','YmDeubH84T9Q4E93GgVJxk94Cw/WZKY0VXaDle8A1sM=');
/*!40000 ALTER TABLE `colaboradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_academico`
--

DROP TABLE IF EXISTS `historial_academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_academico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colaborador_id` int NOT NULL,
  `archivo_pdf` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `colaborador_id` (`colaborador_id`),
  CONSTRAINT `historial_academico_ibfk_1` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_academico`
--

LOCK TABLES `historial_academico` WRITE;
/*!40000 ALTER TABLE `historial_academico` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_academico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_logs`
--

DROP TABLE IF EXISTS `login_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `exitoso` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_logs`
--

LOCK TABLES `login_logs` WRITE;
/*!40000 ALTER TABLE `login_logs` DISABLE KEYS */;
INSERT INTO `login_logs` VALUES (11,'admin','::1','2026-06-29 08:22:53',1),(12,'admin','::1','2026-06-29 16:50:43',1),(13,'admin','::1','2026-06-30 21:21:11',1),(14,'admin','::1','2026-06-30 21:21:17',0),(15,'admin','::1','2026-06-30 21:21:22',0),(16,'admin','::1','2026-06-30 21:21:25',0),(17,'admin','::1','2026-07-01 06:46:37',1),(18,'Jeremias','::1','2026-07-01 07:16:36',1),(19,'admin','::1','2026-07-01 07:16:50',1),(20,'Jeremias','::1','2026-07-01 07:42:50',1),(21,'Juan1','::1','2026-07-01 07:43:05',1),(22,'Jeremias','::1','2026-07-01 07:43:31',1),(23,'admin','::1','2026-07-01 07:46:56',1),(24,'admin','::1','2026-07-02 15:51:31',1),(25,'admin','::1','2026-07-02 15:53:24',1),(26,'admin','::1','2026-07-02 15:54:17',1),(27,'colaborador','::1','2026-07-02 16:08:31',0),(28,'colaborador','::1','2026-07-02 16:08:42',0),(29,'admin','::1','2026-07-02 16:08:44',1),(30,'Jeremias','::1','2026-07-02 16:12:59',1),(31,'Jeremia','::1','2026-07-06 08:24:47',0),(32,'Jeremias','::1','2026-07-06 08:24:49',1),(33,'Jeremia','::1','2026-07-06 08:25:00',0),(34,'Jeremia','::1','2026-07-06 08:25:03',0),(35,'Jeremia','::1','2026-07-06 08:25:07',0),(36,'Jeremia','::1','2026-07-06 08:25:10',0),(37,'Jeremias','::1','2026-07-06 08:25:13',1),(38,'Jeremias','::1','2026-07-11 20:56:33',1),(39,'Jeremias','::1','2026-07-11 20:56:37',0),(40,'Jeremias','::1','2026-07-11 20:56:39',0),(41,'Jeremias','::1','2026-07-11 20:56:40',0),(42,'admin','::1','2026-07-11 20:56:45',1),(43,'admin','::1','2026-07-11 20:56:57',1),(44,'admin','::1','2026-07-11 21:05:29',1),(45,'admin','::1','2026-07-11 21:28:32',1);
/*!40000 ALTER TABLE `login_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planillas`
--

DROP TABLE IF EXISTS `planillas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planillas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colaborador_id` int NOT NULL,
  `mes` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `anio` int NOT NULL,
  `salario_base` int NOT NULL,
  `css_sipe` int NOT NULL,
  `seguro_educativo` int NOT NULL,
  `xiii_mes` int NOT NULL,
  `salario_neto` int NOT NULL,
  `integrity_signature` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `colaborador_id` (`colaborador_id`),
  CONSTRAINT `planillas_ibfk_1` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planillas`
--

LOCK TABLES `planillas` WRITE;
/*!40000 ALTER TABLE `planillas` DISABLE KEYS */;
INSERT INTO `planillas` VALUES (1,1,'Junio',2026,5000,488,63,417,4449,'uLQo1L+RG9PaYg4CndDQjnrhYrZm9t2JfLlUAB2zOrM=','2026-06-30 19:39:34'),(2,2,'Junio',2026,2000,195,25,167,1780,'Te8MHnt2MubQO8pkaokgVVyvUQrPRYhl2O1GwGJvfA4=','2026-06-30 20:04:54'),(3,29,'Junio',2026,2500,244,31,208,2225,'VQs5FjA2TtyRMrvvQ2aJnTkzA00wfiTKZLvLs7vd4BU=','2026-06-30 20:22:42'),(4,29,'Junio',2026,2500,244,31,208,2225,'LZMmbVY6ukBjZefJt7goO1CC6eXe4O19nHeZyJ9Bj38=','2026-07-01 07:16:22'),(5,1,'Junio',2026,5000,488,63,417,4449,'tFlJi6J9H5CRTuflKXKXLMprwq7Ib6WIQH1E3mLpH6Y=','2026-07-01 07:23:57'),(6,29,'Abril',2026,2500,244,31,208,2225,'eWrJXH8Ote/HDUrgCt0RozAHj+sEWraj3qjBYwjKOvg=','2026-07-01 07:24:06'),(7,30,'Junio',2026,3000,293,38,250,2669,'TWBKYK4MgMsU+9DCnCJ9B0WybIclz2uhwQmQBhZltls=','2026-07-01 07:53:05'),(8,30,'Junio',2026,3000,293,38,250,2669,'uYhDLCfoHZfQVDR93A4S3XUD/4lhxD8Z7hk+BC/P6ok=','2026-07-02 16:30:08'),(9,29,'Junio',2026,2500,244,31,208,2225,'lgQPoFchY7Z0ohbbEwDzs129OWPMHv8qat3C0VIMjM0=','2026-07-02 16:30:23');
/*!40000 ALTER TABLE `planillas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `nivel_acceso` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador Total','Control absoluto de los módulos',1),(2,'Recursos Humanos','Lectura y control de personal',2),(3,'Contraloría General',NULL,3);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol_id` int NOT NULL,
  `integrity_signature` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `bloqueado_hasta` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','$2y$12$TsbtV8s/B8.8KMhNMS8fze/OFtc895iR06DXKzWEFm4oYmtjau5YS',1,'BFzeo4g5c+QLyq9Y01ZF6R5kI+YIfkMu+Bzud84YolU=',1,NULL,'2026-06-28 17:15:05'),(2,'Jeremias','$2y$12$yIte4HEGurGSnLvmiV0wtO6bt1Deamnpr68S9fEBBGkXNbUOYbv3C',1,'qs9VbcmCJBT8KtTuL0P3JK69wlYVdmn7rADpRpA22Jc=',1,'2026-07-12 02:11:40','2026-06-29 17:04:02'),(3,'Juan','$2y$12$.RA8GYuDS2QT7/h2gWOuROVbQ9sZyMJu125N2O.O.1KpoEMoNvrRm',2,'gqPtJ6VEdNVNvxx/GDfsy+d6nnMPf66HlKc7LGfvG/I=',0,NULL,'2026-06-29 17:04:19'),(4,'Juan1','$2y$12$w0.dSR/n/bg5psfjpdL2HuAM1qIP9Fp8QgWk.yQ2tmzj5M2pe2axe',2,'hc8vekDFfad+t41ajyofTqwDAu/qH7/weZslDSMUc/Q=',1,NULL,'2026-06-30 19:07:54'),(5,'admin2','$2y$12$E0UsEpDDqsppmxvBzrTlmuOKVGpaMUkRS.31KEmnVoIi2ZsqhENLa',3,'uCUz8E7y72K9pwxjLQrpM3EaHgdjfBhRgPyn3E4SgHo=',1,NULL,'2026-06-30 21:05:00'),(6,'Jeremias1','$2y$12$f6X7arlBefB1dTyLYSCrpuwBgyqXJ4j5fBrVXOzK1rGjbhap9y/Ri',3,'fzbMmwAhAyzTsKG5Kgg4j5eNgrbJgkUepRD//37RuqU=',0,NULL,'2026-07-01 07:43:40');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacaciones`
--

DROP TABLE IF EXISTS `vacaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `colaborador_id` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `dias_disfrutados` int NOT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `integrity_signature` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `documento_resuelto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aprobado_por` int DEFAULT NULL,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Pendiente','Aprobada','Rechazada') COLLATE utf8mb4_general_ci DEFAULT 'Pendiente',
  PRIMARY KEY (`id`),
  KEY `colaborador_id` (`colaborador_id`),
  KEY `aprobado_por` (`aprobado_por`),
  CONSTRAINT `vacaciones_ibfk_1` FOREIGN KEY (`colaborador_id`) REFERENCES `colaboradores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vacaciones_ibfk_2` FOREIGN KEY (`aprobado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacaciones`
--

LOCK TABLES `vacaciones` WRITE;
/*!40000 ALTER TABLE `vacaciones` DISABLE KEYS */;
INSERT INTO `vacaciones` VALUES (1,1,'2026-08-01','2026-08-13',13,NULL,'X9ulY6Ps+LBlhCC7aA4bObKES5Jh7SHtHGHUl+GNEDc=',NULL,NULL,'2026-06-30 17:25:09','Aprobada'),(2,29,'2026-07-01','2026-07-11',11,'','5/20P7BP/6SvYtI+saGKypQGfpqSDwffSqyIBYcH7Ws=',NULL,NULL,'2026-06-30 20:48:13','Aprobada'),(3,29,'2026-10-15','2026-10-30',16,'','rxDe/kBjgzu8eOFeQ4ZfGeLqmJ5EI/z3TdAmI7K1VN8=',NULL,NULL,'2026-06-30 20:49:31','Aprobada'),(4,29,'2026-07-11','2026-07-22',8,'','HqB2ha6m21NrpA9L6mTkIWtGJqWpAuMWFX3S5KEa6/s=',NULL,NULL,'2026-07-11 20:40:18','Aprobada'),(5,1,'2026-07-18','2026-07-28',7,'','Pp0wvEMQ/aDxBFLhtfPLa5gGg6ZObdyvXm0m8GuwuJY=',NULL,NULL,'2026-07-11 20:44:03','Rechazada');
/*!40000 ALTER TABLE `vacaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'capital_humano'
--

--
-- Dumping routines for database 'capital_humano'
--
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-15 17:53:06
