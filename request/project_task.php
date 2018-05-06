<?php
ob_start();
session_start();
include_once("../includes/config.php");

if(isset($_POST['q'])) {
$project = $_POST['q'];

$result = mysql_query("SELECT * FROM project_task_list WHERE project_name_id='".$project."'");
while($row = mysql_fetch_array($result))
  {
    $r .= '<option value="'.$row['pt_id'].'">' . $row['task_name'] . '</option>';
  }
echo $r;
}

if(isset($_POST['sq'])) {
$project = $_POST['sq'];

$result = mysql_query("SELECT * FROM project_task_list WHERE project_name_id='".$project."'");
$r = '<option value="">[ Any ]</option>';
while($row = mysql_fetch_array($result))
  {
    $r .= '<option value="'.$row['pt_id'].'">' . $row['task_name'] . '</option>';
  }
echo $r;
}
?>