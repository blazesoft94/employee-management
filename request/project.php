<?php
ob_start();
session_start();
include_once("../includes/config.php");

$username = $_POST['q'];

$result = mysql_query("SELECT * FROM project_assignment WHERE username='".$username."'");
//echo mysql_num_rows($result);
/*$r = ' <label for="project_name">Select Project: </label>
		<select name="project_name" id="project_name" class="form-control select2-input" data-required="true">*/
	$r = '<option value="">All</option>';
while($row = mysql_fetch_array($result))
  {
	  $row1 = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$row['project_name_id']."'"));
    $r .= '<option value="'.$row['project_name_id'].'">' . $row1['project_name'] . "</option>";
  }
//  $r .= "</select>";
echo $r;
?>