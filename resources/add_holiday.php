<?php
ob_start();
session_start();
include_once("../includes/config.php");
include_once("../includes/function.php");
// prevent unwanted creation
if($_SESSION['role']== 'admin' || in_array("35", $_SESSION['permission'])) {
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$url = $_POST['url'];
$classname = $_POST['classname'];
if($classname == "2nd") { $class = "fc-grey";}
if($classname == "sunday") {$class = "fc-red";}
if($classname == "4th") {$class = "fc-grey";}
if($classname == "holiday") { $class = "fc-charcoal";}

$date = date("Y-m-d", strtotime($start));
// connection to the database
/*try {
 $bdd = new PDO('mysql:host=localhost;dbname=techwbzd_eoffice', 'techwbzd_eoffice', '+ErHgEb7(0?n');
 } catch(Exception $e) {
  exit('Unable to connect to database.');
 }
// insert the records
$sql = "INSERT INTO holiday_list (title, start, end, url, h_date,className) VALUES (:title, :start, :end, :url,:h_date,:className)";
$q = $bdd->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end,  ':url'=>$url, ':h_date'=>$date,':className'=>$class));*/
$sql = mysql_query("INSERT INTO holiday_list (title, start, end, url, h_date,className) VALUES ('".$title."','".$start."','".$end."','".$url."','".$date."','".$class."')");
if($sql) {
	echo "success";
}
}
?>
