DROP TABLE IF EXISTS `logs`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE `logs` (

  `DT` datetime NOT NULL,

  `login` varchar(30) NOT NULL,

  `ip` varchar(15) NOT NULL DEFAULT '   .   .   .',

  `state` int(1) NOT NULL
) 
ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET character_set_client = @saved_cs_client */;