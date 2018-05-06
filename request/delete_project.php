<?php
ob_start();
session_start();
include_once("../includes/config.php");
if((isset($_SESSION['username'])) and (isset($_SESSION['password']))) {
	if(isset($_POST['rp_id'])) {
	$rp_id = $_POST['rp_id'];
		$check = mysql_query("select * from project_list where 	p_id='".$rp_id."'");
		if($check) {
			$delete_project = mysql_query("DELETE FROM project_list where p_id='".$rp_id."'");
			echo $rp_id;
		}
	}
}