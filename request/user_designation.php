<?php
ob_start();
session_start();
include_once("../includes/config.php");

if(isset($_POST['q'])) {
$department_name = base64_decode($_POST['q']);

$result = mysql_query("SELECT * FROM department WHERE department_name='".$department_name."'");
while($row = mysql_fetch_array($result))
  {
    $r .= '<option value="'.$row['designation'].'">' . $row['designation'] . '</option>';
  }
echo $r;
}
?>