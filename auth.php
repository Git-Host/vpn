<?php
require("config.php");
require ("functions.php");
$sitepassword = md5(md5($sitepassword,false),false);
if(($_GET['sitepassword'] == $sitepassword) && $_GET['action']) 
{
if ((is_numeric($_GET['operateid']) == TRUE) && ($_GET['action'] == "enauth")) {enauth($_GET['operateid']);echo "1";}
if ((is_numeric($_GET['operateid']) == TRUE) && ($_GET['action'] == "deauth")) {deauth($_GET['operateid']);echo "0";}
if ($_GET['action'] == "rebuildsecret") {rebuildsecret();header("location:./admin.php?sitepassword=" . $_GET['sitepassword']);}
else if ($_GET['action'] == "analyzelog") {analyzelog();analyzesublog();header("location:./admin.php?sitepassword=" . $_GET['sitepassword']);} else if (is_numeric($_GET['operateid']) == FALSE) exit(fallback());
//header("location:./admin.php?sitepassword=" . $_GET['sitepassword']);
}
else fallback();
?>
