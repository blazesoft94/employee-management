<?php
ob_start();
include_once("includes/config.php");
include_once("includes/function.php");

/* 10.00am mailing function */
$current_date = date("d-M-Y");
$to = "hr@techware.co.in";
//$to = "ravi@techware.co.in";
$headers = 'From: Techware Eoffice  < eoffice@techware.co.in >';
$subject = "Absentees list";
$arr = array();
$list='';
$select = mysql_query("SELECT * FROM users where status='active' and role!='admin' ");

if(mysql_num_rows($select) != 0) {
	while($ss=mysql_fetch_array($select)) {
		$slct = mysql_query("SELECT * FROM attendance WHERE username = '".$ss['username']."' and signin_date='$current_date'");
			$results=mysql_fetch_array($slct);
			if(!$results) {
				$list.= $ss['username']." [".$ss['email_id']."]"."\n";
			} 
	}
	
}
if($list==''){ $list ="No Absentees Today";}
$msg = "Absentees list - $current_date
-------------------------------------
$list
-------------------------------------
by
Techware Eoffice";
mail($to, $subject, $msg,$headers);
?>