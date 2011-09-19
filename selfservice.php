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
<h1>Public PPTP VPN Server Web Authorize system.</h1><a href="./admin.php">Go Admin Page</a><br />
<?php
require ("config.php");
echo "<h4>This Page Is For Self-Activation And Account Status Checking Of " . $sitename . "'s PPTP VPN Service. Please Fill Out This Form.</h4><br />";
echo "<form action=\"./selfauth.php\" method=\"POST\"><h4>Activate Your Own Account With A Activation KEY：</h4>
<table>
<tr>
<td>Your Existing Account (email) :  </td>
<td><input type=\"text\" name=\"name\" value=\"\" /></td>
</tr>
<tr>
<td>The Key :</td>
<td><input type=\"text\" name=\"key\" value=\"\" /></td>
</tr>

<tr><td><input type=\"submit\" value=\"Activate\" /></td></tr>
</table></form><br /><br />
<form action=\"./checkstate.php\" method=\"POST\"><h4>Check Your Existing Account Status.</h4>
<table>
<tr>
<td>Your Existing Account (email) :  </td>
<td><input type=\"text\" name=\"name\" value=\"\" /></td>
</tr>

<tr><td><input type=\"submit\" value=\"Check\" /></td></tr>
</table></form>";
?>
