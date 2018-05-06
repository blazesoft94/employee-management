<?php
ob_start();
session_start();
include_once("../includes/config.php");

$role = $_POST['q'];
$date= date('Y-m-d H:i:s');

$result = mysql_query("SELECT * FROM `role` WHERE rolename='".$role."'");
if(mysql_num_rows($result) == 1) {
	$ck = mysql_query("SELECT * FROM users WHERE role='".$role."'");
	if(mysql_num_rows($ck) > 0 ) {
		echo "Users working on this role... please change user role than delete the role..";
	} else {
		$dq = mysql_query("DELETE FROM role WHERE rolename='".$role."'");
		if($dq){
			echo "Rolename: $role Removed Successfully";
		}
	}
} 
?>