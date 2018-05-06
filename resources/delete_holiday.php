<?php
ob_start();
session_start();
include_once("../includes/config.php");
include_once("../includes/function.php");
// prevent unwanted creation
if($_SESSION['role']== 'admin' || in_array("35", $_SESSION['permission'])) {
// List of events
 // connection to the database
 /*try {
 $bdd = new PDO('mysql:host=localhost;dbname=techwbzd_eoffice', 'techwbzd_eoffice', '+ErHgEb7(0?n');
 } catch(Exception $e) {
  exit('Unable to connect to database.');
 }*/
 // Execute the query

	 $d_id = $_POST['id'];
	 $sql = mysql_query("DELETE from holiday_list WHERE id='".$d_id."'");

}
?>
