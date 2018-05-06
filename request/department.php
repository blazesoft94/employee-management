<?php
ob_start();
session_start();
include_once("../includes/config.php");

if(isset($_POST['q'])) {
$department = $_POST['q'];

$result = mysql_query("SELECT * FROM users WHERE department='".$department."' and role!='director' and (status!='disabled' and status!='resigned')");
while($row = mysql_fetch_array($result))
  {
    $r .= '<option value="'.$row['username'].'">' . $row['username'] ." ( ". $row['fname']. " ) ". '</option>';
  }
echo $r;
}
?>