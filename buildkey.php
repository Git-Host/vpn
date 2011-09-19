<?php
/*This file builds 5 new key.password required*/
require("config.php");
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword) 
{
require("functions.php");
newkey();
}
else fallback();


?>
