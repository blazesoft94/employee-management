<?php
ob_start();
session_start();
include_once("../includes/config.php");

$role = $_POST['q'];
$date= date('Y-m-d H:i:s');

$result = mysql_query("SELECT * FROM `role` WHERE rolename='".$role."'");
if(mysql_num_rows($result) == 0) {
	$insert = mysql_query("INSERT INTO role (`rolename`,`created_date`) VALUES ('".$role."','".$date."')");
	if($insert) {
		echo "Rolename: ".$role." Added successfully";
	}
} else {
	echo "Rolename: $role Already Added";
}
?>