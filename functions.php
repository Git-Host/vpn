<?php

function enauth($enauthid)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 1 WHERE id = " . $enauthid . ";";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE id = " . $enauthid . ";";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :ACTIVITED";
	$mailbody = "Congratulations，Your VPN Account at " . $sitename . " Has Been Activated.\n\nYour User Name Is:" . $row['name'] . "\nYour Password Is：" . $row['passwd'] . "\nThe Address Of Your Server Is：" . $vpnaddress . " \n\n". $sitename . "'s VPN Service Is Based On PPTP ,Please Google (PPTP VPN Configuration)For Detailed Configuration Process.";
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
}


function selfenauth($name,$key)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 1 , reason = '" . $key . "' WHERE name = '" . $name . "';";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :ACTIVITED";
	$mailbody = "Congratulations，Your VPN Account at " . $sitename . " Has Been Activated.\n\nYour User Name Is:" . $row['name'] . "\nYour Password Is：" . $row['passwd'] . "\nThe Address Of Your Server Is：" . $vpnaddress . " \n\n". $sitename . "'s VPN Service Is Based On PPTP ,Please Google (PPTP VPN Configuration) For Detailed Configuration Process.";
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
	
	rebuildsecret();
	$sql = "UPDATE `vpn`.`key` SET state = 2 WHERE value = '" . $key . "';";	
	mysql_query($sql);
}




function deauth($deauthid)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 0 WHERE id = " . $deauthid . ";";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE id = " . $deauthid . ";";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :DEACTIVITED";
	$mailbody = "Hi，Your PPTP VPN Account At " . $sitename . "Has Been Disabled.\n\nYour User Name Is:" . $row['name'] . "\nYour Password Is：" . $row['passwd'] . "\nThe Address Of Your Server Is：" . $vpnaddress . "\n\nIf Your Have Questions For This, Please Contact " . $siteemail ;
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
}

function rebuildsecret()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);
	$sql = "SELECT * FROM vpn WHERE state = 1 ORDER BY date ASC;";
	$result = mysql_query($sql);
	$secretfile = fopen($secretfile,"w") or exit("ERROR Opening Secret File. " . $secretfile);
	while ($row = mysql_fetch_assoc($result))
		{
		$secretrow = $row['name'] . "  " . $vpnname . "  " . $row['passwd'] . "  " . $row['ip'] . " \n";
		fwrite($secretfile,$secretrow);
		}
	$oldfile = file_get_contents($oldsecretfile);
	fwrite($secretfile,$oldfile);
	fclose($secretfile);
}

function fallback()
{
echo "Action FAILED. <br />This May Because You Have Entered A Wrong ID Or Password.<br />";
echo "<script type=\"text/javascript\" src=\"md5.js\"></script><form action=\"./admin.php\" method=\"GET\"><table><p>Admin Login</p><tr><td><input type=\"password\" name=\"sitepassword\" id=\"sitepassword\" value=\"\" /></td></tr><tr><td><input type=\"submit\" value=\"Login\" onclick=\"encode()\" /></td></tr></table></form>";
}


function newkey()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	for ($i=0;$i<=4;$i++) 
	{
	$newkey = uniqid();
	$sql = "INSERT INTO  `vpn`.`key` (`value` ,`state`) VALUES ('" . $newkey . "',  '1');";
	mysql_query($sql);
	echo $newkey . "<br />";
	}
}


function verifykey($key)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM `vpn`.`key` WHERE value = '" . $key . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['state'] == 1) return TRUE;else return FALSE;
}


function checkstate($name)
{
	require("config.php");
	analyzelog();
	analyzesublog();
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['state'] == 1) $message = "Hi there, Your Account is Active.<br/>Your User Name is：" . $row['name'] . "<br/>Your Password is：" . $row['passwd'] . "<br/>Address of your server is：" . $vpnaddress . "<br/>Your IP on VPN is : " . $row['ip'] . "<br />You have been on the server for " . $row['time'] . " minutes, transmited " . $row['data'] . " bytes of data. ";
	else $message = "Hi there, Your Account is Disabled.<br/>Your User Name is：" . $row['name'] . "<br/>Your Password is：" . $row['passwd'] . "<br/>Address of your server is：" . $vpnaddress . "<br/>Your IP on VPN is : " . $row['ip'] . "<br />You have been on the server for " . $row['time'] . " minutes, transmited " . $row['data'] . " bytes of data. ";
	echo $message;
}


function checkexist($name)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['name']) return TRUE;else return FALSE;
}


function usekey($name,$key)
{
	if (verifykey($key) == TRUE)
	{
	if (checkexist($name) == TRUE) selfenauth($name,$key);else exit("Account Does Not Exist, Register First.");
	}
	else exit("This Key Is Not Correct Or Used.");
	echo "Account " . $name . " Activited.";
}

