<?php
ob_start();
session_start();
include_once("../includes/config.php");

//$dept = $_POST['q'];
$a = '';
$dept = $_POST['q'];
foreach ($dept as $selectedOption) {
    //echo $selectedOption."\n";
	/*if($selectedOption = 'all') {
		$a .= "`department` like '%%' and";
	} else {*/
		$a .= "`department`='".$selectedOption."' or";
	/*}*/
	echo  $a;
}
$qq = "SELECT * FROM users WHERE $a role!='director' and (status!='disabled' and status!='resigned')";
	
$result = mysql_query($qq);
while($row = mysql_fetch_array($result)) {
			   
			 $r .=  '<option value="'.$row['username'].'">'.$row['fname']." ( ".$row['username']." ) ".'</option>';
}
//echo print_r($_POST['q']);
?>