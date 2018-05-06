<?php
ob_start();
session_start();
include_once("../includes/config.php");

$dept = $_POST['q'];
$a = '';
$deptname = explode(',',$dept); 
$i = 0;
$c = 'or';
foreach($deptname as $dpt) {
	if(++$i === count($deptname))
	{
		$c= ') and';
	}
	if($dpt == "all") {
		$a .= "department like '%%' $c ";
	} else { 
		$a .= "department='".$dpt."' $c"; 
	}
	//$i++;
}

//echo $a;
$qq = "SELECT * FROM users WHERE ( $a role!='director' and ( status!='disabled' and status!='resigned')";
//echo $qq;
$result = mysql_query($qq);
$r='';
while($row = mysql_fetch_array($result)) {
			   
			 $r .=  '<option value="'.$row['idu'].'">'.$row['fname']." ( ".$row['username']." ) ".'</option>';
}
echo $r;
?>