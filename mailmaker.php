<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>PPVSWA</title>
<style type="text/css">
body {
background-color: #fff4f4;
font-family: sans-serif;
color: teal;
}
h4 {
color: navy;
}

</style>
</head>
<body>
<?php
/* This file outputs a HTML form for email editing.*/
require("config.php");
require("functions.php");
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword)
{
	echo "<form action=\"./mailsender.php\" method=\"POST\"><table><h4>Send Message</h4><tr><td>To ID: </td><td><input type=\"text\" name=\"mailid\" value=\"" . $_GET['mailid'] . "\" /></td></tr><td>Message: </td><td><textarea name=\"mailbody\" rows=\"8\" cols=\"40\"></textarea></td></tr><tr><td><input type=\"hidden\" name=\"sitepassword\" value=\"" . $_GET['sitepassword'] . "\"></td><td><input type=\"submit\" value=\"Send\" /></td></tr></table></form>";
}
else 
{
	echo "Incorrect Password.";
	fallback();
}
?>
</body></html>
