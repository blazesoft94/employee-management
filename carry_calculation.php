<?php
ob_start();
include_once("includes/config.php");
include_once("includes/function.php");

$day = date('d');
$date_check = date('Y-m-d H:i:s');
$prvious_date = date("Y-m", strtotime("-1 month"));
if($day == "01") {
	// set this code execute based on cron job
	// avoiding direct url to access the pages 
  $select = mysql_query("SELECT * FROM users where status='active'");
  if(mysql_num_rows($select) > 0 ) {
	  while($rows = mysql_fetch_array($select)) {
		  // carry allowed users
		  $mm = date("m", strtotime("-1 month"));
		  $y = date("Y", strtotime("-1 month"));
		  $tds = '0';
		  if($rows['leave_carry'] == 1) {
			  //carry update process
			  $info = mysql_fetch_array(mysql_query("SELECT * FROM carry_info WHERE user_id='".$rows['idu']."'"));
			  $cl = $info['carry_left'];
			  // leave management process 
			  $rowws = mysql_query("SELECT * FROM `leave_management` WHERE username='".$rows['username']."' and 	leave_from like '$mm/%%/$y' and status='1'");
			  if(mysql_num_rows($rowws) > 0 ) {
				  while($row = mysql_fetch_array($rowws)) {
					  $from = $row['leave_from'];
					  $to = $row['leave_to'];
					  $half_full = $row['half_full'];
					  /* day calculation */
					  $startTimeStamp = strtotime($from);
					  $endTimeStamp = strtotime($to);
					  $timeDiff = abs($endTimeStamp - $startTimeStamp);
					  $numberDays = $timeDiff/86400;  // 86400 seconds in one day
					  // and you might want to convert to integer
					  $numberDays = intval($numberDays);
					  if($half_full == "half") {
						  $tds += $numberDays + 0.5;
					  } else {
						  $tds += $numberDays+1;
					  }
				  }
			  }
			  // leave information update to database
			  $TLP = (2+$cl);
			  if($TLP < $tds) { 
			  	  $linfo =  abs($TLP-$tds);
			  	  // user carry info update details
				  $ULI = mysql_query("INSERT INTO user_leave_info (`user_id`,`carry_left`,`leave_taken`,`extra_leave`,`leave_month`,`updated_date`) VALUES ('".$rows['idu']."','".$cl."','".$tds."','".$linfo."','".$prvious_date."','".$date_check."')");
				  // carryleft to 0
				  $query = mysql_query("UPDATE `carry_info` SET `carry_left`='0' WHERE user_id='".$rows['idu']."' and status='1'");
				  
			  } else {
				   $linfo =  abs($TLP - $tds);
				  // user carry info update details
				  $ULI = mysql_query("INSERT INTO user_leave_info (`user_id`,`carry_left`,`leave_taken`,`extra_leave`,`leave_month`,`updated_date`) VALUES ('".$rows['idu']."','".$cl."','".$tds."','0','".$prvious_date."','".$date_check."')");
				  // carry left to remaining days
				  $query = mysql_query("UPDATE `carry_info` SET `carry_left`='".$linfo."' WHERE user_id='".$rows['idu']."' and status='1'");
			  }
			  
		  } else {
		  // carry not allowed users 
		  		$cl = 0;
				// leave management process 
				$rowws = mysql_query("SELECT * FROM `leave_management` WHERE username='".$rows['username']."' and 	leave_from like '$mm/%%/$y' and status='1'");
				if(mysql_num_rows($rowws) > 0 ) {
					while($row = mysql_fetch_array($rowws)) {
						$from = $row['leave_from'];
						$to = $row['leave_to'];
						$half_full = $row['half_full'];
						/* day calculation */
						$startTimeStamp = strtotime($from);
						$endTimeStamp = strtotime($to);
						$timeDiff = abs($endTimeStamp - $startTimeStamp);
						$numberDays = $timeDiff/86400;  // 86400 seconds in one day
						// and you might want to convert to integer
						$numberDays = intval($numberDays);
						if($half_full == "half") {
							$tds += $numberDays + 0.5;
						} else {
							$tds += $numberDays+1;
						}
					}
				}
				// leave information update to database
				$TLP = (2+$cl);
				if($TLP < $tds) { 
					$linfo =  abs($TLP-$tds);
					// user carry info update details
					$ULI = mysql_query("INSERT INTO user_leave_info (`user_id`,`carry_left`,`leave_taken`,`extra_leave`,`leave_month`,`updated_date`) VALUES ('".$rows['idu']."','".$cl."','".$tds."','".$linfo."','".$prvious_date."','".$date_check."')");
				} else {
					// user carry info update details
					$ULI = mysql_query("INSERT INTO user_leave_info (`user_id`,`carry_left`,`leave_taken`,`extra_leave`,`leave_month`,`updated_date`) VALUES ('".$rows['idu']."','".$cl."','".$tds."','0','".$prvious_date."','".$date_check."')");
				}
		  } // carry else part completed
		  
	  }
  }
} else {
	  echo "Code has a error";
}
?>