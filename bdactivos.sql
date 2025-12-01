-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: bdactivos
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activos`
--

DROP TABLE IF EXISTS `activos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activos` (
  `id_activo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle` text COLLATE utf8mb4_unicode_ci,
  `estado_situacional` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactivo',
  `id_categoria` bigint unsigned NOT NULL,
  `id_unidad` bigint unsigned NOT NULL,
  `id_estado` bigint unsigned NOT NULL,
  `id_adquisicion` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_activo`),
  KEY `activos_id_categoria_foreign` (`id_categoria`),
  KEY `activos_id_unidad_foreign` (`id_unidad`),
  KEY `activos_id_estado_foreign` (`id_estado`),
  KEY `activos_id_adquisicion_foreign` (`id_adquisicion`),
  CONSTRAINT `activos_id_adquisicion_foreign` FOREIGN KEY (`id_adquisicion`) REFERENCES `adquisiciones` (`id_adquisicion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activos_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activos_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activos_id_unidad_foreign` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activos`
--

LOCK TABLES `activos` WRITE;
/*!40000 ALTER TABLE `activos` DISABLE KEYS */;
INSERT INTO `activos` VALUES (1,'AMD-EMG-001','Camilla plegable','Camilla color blanco, plegable','activo',1,1,2,1,'2025-01-03 04:00:00','2025-11-24 12:35:46'),(2,'AMD-EMG-002','Desfibrilador portátil','Equipo portátil para reanimación','baja',17,6,2,2,'2025-01-03 04:00:00','2025-11-24 12:35:00'),(3,'AMD-EMG-003','Silla de ruedas','Silla color azul para traslado','inactivo',1,1,2,3,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(4,'AMD-EMG-004','Monitor de signos vitales','Monitor portátil para pacientes críticos','inactivo',6,6,2,4,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(5,'AMD-EMG-005','Oxímetro portátil','Medidor de oxígeno en sangre, compacto','inactivo',6,2,2,5,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(6,'AMD-EMG-006','Ambu manual','Bolsa de resucitación manual pequeña','inactivo',17,6,2,6,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(7,'AMD-EMG-007','Maletín de trauma','Equipo portátil con vendajes y férulas','inactivo',17,6,2,7,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(8,'AMD-EMG-008','Mascarilla de oxígeno','Mascarilla transparente con tubo','inactivo',8,2,2,8,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(9,'AMD-EMG-009','Respirador manual','Dispositivo portátil para asistencia respiratoria','activo',17,6,2,9,'2025-01-03 04:00:00','2025-11-24 04:46:31'),(10,'AMD-EMG-010','Botiquín de primeros auxilios','Botiquín con material básico','inactivo',8,2,2,10,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(11,'AMD-EMG-011','Desfibrilador portátil','Equipo de desfibrilación para emergencias','inactivo',6,6,1,11,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(12,'AMD-EMG-012','Monitor multiparámetro','Monitor de signos vitales para emergencias','inactivo',6,6,1,12,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(13,'AMD-EMG-013','Bolsa de aspiración manual','Equipo para aspiración de secreciones','inactivo',17,2,2,13,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(14,'AMD-EMG-014','Tabla espinal rígida','Tabla para traslado de pacientes traumáticos','inactivo',17,1,2,14,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(15,'AMD-EMG-015','Collar cervical ajustable','Collar ortopédico para inmovilización','inactivo',17,2,1,15,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(16,'AMD-EMG-016','Camilla de transporte plegable','Camilla liviana para emergencias','inactivo',1,1,1,16,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(17,'AMD-EMG-017','Botiquín de emergencias','Botiquín equipado para primeros auxilios','inactivo',8,3,2,17,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(18,'AMD-EMG-018','Radio comunicador portátil','Radio de comunicación para emergencias','inactivo',15,1,1,18,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(19,'AMD-EMG-019','Maletín de vía aérea','Set de equipos para manejo avanzado de vía aérea','inactivo',17,5,1,19,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(20,'AMD-EMG-020','Silla de ruedas plegable','Silla de transporte para pacientes','inactivo',1,1,2,20,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(21,'AMD-EMG-021','Equipo de oxigenoterapia portátil','Cilindro portátil con regulador','inactivo',6,6,1,21,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(22,'AMD-EMG-022','Tensiómetro digital profesional','Monitor de presión arterial','inactivo',6,2,1,22,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(23,'AMD-EMG-023','Estetoscopio clínico','Estetoscopio de alta sensibilidad','inactivo',17,2,2,23,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(24,'AMD-EMG-024','Maletín de trauma','Kit para manejo de traumatismos','inactivo',17,5,1,24,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(25,'AMD-EMG-025','Linterna táctica médica','Linterna de bolsillo para emergencias','activo',6,2,2,25,'2025-01-03 04:00:00','2025-11-24 04:45:37'),(26,'AMD-EMG-026','Electrocardiógrafo portátil','Equipo portátil para ECG','activo',6,6,1,26,'2025-01-03 04:00:00','2025-11-24 04:45:37'),(27,'AMD-EMG-027','Tirantes de inmovilización','Cintas para asegurar pacientes a camillas o tablas','activo',17,5,2,27,'2025-01-03 04:00:00','2025-11-24 04:45:37'),(28,'AMD-EMG-028','Termómetro infrarrojo','Termómetro sin contacto','activo',6,2,1,28,'2025-01-03 04:00:00','2025-11-24 04:45:37'),(29,'AMD-EMG-029','Inmovilizador de cabeza','Inmovilizador rígido para emergencias','activo',17,1,1,29,'2025-01-03 04:00:00','2025-11-24 04:45:37'),(30,'AMD-EMG-030','Manta térmica de emergencia','Manta aluminizada para shock térmico','inactivo',8,2,2,30,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(31,'AMD-EMG-031','Talonera inmovilizadora','Inmovilizador para extremidades inferiores','inactivo',17,2,2,31,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(32,'AMD-EMG-032','Kit de inmovilización pediátrico','Set de inmovilización para pacientes pediátricos','activo',17,5,1,32,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(33,'AMD-EMG-033','Bomba de aspiración portátil','Equipo para succión en emergencias','activo',6,6,2,33,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(34,'AMD-EMG-034','Cánula orofaríngea','Dispositivo para mantener vía aérea permeable','activo',17,2,1,34,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(35,'AMD-EMG-035','Nebulizador portátil','Equipo para nebulización en emergencias','activo',6,6,2,35,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(36,'AMD-EMG-036','Bolsa para hipotermia','Bolsa especial para tratamiento de hipotermia','activo',8,2,1,36,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(37,'AMD-EMG-037','Sonda de aspiración','Sonda médica para succión de secreciones','activo',17,2,2,37,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(38,'AMD-EMG-038','Mochila médica de respuesta rápida','Mochila equipada para atención en campo','activo',17,5,1,38,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(39,'AMD-EMG-039','Laringoscopio con luz LED','Equipo para intubación endotraqueal','activo',6,6,2,39,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(40,'AMD-EMG-040','Kit de curaciones avanzado','Set completo para manejo de heridas','activo',8,5,1,40,'2025-01-03 04:00:00','2025-11-24 04:44:30'),(41,'AMD-EMG-041','silla','color cage','inactivo',1,2,3,41,'2025-11-24 13:06:06','2025-11-24 13:06:06');
/*!40000 ALTER TABLE `activos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adquisiciones`
--

DROP TABLE IF EXISTS `adquisiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adquisiciones` (
  `id_adquisicion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tipo` enum('COMPRA','DONACION','OTRO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentarios` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_adquisicion`),
  KEY `adquisiciones_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `adquisiciones_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adquisiciones`
--

LOCK TABLES `adquisiciones` WRITE;
/*!40000 ALTER TABLE `adquisiciones` DISABLE KEYS */;
INSERT INTO `adquisiciones` VALUES (1,'2025-01-03','COMPRA','Camilla plegable para emergencias',1,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(2,'2025-01-03','COMPRA','Desfibrilador portátil adquirido',1,'2025-01-03 04:01:00','2025-01-03 04:01:00'),(3,'2025-01-03','COMPRA','',1,'2025-01-03 04:02:00','2025-01-03 04:02:00'),(4,'2025-01-03','DONACION','',1,'2025-01-03 04:03:00','2025-01-03 04:03:00'),(5,'2025-01-03','DONACION','',1,'2025-01-03 04:04:00','2025-01-03 04:04:00'),(6,'2025-01-03','DONACION','',1,'2025-01-03 04:05:00','2025-01-03 04:05:00'),(7,'2025-01-03','OTRO','',1,'2025-01-03 04:06:00','2025-01-03 04:06:00'),(8,'2025-01-03','OTRO','',1,'2025-01-03 04:07:00','2025-01-03 04:07:00'),(9,'2025-01-03','OTRO','',1,'2025-01-03 04:08:00','2025-01-03 04:08:00'),(10,'2025-01-03','OTRO','',1,'2025-01-03 04:09:00','2025-01-03 04:09:00'),(11,'2025-01-03','OTRO','',1,'2025-01-03 04:10:00','2025-01-03 04:10:00'),(12,'2025-01-03','OTRO','',1,'2025-01-03 04:11:00','2025-01-03 04:11:00'),(13,'2025-01-03','OTRO','',1,'2025-01-03 04:12:00','2025-01-03 04:12:00'),(14,'2025-01-03','OTRO','',1,'2025-01-03 04:13:00','2025-01-03 04:13:00'),(15,'2025-01-03','OTRO','',1,'2025-01-03 04:14:00','2025-01-03 04:14:00'),(16,'2025-01-03','OTRO','',1,'2025-01-03 04:15:00','2025-01-03 04:15:00'),(17,'2025-01-03','OTRO','',1,'2025-01-03 04:16:00','2025-01-03 04:16:00'),(18,'2025-01-03','OTRO','',1,'2025-01-03 04:17:00','2025-01-03 04:17:00'),(19,'2025-01-03','OTRO','',1,'2025-01-03 04:18:00','2025-01-03 04:18:00'),(20,'2025-01-03','OTRO','',1,'2025-01-03 04:19:00','2025-01-03 04:19:00'),(21,'2025-01-03','OTRO','',1,'2025-01-03 04:20:00','2025-01-03 04:20:00'),(22,'2025-01-03','OTRO','',1,'2025-01-03 04:21:00','2025-01-03 04:21:00'),(23,'2025-01-03','OTRO','',1,'2025-01-03 04:22:00','2025-01-03 04:22:00'),(24,'2025-01-03','OTRO','',1,'2025-01-03 04:23:00','2025-01-03 04:23:00'),(25,'2025-01-03','OTRO','',1,'2025-01-03 04:24:00','2025-01-03 04:24:00'),(26,'2025-01-03','OTRO','',1,'2025-01-03 04:25:00','2025-01-03 04:25:00'),(27,'2025-01-03','OTRO','',1,'2025-01-03 04:26:00','2025-01-03 04:26:00'),(28,'2025-01-03','OTRO','',1,'2025-01-03 04:27:00','2025-01-03 04:27:00'),(29,'2025-01-03','OTRO','',1,'2025-01-03 04:28:00','2025-01-03 04:28:00'),(30,'2025-01-03','OTRO','',1,'2025-01-03 04:29:00','2025-01-03 04:29:00'),(31,'2025-01-03','OTRO','',1,'2025-01-03 04:30:00','2025-01-03 04:30:00'),(32,'2025-01-03','OTRO','',1,'2025-01-03 04:31:00','2025-01-03 04:31:00'),(33,'2025-01-03','OTRO','',1,'2025-01-03 04:32:00','2025-01-03 04:32:00'),(34,'2025-01-03','OTRO','',1,'2025-01-03 04:33:00','2025-01-03 04:33:00'),(35,'2025-01-03','OTRO','',1,'2025-01-03 04:34:00','2025-01-03 04:34:00'),(36,'2025-01-03','OTRO','',1,'2025-01-03 04:35:00','2025-01-03 04:35:00'),(37,'2025-01-03','OTRO','',1,'2025-01-03 04:36:00','2025-01-03 04:36:00'),(38,'2025-01-03','OTRO','',1,'2025-01-03 04:37:00','2025-01-03 04:37:00'),(39,'2025-01-03','OTRO','',1,'2025-01-03 04:38:00','2025-01-03 04:38:00'),(40,'2025-01-03','OTRO','',1,'2025-01-03 04:39:00','2025-01-03 04:39:00'),(41,'2025-11-24','DONACION',NULL,1,'2025-11-24 13:06:06','2025-11-24 13:06:06');
/*!40000 ALTER TABLE `adquisiciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bajas`
--

DROP TABLE IF EXISTS `bajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bajas` (
  `id_baja` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_activo` bigint unsigned NOT NULL,
  `id_servicio` bigint unsigned NOT NULL,
  `id_responsable` bigint unsigned NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `fecha` date NOT NULL,
  `motivo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_baja`),
  KEY `bajas_id_activo_foreign` (`id_activo`),
  KEY `bajas_id_servicio_foreign` (`id_servicio`),
  KEY `bajas_id_responsable_foreign` (`id_responsable`),
  KEY `bajas_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `bajas_id_activo_foreign` FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`) ON DELETE CASCADE,
  CONSTRAINT `bajas_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `bajas_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `bajas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bajas`
--

LOCK TABLES `bajas` WRITE;
/*!40000 ALTER TABLE `bajas` DISABLE KEYS */;
INSERT INTO `bajas` VALUES (1,2,12,12,1,'2025-11-24','obsolencia',NULL,'2025-11-24 12:35:00','2025-11-24 12:35:00');
/*!40000 ALTER TABLE `bajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargos` (
  `id_cargo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cargo`),
  UNIQUE KEY `cargos_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` VALUES (1,'Médico','Dr.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(2,'Médica','Dra.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(3,'Cirujano','Ciru.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(4,'Cirujana','Cira.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(5,'Anestesiólogo','Anes.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(6,'Anestesióloga','Anes.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(7,'Enfermero','Enf.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(8,'Enfermera','Enf.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(9,'Licenciado en Enfermería','Lic.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(10,'Licenciada en Enfermería','Lic.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(11,'Ginecólogo','Gine.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(12,'Ginecóloga','Gine.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(13,'Pediatra','Ped.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(14,'Internista','Int.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(15,'Emergenciólogo','Emerg.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(16,'Emergencióloga','Emerg.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(17,'Radiólogo','Rad.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(18,'Radióloga','Rad.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(19,'Odontólogo','Odont.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(20,'Odontóloga','Odont.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(21,'Tecnólogo Médico','Tec.Med.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(22,'Tecnóloga Médica','Tec.Med.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(23,'Auxiliar de Enfermería','Aux.Enf.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(24,'Auxiliar de Laboratorio','Aux.Lab.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(25,'Técnico en Laboratorio','Tec.Lab.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(26,'Técnica en Laboratorio','Tec.Lab.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(27,'Técnico en Radiología','Tec.Rad.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(28,'Técnica en Radiología','Tec.Rad.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(29,'Técnico en Farmacia','Tec.Farm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(30,'Técnica en Farmacia','Tec.Farm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(31,'licenciado','Lic.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(32,'licenciada','Lic.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(33,'Administrador','Adm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(34,'Administradora','Adm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(35,'Secretario','Sec.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(36,'Secretaria','Sec.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(37,'Contador','Cont.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(38,'Contadora','Cont.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(39,'Auxiliar Administrativo','Aux.Adm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(40,'Auxiliar Administrativa','Aux.Adm.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(41,'Portero','Port.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(42,'Portera','Port.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(43,'Conserje','Cons.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(44,'Operario de Limpieza','Limp.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(45,'Operaria de Limpieza','Limp.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(46,'Chofer','Chof.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(47,'Cocinero','Coc.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(48,'Cocinera','Coc.','2025-01-01 04:00:00','2025-01-01 04:00:00');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id_categoria` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Mobiliario','Muebles del hospital',NULL,NULL),(2,'Equipamiento Médico','Equipos médicos',NULL,NULL),(3,'Informática','Computadoras, impresoras, etc.',NULL,NULL),(4,'Instrumental Quirúrgico','Instrumentos usados en cirugías',NULL,NULL),(5,'Equipos de Laboratorio','Equipos para análisis clínicos y laboratorio',NULL,NULL),(6,'Electromedicina','Equipos electrónicos de uso médico',NULL,NULL),(7,'Vehículos','Ambulancias y vehículos institucionales',NULL,NULL),(8,'Insumos Permanentes','Insumos reutilizables de larga duración',NULL,NULL),(9,'Mobiliario de Oficina','Escritorios, sillas, estantes, archivadores',NULL,NULL),(10,'Audio y Video','Parlantes, televisores, proyectores',NULL,NULL),(11,'Herramientas','Herramientas de mantenimiento y reparación',NULL,NULL),(12,'Refrigeración','Heladeras, congeladores, frigobares',NULL,NULL),(13,'Calefacción y Climatización','Aires acondicionados, calefactores',NULL,NULL),(14,'Luminarias','Lámparas, focos, luminarias especiales',NULL,NULL),(15,'Telecomunicaciones','Radios, teléfonos, routers',NULL,NULL),(16,'Equipamiento Odontológico','Equipos para odontología',NULL,NULL),(17,'Equipamiento de Emergencias','Equipos para emergencias y urgencias',NULL,NULL),(18,'Equipamiento de Cocina','Cocinas, hornos, microondas',NULL,NULL),(19,'Lavandería','Lavadoras, secadoras, planchadoras',NULL,NULL),(20,'Limpieza y Sanitización','Equipos de limpieza industrial',NULL,NULL),(21,'Seguridad Industrial','Equipos de seguridad y protección',NULL,NULL),(22,'Didácticos','Material didáctico o de capacitación',NULL,NULL),(23,'Construcción y Mantenimiento','Equipos para obras y mantenimiento',NULL,NULL),(24,'Energía y Potencia','Generadores, UPS, estabilizadores',NULL,NULL),(25,'Sistemas Biomédicos','Equipos avanzados biomédicos',NULL,NULL),(26,'Decoración','Cuadros, cortinas, adornos',NULL,NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `id_adquisicion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_proveedor` bigint unsigned NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_adquisicion`),
  KEY `compras_id_proveedor_foreign` (`id_proveedor`),
  CONSTRAINT `compras_id_proveedor_foreign` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
INSERT INTO `compras` VALUES (1,1,1200.00,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(2,2,1800.00,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(3,1,1000.00,'2025-01-03 04:00:00','2025-01-03 04:00:00');
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_devoluciones`
--

DROP TABLE IF EXISTS `detalle_devoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_devoluciones` (
  `id_detalle_devolucion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_devolucion` bigint unsigned NOT NULL,
  `id_activo` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_devolucion`),
  KEY `detalle_devoluciones_id_devolucion_foreign` (`id_devolucion`),
  KEY `detalle_devoluciones_id_activo_foreign` (`id_activo`),
  CONSTRAINT `detalle_devoluciones_id_activo_foreign` FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`) ON DELETE CASCADE,
  CONSTRAINT `detalle_devoluciones_id_devolucion_foreign` FOREIGN KEY (`id_devolucion`) REFERENCES `devoluciones` (`id_devolucion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_devoluciones`
--

LOCK TABLES `detalle_devoluciones` WRITE;
/*!40000 ALTER TABLE `detalle_devoluciones` DISABLE KEYS */;
INSERT INTO `detalle_devoluciones` VALUES (1,10,25,'','2025-11-24 04:47:03','2025-11-24 04:47:03');
/*!40000 ALTER TABLE `detalle_devoluciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_entregas`
--

DROP TABLE IF EXISTS `detalle_entregas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_entregas` (
  `id_detalle_entrega` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_entrega` bigint unsigned NOT NULL,
  `id_activo` bigint unsigned NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_entrega`),
  KEY `detalle_entregas_id_entrega_foreign` (`id_entrega`),
  KEY `detalle_entregas_id_activo_foreign` (`id_activo`),
  CONSTRAINT `detalle_entregas_id_activo_foreign` FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`) ON DELETE CASCADE,
  CONSTRAINT `detalle_entregas_id_entrega_foreign` FOREIGN KEY (`id_entrega`) REFERENCES `entregas` (`id_entrega`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_entregas`
--

LOCK TABLES `detalle_entregas` WRITE;
/*!40000 ALTER TABLE `detalle_entregas` DISABLE KEYS */;
INSERT INTO `detalle_entregas` VALUES (1,10,40,'','2025-11-24 04:44:11','2025-11-24 04:44:11'),(2,10,38,'','2025-11-24 04:44:12','2025-11-24 04:44:12'),(3,10,37,'','2025-11-24 04:44:13','2025-11-24 04:44:13'),(4,10,36,'','2025-11-24 04:44:15','2025-11-24 04:44:15'),(5,10,39,'','2025-11-24 04:44:16','2025-11-24 04:44:16'),(6,10,34,'','2025-11-24 04:44:18','2025-11-24 04:44:18'),(7,10,33,'','2025-11-24 04:44:18','2025-11-24 04:44:18'),(8,10,35,'','2025-11-24 04:44:20','2025-11-24 04:44:20'),(9,10,32,'','2025-11-24 04:44:21','2025-11-24 04:44:21'),(10,1,29,'','2025-11-24 04:45:27','2025-11-24 04:45:27'),(11,1,28,'','2025-11-24 04:45:28','2025-11-24 04:45:28'),(12,1,27,'','2025-11-24 04:45:29','2025-11-24 04:45:29'),(13,1,26,'','2025-11-24 04:45:30','2025-11-24 04:45:30'),(14,1,25,'','2025-11-24 04:45:31','2025-11-24 04:45:31'),(15,2,9,'','2025-11-24 04:46:25','2025-11-24 04:46:25'),(16,11,1,'','2025-11-24 12:30:58','2025-11-24 12:30:58'),(17,11,2,'','2025-11-24 12:30:59','2025-11-24 12:30:59'),(18,3,12,'','2025-11-24 13:13:28','2025-11-24 13:13:28'),(19,3,10,'','2025-11-24 13:13:31','2025-11-24 13:13:31');
/*!40000 ALTER TABLE `detalle_entregas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_inventarios`
--

DROP TABLE IF EXISTS `detalle_inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_inventarios` (
  `id_detalle_inventario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_inventario` bigint unsigned NOT NULL,
  `id_activo` bigint unsigned NOT NULL,
  `estado_actual` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_inventario`),
  KEY `detalle_inventarios_id_inventario_foreign` (`id_inventario`),
  KEY `detalle_inventarios_id_activo_foreign` (`id_activo`),
  CONSTRAINT `detalle_inventarios_id_activo_foreign` FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`) ON DELETE CASCADE,
  CONSTRAINT `detalle_inventarios_id_inventario_foreign` FOREIGN KEY (`id_inventario`) REFERENCES `inventarios` (`id_inventario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_inventarios`
--

LOCK TABLES `detalle_inventarios` WRITE;
/*!40000 ALTER TABLE `detalle_inventarios` DISABLE KEYS */;
INSERT INTO `detalle_inventarios` VALUES (1,3,40,'NUEVO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(2,3,38,'NUEVO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(3,3,37,'BUENO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(4,3,36,'NUEVO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(5,3,39,'BUENO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(6,3,34,'NUEVO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(7,3,33,'BUENO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(8,3,35,'BUENO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(9,3,32,'NUEVO','','2025-11-24 04:44:30','2025-11-24 04:44:30'),(11,2,28,'NUEVO','','2025-11-24 04:45:37','2025-11-24 04:45:37'),(12,2,27,'BUENO','','2025-11-24 04:45:37','2025-11-24 04:45:37'),(13,2,26,'NUEVO','','2025-11-24 04:45:37','2025-11-24 04:45:37'),(14,2,25,'BUENO','','2025-11-24 04:45:37','2025-11-24 04:45:37'),(15,13,9,'BUENO','','2025-11-24 04:46:31','2025-11-24 04:46:31'),(16,5,29,'NUEVO','','2025-11-24 04:50:42','2025-11-24 04:50:42'),(17,12,1,'BUENO','','2025-11-24 12:31:55','2025-11-24 12:31:55'),(18,12,2,'BUENO','','2025-11-24 12:31:55','2025-11-24 12:31:55'),(19,21,1,'BUENO','','2025-11-24 12:33:29','2025-11-24 12:33:29');
/*!40000 ALTER TABLE `detalle_inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_traslados`
--

DROP TABLE IF EXISTS `detalle_traslados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_traslados` (
  `id_detalle_traslado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_traslado` bigint unsigned NOT NULL,
  `id_activo` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_traslado`),
  KEY `detalle_traslados_id_traslado_foreign` (`id_traslado`),
  KEY `detalle_traslados_id_activo_foreign` (`id_activo`),
  CONSTRAINT `detalle_traslados_id_activo_foreign` FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`) ON DELETE CASCADE,
  CONSTRAINT `detalle_traslados_id_traslado_foreign` FOREIGN KEY (`id_traslado`) REFERENCES `traslados` (`id_traslado`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_traslados`
--

LOCK TABLES `detalle_traslados` WRITE;
/*!40000 ALTER TABLE `detalle_traslados` DISABLE KEYS */;
INSERT INTO `detalle_traslados` VALUES (1,1,29,'','2025-11-24 04:50:33','2025-11-24 04:50:33');
/*!40000 ALTER TABLE `detalle_traslados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devoluciones` (
  `id_devolucion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_responsable` bigint unsigned NOT NULL,
  `id_servicio` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_devolucion`),
  KEY `devoluciones_id_usuario_foreign` (`id_usuario`),
  KEY `devoluciones_id_responsable_foreign` (`id_responsable`),
  KEY `devoluciones_id_servicio_foreign` (`id_servicio`),
  CONSTRAINT `devoluciones_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `devoluciones_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `devoluciones_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devoluciones`
--

LOCK TABLES `devoluciones` WRITE;
/*!40000 ALTER TABLE `devoluciones` DISABLE KEYS */;
INSERT INTO `devoluciones` VALUES (1,'001',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:01:00','2025-02-04 04:01:00'),(2,'002',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:02:00','2025-02-04 04:02:00'),(3,'003',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:03:00','2025-02-04 04:03:00'),(4,'004',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:04:00','2025-02-04 04:04:00'),(5,'005',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:05:00','2025-02-04 04:05:00'),(6,'006',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:06:00','2025-02-04 04:06:00'),(7,'007',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:07:00','2025-02-04 04:07:00'),(8,'008',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:08:00','2025-02-04 04:08:00'),(9,'009',2025,'2025-02-04',1,6,6,'','pendiente',NULL,'2025-02-04 04:09:00','2025-02-04 04:09:00'),(10,'010',2025,'2025-02-04',1,6,2,'','pendiente',NULL,'2025-02-04 04:10:00','2025-11-24 04:46:55');
/*!40000 ALTER TABLE `devoluciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donaciones`
--

DROP TABLE IF EXISTS `donaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donaciones` (
  `id_adquisicion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_donante` bigint unsigned NOT NULL,
  `motivo` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_adquisicion`),
  KEY `donaciones_id_donante_foreign` (`id_donante`),
  CONSTRAINT `donaciones_id_donante_foreign` FOREIGN KEY (`id_donante`) REFERENCES `donantes` (`id_donante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donaciones`
--

LOCK TABLES `donaciones` WRITE;
/*!40000 ALTER TABLE `donaciones` DISABLE KEYS */;
INSERT INTO `donaciones` VALUES (4,2,'Donación benéfica',300.00,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(5,1,'Donación benéfica',200.00,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(6,1,'Donación benéfica',900.00,'2025-01-03 04:00:00','2025-01-03 04:00:00'),(41,1,'necesidad',0.00,'2025-11-24 13:06:06','2025-11-24 13:06:06');
/*!40000 ALTER TABLE `donaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donantes`
--

DROP TABLE IF EXISTS `donantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donantes` (
  `id_donante` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_donante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donantes`
--

LOCK TABLES `donantes` WRITE;
/*!40000 ALTER TABLE `donantes` DISABLE KEYS */;
INSERT INTO `donantes` VALUES (1,'Fundación Esperanza','ONG','esperanza@fundacion.org',NULL,NULL),(2,'Juan Pérez','Persona natural','juan.perez@gmail.com',NULL,NULL),(3,'Empresa Salud S.A.','Empresa','contacto@saludsa.com',NULL,NULL);
/*!40000 ALTER TABLE `donantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entregas`
--

DROP TABLE IF EXISTS `entregas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entregas` (
  `id_entrega` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_responsable` bigint unsigned NOT NULL,
  `id_servicio` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_entrega`),
  KEY `entregas_id_usuario_foreign` (`id_usuario`),
  KEY `entregas_id_responsable_foreign` (`id_responsable`),
  KEY `entregas_id_servicio_foreign` (`id_servicio`),
  CONSTRAINT `entregas_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `entregas_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `entregas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entregas`
--

LOCK TABLES `entregas` WRITE;
/*!40000 ALTER TABLE `entregas` DISABLE KEYS */;
INSERT INTO `entregas` VALUES (1,'001',2025,'2025-02-01',1,2,2,'','finalizado',NULL,'2025-02-01 12:00:00','2025-11-24 04:45:37'),(2,'002',2025,'2025-02-02',1,13,13,'','finalizado',NULL,'2025-02-02 12:00:00','2025-11-24 04:46:31'),(3,'003',2025,'2025-02-03',1,3,3,NULL,'pendiente',NULL,'2025-02-03 12:00:00','2025-02-03 12:00:00'),(4,'004',2025,'2025-02-04',1,3,3,NULL,'pendiente',NULL,'2025-02-04 12:00:00','2025-02-04 12:00:00'),(5,'005',2025,'2025-02-05',1,3,3,NULL,'pendiente',NULL,'2025-02-05 12:00:00','2025-02-05 12:00:00'),(6,'006',2025,'2025-02-06',1,3,3,NULL,'pendiente',NULL,'2025-02-06 12:00:00','2025-02-06 12:00:00'),(7,'007',2025,'2025-02-07',1,3,3,NULL,'pendiente',NULL,'2025-02-07 12:00:00','2025-02-07 12:00:00'),(8,'008',2025,'2025-02-08',1,3,3,NULL,'pendiente',NULL,'2025-02-08 12:00:00','2025-02-08 12:00:00'),(9,'009',2025,'2025-02-09',1,3,3,NULL,'pendiente',NULL,'2025-02-09 12:00:00','2025-02-09 12:00:00'),(10,'010',2025,'2025-02-10',1,3,3,NULL,'finalizado',NULL,'2025-02-10 12:00:00','2025-11-24 04:44:30'),(11,'011',2025,'2025-09-16',1,12,12,NULL,'finalizado',NULL,'2025-11-24 12:30:33','2025-11-24 12:31:55');
/*!40000 ALTER TABLE `entregas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `id_estado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'NUEVO','En perfecto estado, sin uso','2025-01-01 04:00:00','2025-01-01 04:00:00'),(2,'BUENO','Funciona correctamente, con poco uso','2025-01-01 04:00:00','2025-01-01 04:00:00'),(3,'REGULAR','Con uso moderado, algunas señales de desgaste','2025-01-01 04:00:00','2025-01-01 04:00:00'),(4,'MALO','Dañado, con fallas, requiere reparación','2025-01-01 04:00:00','2025-01-01 04:00:00'),(5,'OBSOLETO','No se recomienda uso, tecnología antigua','2025-01-01 04:00:00','2025-01-01 04:00:00'),(6,'FUERA DE SERVICIO','No operativo, en espera de baja o reparación','2025-01-01 04:00:00','2025-01-01 04:00:00');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventarios`
--

DROP TABLE IF EXISTS `inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventarios` (
  `id_inventario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_responsable` bigint unsigned NOT NULL,
  `id_servicio` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_inventario`),
  UNIQUE KEY `inventarios_numero_documento_unique` (`numero_documento`),
  KEY `inventarios_id_usuario_foreign` (`id_usuario`),
  KEY `inventarios_id_responsable_foreign` (`id_responsable`),
  KEY `inventarios_id_servicio_foreign` (`id_servicio`),
  CONSTRAINT `inventarios_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `inventarios_id_servicio_foreign` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `inventarios_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventarios`
--

LOCK TABLES `inventarios` WRITE;
/*!40000 ALTER TABLE `inventarios` DISABLE KEYS */;
INSERT INTO `inventarios` VALUES (1,'001',2025,'2025-01-01',1,1,1,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(2,'002',2025,'2025-01-01',1,2,2,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(3,'003',2025,'2025-01-01',1,3,3,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(4,'004',2025,'2025-01-01',1,4,4,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(5,'005',2025,'2025-01-01',1,5,5,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(6,'006',2025,'2025-01-01',1,6,6,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(7,'007',2025,'2025-01-01',1,7,7,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(8,'008',2025,'2025-01-01',1,8,8,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(9,'009',2025,'2025-01-01',1,9,9,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(10,'010',2025,'2025-01-01',1,10,10,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(11,'011',2025,'2025-01-01',1,11,11,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(12,'012',2025,'2025-01-01',1,12,12,'Inventario inicial generado automáticamente','finalizado','','2025-01-01 04:00:00','2025-11-24 12:35:46'),(13,'013',2025,'2025-01-01',1,13,13,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(14,'014',2025,'2025-01-01',1,14,14,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(15,'015',2025,'2025-01-01',1,15,15,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(16,'016',2025,'2025-01-01',1,16,16,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(17,'017',2025,'2025-01-01',1,17,17,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(18,'018',2025,'2025-01-01',1,18,18,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(19,'019',2025,'2025-01-01',1,19,19,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(20,'020',2025,'2025-01-01',1,20,20,'Inventario inicial generado automáticamente','vigente','','2025-01-01 04:00:00','2025-01-01 04:00:00'),(21,'021',2025,'2025-11-24',1,12,12,'Generado automáticamente','vigente',NULL,'2025-11-24 12:33:10','2025-11-24 12:35:46'),(22,'022',2025,'2025-11-24',1,10,22,'Inventario inicial','vigente',NULL,'2025-11-24 14:30:30','2025-11-24 14:30:30'),(23,'023',2025,'2025-11-24',1,12,12,'Generado automáticamente','pendiente',NULL,'2025-11-24 14:46:59','2025-11-24 14:46:59');
/*!40000 ALTER TABLE `inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_07_23_193609_create_categorias_table',1),(6,'2025_07_23_193610_create_cargos_table',1),(7,'2025_07_23_193611_create_estados_table',1),(8,'2025_07_23_193612_create_unidades_table',1),(9,'2025_07_23_193613_create_responsables_table',1),(10,'2025_07_23_193614_create_usuarios_table',1),(11,'2025_07_23_193615_create_servicios_table',1),(12,'2025_07_23_193618_create_donantes_table',1),(13,'2025_07_23_193619_create_donaciones_table',1),(14,'2025_07_23_193620_create_proveedores_table',1),(15,'2025_07_23_193621_create_compras_table',1),(16,'2025_07_23_193839_create_inventarios_table',1),(17,'2025_09_16_194323_create_adquisiciones_table',1),(18,'2025_09_16_194326_create_activos_table',1),(19,'2025_09_16_194342_create_bajas_table',1),(20,'2025_09_16_194343_create_devoluciones_table',1),(21,'2025_09_16_194343_create_entregas_table',1),(22,'2025_09_16_194343_create_traslados_table',1),(23,'2025_09_16_194344_create_detalle_bajas_table',1),(24,'2025_09_16_194344_create_detalle_devoluciones_table',1),(25,'2025_09_16_194344_create_detalle_entregas_table',1),(26,'2025_09_16_194344_create_detalle_traslados_table',1),(27,'2025_09_16_194345_create_detalle_inventarios_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id_proveedor` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'Meditek S.R.L.','ORURO','meditek@proveedores.com','2025-11-24 04:17:19','2025-11-24 04:17:19'),(2,'Hospital Solutions','SANTA CRUZ','ventas@hosol.com','2025-11-24 04:17:19','2025-11-24 04:17:19');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsables` (
  `id_responsable` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cargo` bigint unsigned NOT NULL,
  `rol` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'personal operativo',
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_responsable`),
  UNIQUE KEY `responsables_ci_unique` (`ci`),
  KEY `responsables_id_cargo_foreign` (`id_cargo`),
  CONSTRAINT `responsables_id_cargo_foreign` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsables`
--

LOCK TABLES `responsables` WRITE;
/*!40000 ALTER TABLE `responsables` DISABLE KEYS */;
INSERT INTO `responsables` VALUES (1,'Divar Gutiérrez','7435345678','73718313',1,'personal operativo','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(2,'María Gómez','87654321','74392142',2,'personal operativo','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(3,'Juan Pérez','78451234','76789012',3,'coordinador de pediatría','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(4,'Lucía Flores','15893241','76123478',24,'responsable de laboratorio','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(5,'Carlos Mamani','17384920','76711234',26,'coordinador de radiología','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(6,'Ana Vargas','14725836','76156789',28,'responsable de farmacia','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(7,'Miguel Salazar','16273849','76812345',15,'coordinador de emergencias','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(8,'Sofía Rojas','18374625','76123489',8,'jefa de enfermería','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(9,'Julio Cesar Rivero Pacheco','00000002','70000002',3,'Administrador','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(10,'Elena Mamani','17654321','76134567',23,'auxiliar de enfermería','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(11,'Fernando Quispe','19827364','76789034',33,'administrativo','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(12,'María López','13934123','72123456',9,'responsable de nutrición','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(13,'Lucía Paredes','12837465','76123789',16,'responsable de fisioterapia','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(14,'Paola Rivas','19837465','76123890',17,'responsable de psicología','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(15,'Juan Torres','14736258','76123901',18,'responsable de servicios generales','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(16,'Marcela Vega','17283940','76123412',19,'responsable de nutrición clínica','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(17,'Luis Gutiérrez','19837491','76123423',20,'responsable de docencia','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(18,'Francisca Mamani','12345678','76123456',21,'coordinadora de cirugía','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(19,'Patricia Flores','23456789','76123457',22,'coordinadora de urología','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(20,'Oscar Pérez','34567890','76123458',23,'coordinador cardiología','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(21,'Franz Gutiérrez Choque','00000001','70000001',1,'Director','activo','2025-11-24 04:17:16','2025-11-24 04:17:16'),(22,'JUAN 123','11823132342342143214321434','742343214321',46,'Coordinador','activo','2025-11-27 14:30:01','2025-11-27 14:30:01');
/*!40000 ALTER TABLE `responsables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id_servicio` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_responsable` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_servicio`),
  KEY `servicios_id_responsable_foreign` (`id_responsable`),
  CONSTRAINT `servicios_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'Activos fijos','Área encargada de la gestión de activos fijos',1,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(2,'Ginecología','Área de ginecología y atención a pacientes femeninas',2,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(3,'Pediatría','Área de atención a niños y adolescentes',3,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(4,'Laboratorio','Área de análisis clínicos y laboratorio',4,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(5,'Radiología','Área de estudios de imagen y diagnóstico',5,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(6,'Farmacia','Área de distribución y control de medicamentos',6,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(7,'Emergencias','Área de atención de urgencias y emergencias',7,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(8,'Enfermería','Área de enfermería y atención a pacientes',8,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(9,'Administración','Área administrativa del hospital',9,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(10,'Auxiliar de Enfermería','Área de apoyo en enfermería',10,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(11,'Cirugía General','Área de cirugía y procedimientos quirúrgicos',11,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(12,'Urología','Área de diagnóstico y tratamiento urológico',12,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(13,'Cardiología','Área de atención y estudio cardiológico',13,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(14,'Traumatología','Área de ortopedia y traumatología',14,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(15,'Nutrición','Área de dietética y nutrición',15,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(16,'Fisioterapia','Área de rehabilitación y fisioterapia',16,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(17,'Psicología','Área de atención psicológica y soporte emocional',17,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(18,'Servicios Generales','Área de mantenimiento, limpieza y apoyo logístico',18,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(19,'Nutrición Clínica','Área de planificación de dietas y soporte nutricional',19,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(20,'Docencia e Investigación','Área de formación y estudios médicos',20,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(21,'Dirección','Área de dirección del hospital',21,'2025-01-01 04:00:00','2025-01-01 04:00:00'),(22,'recursos humanos',NULL,10,'2025-11-24 14:30:30','2025-11-24 14:30:30');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traslados`
--

DROP TABLE IF EXISTS `traslados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `traslados` (
  `id_traslado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `id_servicio_origen` bigint unsigned NOT NULL,
  `id_responsable_origen` bigint unsigned NOT NULL,
  `id_responsable_destino` bigint unsigned NOT NULL,
  `id_servicio_destino` bigint unsigned NOT NULL,
  `observaciones` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_traslado`),
  KEY `traslados_id_usuario_foreign` (`id_usuario`),
  KEY `traslados_id_servicio_origen_foreign` (`id_servicio_origen`),
  KEY `traslados_id_servicio_destino_foreign` (`id_servicio_destino`),
  KEY `traslados_id_responsable_origen_foreign` (`id_responsable_origen`),
  KEY `traslados_id_responsable_destino_foreign` (`id_responsable_destino`),
  CONSTRAINT `traslados_id_responsable_destino_foreign` FOREIGN KEY (`id_responsable_destino`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `traslados_id_responsable_origen_foreign` FOREIGN KEY (`id_responsable_origen`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  CONSTRAINT `traslados_id_servicio_destino_foreign` FOREIGN KEY (`id_servicio_destino`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `traslados_id_servicio_origen_foreign` FOREIGN KEY (`id_servicio_origen`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `traslados_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traslados`
--

LOCK TABLES `traslados` WRITE;
/*!40000 ALTER TABLE `traslados` DISABLE KEYS */;
INSERT INTO `traslados` VALUES (1,'001',2025,'2025-02-03',1,2,4,5,5,'','finalizado',NULL,'2025-02-03 12:00:00','2025-11-24 04:50:42'),(2,'002',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:01:00','2025-02-03 12:01:00'),(3,'003',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:02:00','2025-02-03 12:02:00'),(4,'004',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:03:00','2025-02-03 12:03:00'),(5,'005',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:04:00','2025-02-03 12:04:00'),(6,'006',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:05:00','2025-02-03 12:05:00'),(7,'007',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:06:00','2025-02-03 12:06:00'),(8,'008',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:07:00','2025-02-03 12:07:00'),(9,'009',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:08:00','2025-02-03 12:08:00'),(10,'010',2025,'2025-02-03',1,4,4,5,5,NULL,'pendiente',NULL,'2025-02-03 12:09:00','2025-02-03 12:09:00'),(11,'011',2025,'2025-11-24',1,8,8,5,5,NULL,'pendiente',NULL,'2025-11-24 04:53:46','2025-11-24 04:53:46');
/*!40000 ALTER TABLE `traslados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidades` (
  `id_unidad` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,'Unidad','u.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(2,'Pieza','pza.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(3,'Caja','cj.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(4,'Par','par','2025-01-01 04:00:00','2025-01-01 04:00:00'),(5,'Set','set','2025-01-01 04:00:00','2025-01-01 04:00:00'),(6,'Equipo','eq.','2025-01-01 04:00:00','2025-01-01 04:00:00'),(7,'Juego','jgo.','2025-01-01 04:00:00','2025-01-01 04:00:00');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('administrador','desarrollador','usuario') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `id_responsable` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuarios_usuario_unique` (`usuario`),
  KEY `usuarios_id_responsable_foreign` (`id_responsable`),
  CONSTRAINT `usuarios_id_responsable_foreign` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'jhon','$2y$12$sjYBMg.9.eXMf2FAM1pIL.fqZ57eLxIHzDWQU1uuKLLbz/GqNuujS','usuario','activo',1,NULL,'2025-01-02 04:00:00','2025-01-02 04:00:00'),(2,'admin','$2y$12$Mi7aj./dHm6XaqbNTlfXA.i98jMy3noquAP47BYp4AN7kob1QFMhK','administrador','activo',2,NULL,'2025-01-02 04:00:00','2025-01-02 04:00:00');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-30  9:38:29
