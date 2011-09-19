<?php
require("config.php");
/*This file lists all unused key,password required.*/
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword)
{
	require("functions.php");
	listkey();
	echo "<br /><a href=\"./buildkey.php?sitepassword=" . $sitepassword . " \">Build 5 New Key</a>";
}
else 
fallback();


?>
