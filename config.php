<?php
$dbserver = "localhost"; //your MySQL server address
$dbuser = ""; //your MySQL user name
$dbpassword = ""; //your MySQL user password
$dbname = ""; //your MySQL database name for your site
$sitename = ""; //your site's name
$vpnaddress = ""; //your pptp vpn server's address
$vpnname = "pptpd"; //your pptp vpn server's name
$sitepassword = ""; //set a password for this web admin program
$siteurl = ""; //your site's url with http://
$siteemail = ""; //your site's admin email address
$logfile = "/var/log/messages"; //your 'messages' log file
$sublogfile = "sublog"; //sublog file created by PPVSWA, Need Write permission for that.
$analyzedlogfile = "analyzedlog"; //analyzed system log file. Do Not Delete Or Modify.
$maxip = "192.168.1.254";//client MAX ipv4 . The last 8 bit SHOULD BE 254. And you should alow this network access NAT by setting iptables.
$secretfile = "/etc/ppp/chap-secrets"; //your chap-secrets file location
$oldsecretfile = "/etc/ppp/chap-secrets.old"; //your old chap-secrets file location

//注意！此处所有变量都必须填全，否则程序无法运行
//ALL varables in this file MUST be set.
?>
