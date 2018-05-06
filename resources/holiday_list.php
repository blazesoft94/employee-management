<?php
ob_start();
session_start();
include_once("../includes/config.php");
include_once("../includes/function.php");

// List of events
 $json = array();
 /* PDO PROCESS - 1st methods */
 // Query that retrieves events
 /*$requete = "SELECT * FROM `holiday_list` ORDER BY id";
 
 // connection to the database
 try {
 $bdd =  new PDO('mysql:host=localhost;dbname=techwbzd_eoffice', 'techwbzd_eoffice', '+ErHgEb7(0?n');
 } catch(Exception $e) {
  exit('Unable to connect to database.');
 }
 // Execute the query
 $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

 // sending the encoded result to success page
 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));*/
 
 /* core PHP 2ND METHODS */
	 //Create an array
	$requete = mysql_query("SELECT * FROM `holiday_list` ORDER BY id");
	$json_response = array();
	while ($row = mysql_fetch_array($requete, MYSQL_ASSOC)) {
			$row_array['id'] = $row['id'];
	        $row_array['title'] = $row['title'];
	        $row_array['start'] = $row['start'];
	        $row_array['end'] = $row['	end'];
	        $row_array['url'] = $row['url'];
	        $row_array['allday'] = $row['allday'];
			$row_array['className'] = $row['className'];
			/*$row_array['background-color'] = '#AEC6CF';*/
	        //push the values in the array
	        array_push($json_response,$row_array);
	    }
	echo json_encode($json_response);
?>
