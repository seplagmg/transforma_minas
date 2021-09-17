/*!50003 DROP FUNCTION IF EXISTS `remove_accents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `remove_accents`(`str` TEXT) RETURNS text CHARSET utf8
    NO SQL
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN



    SET str = REPLACE(str,'Š','S');

    SET str = REPLACE(str,'š','s');

    SET str = REPLACE(str,'Ð','Dj');

    SET str = REPLACE(str,'Ž','Z');

    SET str = REPLACE(str,'ž','z');

    SET str = REPLACE(str,'À','A');

    SET str = REPLACE(str,'Á','A');

    SET str = REPLACE(str,'Â','A');

    SET str = REPLACE(str,'Ã','A');

    SET str = REPLACE(str,'Ä','A');

    SET str = REPLACE(str,'Å','A');

    SET str = REPLACE(str,'Æ','A');

    SET str = REPLACE(str,'Ç','C');

    SET str = REPLACE(str,'È','E');

    SET str = REPLACE(str,'É','E');

    SET str = REPLACE(str,'Ê','E');

    SET str = REPLACE(str,'Ë','E');

    SET str = REPLACE(str,'Ì','I');

    SET str = REPLACE(str,'Í','I');

    SET str = REPLACE(str,'Î','I');

    SET str = REPLACE(str,'Ï','I');

    SET str = REPLACE(str,'Ñ','N');

    SET str = REPLACE(str,'Ò','O');

    SET str = REPLACE(str,'Ó','O');

    SET str = REPLACE(str,'Ô','O');

    SET str = REPLACE(str,'Õ','O');

    SET str = REPLACE(str,'Ö','O');

    SET str = REPLACE(str,'Ø','O');

    SET str = REPLACE(str,'Ù','U');

    SET str = REPLACE(str,'Ú','U');

    SET str = REPLACE(str,'Û','U');

    SET str = REPLACE(str,'Ü','U');

    SET str = REPLACE(str,'Ý','Y');

    SET str = REPLACE(str,'Þ','B');

    SET str = REPLACE(str,'ß','Ss');

    SET str = REPLACE(str,'à','a');

    SET str = REPLACE(str,'á','a');

    SET str = REPLACE(str,'â','a');

    SET str = REPLACE(str,'ã','a');

    SET str = REPLACE(str,'ä','a');

    SET str = REPLACE(str,'å','a');

    SET str = REPLACE(str,'æ','a');

    SET str = REPLACE(str,'ç','c');

    SET str = REPLACE(str,'è','e');

    SET str = REPLACE(str,'é','e');

    SET str = REPLACE(str,'ê','e');

    SET str = REPLACE(str,'ë','e');

    SET str = REPLACE(str,'ì','i');

    SET str = REPLACE(str,'í','i');

    SET str = REPLACE(str,'î','i');

    SET str = REPLACE(str,'ï','i');

    SET str = REPLACE(str,'ð','o');

    SET str = REPLACE(str,'ñ','n');

    SET str = REPLACE(str,'ò','o');

    SET str = REPLACE(str,'ó','o');

    SET str = REPLACE(str,'ô','o');

    SET str = REPLACE(str,'õ','o');

    SET str = REPLACE(str,'ö','o');

    SET str = REPLACE(str,'ø','o');

    SET str = REPLACE(str,'ù','u');

    SET str = REPLACE(str,'ú','u');

    SET str = REPLACE(str,'û','u');

    SET str = REPLACE(str,'ý','y');

    SET str = REPLACE(str,'ý','y');

    SET str = REPLACE(str,'þ','b');

    SET str = REPLACE(str,'ÿ','y');

    SET str = REPLACE(str,'ƒ','f');





    RETURN str;

END ;;
DELIMITER ;