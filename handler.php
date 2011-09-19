<?php
if((filter_var($_POST['name'],FILTER_VALIDATE_EMAIL) == true) && $_POST['name'] && $_POST['passwd'] && $_POST['reason']) {
	require("config.php");
	require("functions.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$ip = arrangeip();
	$sql = "INSERT INTO vpn(date,name,reason,passwd,ip,state) VALUES(NOW(),'$_POST[name]','$_POST[reason]','$_POST[passwd]','$ip',\"0\");";
	mysql_query($sql);
	echo "Your Application Has Been Received, Please Wait For The Administrator To Activate Your Account Or <a href=\"./selfservice.php\">Use Active Key To Active Yourself.</a><br /> Note: The Replied e-mail Maybe In Your 'Spam Box' Insted Of 'In Box'.<br />AND, If You Applied Your e-mail For More Than Once, Only The First Request Was Accepted By The Database, All Others Were Dropped.";
}
else {
	echo "Your Application Is Not Valid. <br />This May Because You Have Entered A Wrong email Or Did Not Give Enough Information.";
}
?>
