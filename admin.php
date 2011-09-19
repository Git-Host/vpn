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
<script type="text/javascript" src="md5.js"></script>
<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script-->
<script type="text/javascript">
function enAuth(id)
{
var url = "./auth.php?action=enauth&operateid=" + id
var sitepassword ="&sitepassword=<?php echo $_GET['sitepassword']; ?>"
url=url+sitepassword
url=url+"&random="+Math.random()
var div_id = "idstate" + id
loadState(url,div_id)
}

function deAuth(id)
{ 
var url = "./auth.php?action=deauth&operateid=" + id
var sitepassword ="&sitepassword=<?php echo $_GET['sitepassword']; ?>"
var div_id
url=url+sitepassword
url=url+"&random="+Math.random()
div_id = "idstate" + id
loadState(url,div_id)
}

/*function stateChanged(thing,div_id) 
{ 
 if (thing.readyState != 4 )
 { 
 document.getElementById(div_id).innerHTML="^_^"
 } 

 if (thing.readyState == 4 )
 { 
 document.getElementById(div_id).innerHTML= thing.responseText
 }
}
*/

function loadState(url,div_id)
{
var xmlHttp = GetXmlHttpObject();
//xmlHttp.onreadystatechange = stateChanged(xmlHttp,div_id);
document.getElementById(div_id).innerHTML = "N/A";
xmlHttp.open("GET",url,true);
xmlHttp.send(null);

/*$.get (url);
$(div_id).html("N/A");*/


}


function GetXmlHttpObject()
{
var xmlHttp=null;

try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

function makemail(id)
{
var url
url = "mailmaker.php?sitepassword=<?php echo $_GET['sitepassword'];?>&mailid="
url = url + id
window.open (url, 'makemail', 'height=400, width=450, top=60, left=60, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=yes, status=yes')
}
</script>
</head>
<body>
<?php
require ("config.php");
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword)
{	
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);
	$sql = "SELECT * FROM vpn ORDER BY date DESC ;";
	$result = mysql_query($sql);
	echo "<h4>Public PPTP VPN Server Web Authorize system.</h4><p><a href=\"javascript:makemail('ALL')\">Send Message To All</a>    <a href=\"./auth.php?action=rebuildsecret&sitepassword=" . $_GET['sitepassword'] . "\">REBUILD Secret File</a>     <a href=\"./viewkey.php?sitepassword=" . $_GET['sitepassword'] . "\">View Unused Activation Keys.</a>   <a href=\"./auth.php?action=analyzelog&sitepassword=" . $_GET['sitepassword'] . "\">Analyze Log File</a><br />Note:Secret File Rebuild Needed After You Modify Authorizations.</p><table width=\"100%\" border=\"1\"><tr><th>ID</th><th>email</th><th>Password</th><th>IP</th><th>DateTime</th><th>Reason</th><th>Time</th><th>Data</th><th>State</th><th>Action</th></tr>";
	while ($row = mysql_fetch_assoc($result)) 
		{
		echo "<tr><td><h4>" . $row['id'] . " </h4></td><td> " . $row['name'] . " </td><td>" . $row['passwd'] . "</td><td> "  . $row['ip'] . "</td><td>" . date("D j F Y g.iA", strtotime($row['date'])) . "</td><td>";
		echo $row['reason'];
		echo "</td><td>" . $row['time'] . "</td><td>" . $row['data'] . "</td><td id=\"idstate" . $row['id'] . "\">" . $row['state'] . "</td><td><a href=\"javascript: enAuth(" . $row['id'] . ")\">Authorize</a><br /><a href=\"javascript: deAuth(" . $row['id'] . ")\">Deauthorize</a><br /><a href=\"javascript:makemail(" . $row['id'] . ")\">Send Message</a></td></tr>";

}
		echo "</table>";
}
else 
echo "<script type=\"text/javascript\" src=\"md5.js\"></script><form action=\"./admin.php\" method=\"GET\"><table><p>Admin Login</p><tr><td><input type=\"password\" name=\"sitepassword\" id=\"sitepassword\" value=\"\" /></td></tr><tr><td><input type=\"submit\" value=\"Login\" onclick=\"encode()\" /></td></tr></table></form>";
?>
</body>
</html>
