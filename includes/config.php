<?php
error_reporting(0);
$db_database = "employee__blazeweb";
$db_name="root";
$db_pass = "";
$db_host ="localhost";
$conf_path = "http://localhost/employee";
$conf_mail = "eoffice@techware.in";
/* attendance mail function */
/* hr response mail function */
$hrmail = "hr@abc.com";
$link = mysql_connect($db_host,$db_name,$db_pass);
mysql_select_db($db_database,$link) or die('Error to connect Database');

// SET DEFAULT TIME ZONE
date_default_timezone_set('America/Los_Angeles');
?>