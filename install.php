<?php
/*This file initialises the database.*/
require("config.php");
$db = mysql_connect($dbserver,$dbuser,$dbpassword);
mysql_select_db($dbname,$db);	
$sql = "CREATE TABLE  `vpn` (`id` SMALLINT( 4 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`name` VARCHAR( 80 ) NOT NULL ,`passwd` VARCHAR( 80 ) NOT NULL ,`reason` TEXT NOT NULL ,`date` DATETIME NOT NULL ,`ip` TEXT NOT NULL ,`state` TINYINT( 1 ) NOT NULL ,`time` FLOAT(7,1) UNSIGNED NULL  ,`data` BIGINT(20) UNSIGNED NULL ,UNIQUE (`name`));";
$result = mysql_query($sql);
if ($result != 1) exit("PPVSWA Main Database Installation Faild.<br />  This Means PPVSWA Already Installed Or Information Provided In 'config.php' Is Not Correct. Please Check Your 'config.php'.");
$sql = "CREATE TABLE  `vpn`.`key` (`value` VARCHAR( 14 ) NOT NULL ,`state` TINYINT( 1 ) NOT NULL) ";
$result = mysql_query($sql);
if ($result != 1) exit("PPVSWA Activation Key Database Installation Faild.<br /> This Means PPVSWA Already Installed Or Information Provided In 'config.php' Is Not Correct. Please Check Your 'config.php'.");

echo "DB Install Compeleted. <br /> Note:Do NOT Run This Again." ; 

?>
