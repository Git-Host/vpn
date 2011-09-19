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
<h1>Public PPTP VPN Server Web Authorize system.</h1><p><a href="./admin.php">Go Admin Page</a>    <a href="./selfservice.php">Go Self_Active/Check Page.</a></p><br />
<?php
/*This file outputs the form for application.*/
require ("config.php");
echo "<h4>This Page Is For Application Of " . $sitename . "'s PPTP VPN Service.  Please Fill Out This Form.</h4><br />";
echo "<form action=\"./handler.php\" method=\"POST\">
<table>
<tr>
<td>Your Email (as user name)  </td>
<td><input type=\"text\" name=\"name\" value=\"\" /></td>
</tr>
<tr>
<td>Your Password</td>
<td><input type=\"text\" name=\"passwd\" value=\"\" /></td>
</tr>
<tr>
<td>Why You Apply For The Account </td>
<td><textarea name=\"reason\" rows=\"8\" cols=\"40\"></textarea></td>
</tr>
<tr><td><input type=\"submit\" value=\"Apply\" /></td></tr>
</table></form>";
?>

