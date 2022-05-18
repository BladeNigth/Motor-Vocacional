-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `completado`
--

DROP TABLE IF EXISTS `completado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `completado` (
  `ID_Completado` int(11) NOT NULL,
  `ID_usuarios` varchar(45) NOT NULL,
  `Fecha_Inicio` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_Completado`,`ID_usuarios`),
  KEY `fk_Completado_Usuarios1` (`ID_usuarios`),
  CONSTRAINT `fk_Completado_Usuarios1` FOREIGN KEY (`ID_usuarios`) REFERENCES `usuarios` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `completado`
--

LOCK TABLES `completado` WRITE;
/*!40000 ALTER TABLE `completado` DISABLE KEYS */;
/*!40000 ALTER TABLE `completado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuestas`
--

DROP TABLE IF EXISTS `encuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuestas` (
  `idEncuestas` int(11) NOT NULL,
  `Nombre_encuesta` varchar(45) NOT NULL,
  `Detalle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEncuestas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuestas`
--

LOCK TABLES `encuestas` WRITE;
/*!40000 ALTER TABLE `encuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `encuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foro`
--

DROP TABLE IF EXISTS `foro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foro` (
  `ID_foro` double NOT NULL,
  `ID_usuarios` varchar(45) NOT NULL,
  `Comentarios` longtext DEFAULT NULL,
  `Fecha` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_foro`,`ID_usuarios`),
  KEY `fk_Foro_Usuarios1` (`ID_usuarios`),
  CONSTRAINT `fk_Foro_Usuarios1` FOREIGN KEY (`ID_usuarios`) REFERENCES `usuarios` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foro`
--

LOCK TABLES `foro` WRITE;
/*!40000 ALTER TABLE `foro` DISABLE KEYS */;
/*!40000 ALTER TABLE `foro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `id_Pregunta` int(11) NOT NULL,
  `Encuestas_idEncuestas` int(11) NOT NULL,
  `Enunciado` varchar(250) DEFAULT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_Pregunta`),
  KEY `fk_Preguntas_Encuestas1` (`Encuestas_idEncuestas`),
  CONSTRAINT `fk_Preguntas_Encuestas1` FOREIGN KEY (`Encuestas_idEncuestas`) REFERENCES `encuestas` (`idEncuestas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesiones`
--

DROP TABLE IF EXISTS `profesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesiones` (
  `IDprofesion` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Profesion` varchar(45) DEFAULT NULL,
  `Tipo_Profesion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IDprofesion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesiones`
--

LOCK TABLES `profesiones` WRITE;
/*!40000 ALTER TABLE `profesiones` DISABLE KEYS */;
INSERT INTO `profesiones` VALUES (1,'ingenieria','Ciencia'),(2,NULL,NULL);
/*!40000 ALTER TABLE `profesiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuestas` (
  `ID_Respuestas` int(11) NOT NULL AUTO_INCREMENT,
  `Preguntas_id_Pregunta` int(11) NOT NULL,
  `Valor_ID_Valor` int(11) NOT NULL,
  `Completado_ID_Completado` int(11) NOT NULL,
  PRIMARY KEY (`ID_Respuestas`),
  KEY `fk_Respuestas_Preguntas1` (`Preguntas_id_Pregunta`),
  KEY `fk_Respuestas_Valor1` (`Valor_ID_Valor`),
  KEY `fk_Respuestas_Completado1` (`Completado_ID_Completado`),
  CONSTRAINT `fk_Respuestas_Completado1` FOREIGN KEY (`Completado_ID_Completado`) REFERENCES `completado` (`ID_Completado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuestas_Preguntas1` FOREIGN KEY (`Preguntas_id_Pregunta`) REFERENCES `preguntas` (`id_Pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuestas_Valor1` FOREIGN KEY (`Valor_ID_Valor`) REFERENCES `valor` (`ID_Valor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestas`
--

LOCK TABLES `respuestas` WRITE;
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `Tipo_Usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES ('ADMINISTRADOR','andres'),('USUARIO','jose');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `Fecha_de_Creacion` timestamp NULL DEFAULT current_timestamp(),
  `Telefono` varchar(45) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL,
  `Identificacion` varchar(45) DEFAULT NULL,
  `Profesiones_IDprofesion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`usuario`),
  KEY `fk_Usuarios_Profesiones1` (`Profesiones_IDprofesion`),
  CONSTRAINT `fk_Usuarios_Profesiones1` FOREIGN KEY (`Profesiones_IDprofesion`) REFERENCES `profesiones` (`IDprofesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('andres','12345','pipebrieva@gmail.com','2022-05-06 04:17:46','3004992478','M','1083040640',1,'Andres Felipe Brieva Pinedo'),('jose','123','josecantillo@gmail.com','2022-05-10 04:39:41','3013610052','M','36561226',2,'jose cantillo');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valor`
--

DROP TABLE IF EXISTS `valor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valor` (
  `ID_Valor` int(11) NOT NULL AUTO_INCREMENT,
  `Texto` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_Valor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valor`
--

LOCK TABLES `valor` WRITE;
/*!40000 ALTER TABLE `valor` DISABLE KEYS */;
/*!40000 ALTER TABLE `valor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-18 14:01:25
