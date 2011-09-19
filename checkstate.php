<?php
require ("functions.php");
if (filter_var($_POST['name'],FILTER_VALIDATE_EMAIL) == TRUE)
{
	if (checkexist($_POST['name']) == TRUE) 
		{
		checkstate($_POST['name']);
		}
		else echo "ERROR, Account Does Not Exist.";
}
else echo "ERROR, Information Provided Is Not Correct.";
?>


