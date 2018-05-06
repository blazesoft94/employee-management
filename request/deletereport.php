<?php

ob_start();

session_start();

include_once("../includes/config.php");

if((isset($_SESSION['username'])) and (isset($_SESSION['password']))) {

	// DELETE WORK REPORT BY USING

	// PAGE: my-work-status.php

	if(isset($_GET['temp_id'])) {

		$remove_id = $_GET['temp_id'];

		$check = mysql_query("select * from temporary_report where username='".$_SESSION['username']."' and temp_id='".$remove_id."'");

		if(mysql_num_rows($check) == 1) {

			$delete_temp = mysql_query("DELETE FROM temporary_report where temp_id='".$remove_id."'");

			header("Location: $conf_path/my-work-status.php");

		}

	}

	

	

	// DELETE TEMPORARY WORK REPORT BY USING

	// PAGE: tempwork-report.php

	if(isset($_GET['id'])) {

		$remove_id = $_GET['id'];

		$check = mysql_query("select * from temporary_report where username='".$_SESSION['username']."' and temp_id='".$remove_id."'");

		if($check) {

			$delete_temp = mysql_query("DELETE FROM temporary_report where temp_id='".$remove_id."'");

			header("Location: $conf_path/tempwork-report.php");

		}

	}

}



?>