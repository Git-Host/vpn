<?php
/*This file handles extra email message sending.*/
require("config.php");
require("functions.php");
$sitepassword = md5(md5($sitepassword,false),false);
if((is_numeric($_POST['mailid']) == TRUE) && ($_POST['sitepassword'] == $sitepassword))
{	
	sendmessage($_POST['mailid'],$_POST['mailbody']);
}
else if ($_POST['sitepassword'] == $sitepassword)
	{if ($_POST['mailid'] == "ALL") 
	{
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM file order by id asc;";
	$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result))
			{
			$mailid = $row['id'];	
			sendmessage($mailid,$_POST['mailbody']);
			}	
	}}
	else fallback();
?>