function listkey()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM `vpn`.`key` WHERE state = 1;";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) 
	{
	echo $row['value'] . "<br />";
	}
}


function sendmessage($id,$message)
{	
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE id = " . $id . " ;";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	$mailto = $row['name'];
	$mailsubject = "VPN :Message";
	$mailbody = "Hi there，You recieve this email is mainly because that you are a user of " . $sitename . "'s PPTP VPN service.\n\nYour User Name is：" . $row['name'] . "\nYour Password is：" . $row['passwd'] . "\nAddress of your server is：" . $vpnaddress . "\nYou have been on the server for " . $row['time'] . " minutes, transmited " . $row['data'] . " bytes of data. \n\nThe Administrator has sent you a messge：\n\n" . $message;
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
	echo "Mail Sent For ID " . $row['id'] . ".<br />";
}

function arrangeip()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "Select id from vpn order by id DESC limit 1;";
	mysql_query($sql);
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	sscanf ($maxip,"%d.%d.%d.%d",$ip_8,$ip_16,$ip_24,$ip_32);
	$ip_32 = $ip_32 - $row['id'];
	$string = $ip_8 . "." . $ip_16 . "." . $ip_24 . "." . $ip_32;
	if (($ip_32 <= 1) || $ip_32 >= 255) return "*";
	else return ($string);
}

function analyzesublog()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$log = file($sublogfile) or exit("Opening sublogfile FAILD.");
	foreach ($log as $row)
	{
	$string = explode(" ",$row);
	sscanf ($string[3],"%d.%d.%d.%d",$ip_8,$ip_16,$ip_24,$ip_32);
	$logip = "ip_" . $ip_24 . "_" . $ip_32;

	if ($$logip) continue;
	$$logip = 1;
	$time = 0;
	$data = 0;
	foreach ($log as $subrow) 
		{
		$substring = explode(" ",$subrow);
		if ($string[3] == $substring[3])
			{
			$time += $substring[5];
			$data += $substring[4];
			$curkey = (key($log) - 1);
			unset($log[$curkey]);
			
			}
		}
	
	$sql = "UPDATE vpn SET time = " . $time . " , data = " . $data . " WHERE ip = '" . $string[3] . "';";
	mysql_query($sql);
//	echo $string[3] . " " . $time . " " . $data . "<br/>";
//	echo "<br/>";
	}
}



function analyzelog()
{
	require ("config.php");
	$newlog = file($logfile) or exit("Opening logfile FAILD.");
	$targetfile = fopen($sublogfile,"a")  or exit("Opening sublogfile FAILD.");
	$oldlog = file($analyzedlogfile) or exit("Opening analyzedlogfile FAILD.");
	$diflog = array_diff($newlog,$oldlog);
	unset ($newlog);
	unset ($oldlog);
//	fwrite($targetfile,"#This sublog is generated by PPVSWA after analizing " . $logfile . "\n");
	foreach ($diflog as $row)
	{
	$row = str_replace("  "," ",$row);
	$string = explode(" ",$row);
	if (strncasecmp($string[4],"pppd",4) == 0) 
		{
		if (strncasecmp($string[5],"remote",6) == 0)
			{
			$ip =substr($string[8],0,-1);
			
			foreach ($diflog as $subrow)
				{
					$subrow = str_replace("  "," ",$subrow);
					$substring = explode(" ",$subrow);

					if (($substring[4] == $string[4])&&($substring[8] == "minutes.\n")) {$subtime = $substring[7];
					$curkey = key($diflog);
					unset($diflog[$curkey]);}
					if (($substring[4] == $string[4])&&($substring[10] == "bytes.\n")) 
					{
					$gonawrite = $substring[0] . " " . $substring[1] . " " . $substring[2] . " " . $ip . " " . ($substring[6] + $substring[9]) . " " . $subtime . "\n";
//					echo $gonawrite . "<br/>";
					fwrite($targetfile,$gonawrite);
					$curkey = (key($diflog) - 1);
					unset($difblog[$curkey]);

					break;
					}
					
					
				}
			}
		}
	else   {
	$curkey = (key($diflog) - 1);
	unset($diflog[$curkey]);
		}
	}
	fclose($targetfile);
	if (copy($logfile,$analyzedlogfile) != 1) 
	{
	$targetfile = fopen($sublogfile,"w");
	fclose($targetfile);
	$targetfile = fopen($analyzedlogfile,"w");
	fwrite($targetfile,"-1\n");
	fclose($targetfile);
	exit ("ERROR: Backing Up Current Log File FAILD. All SubLogs Were Deleted. Full Rebuild Nextime. Please Make Sure '" . $analyzedlogfile ."' Is Writable.");
	}
}


?>
