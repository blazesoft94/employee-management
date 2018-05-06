<?php

 /////////////////////////////// Signin Process ////////////////////////////

// NORMAL SIGNIN

 //  CORRECT SIGNIN SCRIPTS

 if(isset($_POST['c_signin']))

 {

	 $select_signin = mysql_query("SELECT * FROM attendance WHERE username ='".$_SESSION['username']."' and signin_date= '$date_now'");

	 $select_signin_fetch = mysql_num_rows($select_signin);

	if($select_signin_fetch == 1)

	{

		$success_logout = mysql_query("select * from attendance where username = '".$_SESSION['username']."' and signin_date = '$date_now'");

		$logout_refer = mysql_fetch_array($success_logout);

		?>

        <div class="alert alert-info" style="margin-left:15px; margin-right:16px;">

        <strong>Total Duraton : <?php echo $logout_refer['working_hours']; ?></strong> <br> Please Try tomorrow or use Custom Punchin.

      </div>

        <?php

	}

	else

	{

		 $signin_date = date("d-M-Y");

		 $signin_time = date("H:i");

			 if(isset($_POST['c_signin_remarks'])) {

				 $late_signin_note = $_POST['c_signin_remarks'];

			 } else {

				$late_signin_note = ''; 

			 }

			 $sel = mysql_query("select * from attendance where username='".$_SESSION['username']."' and signin_date='".$signin_date."'");

			 if($sel) {

				 

			/* login time grater than 9.15 check */	 

			$t1 = date("09:15");

			if($signin_time > $t1) {

				/* late punchin email */

				$email = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE username='".$_SESSION['username']."'" ));

				$headers = 'From: Techware Eoffice  <'.$conf_mail.'>' . "\r\n";

				$subject = "Late Punchin Mail";

				$msg = "Late Punchin Mail info

				------------------------------

				Username: ".$_SESSION['username']."

				punchin Time: $signin_time

				Late Reason: $late_signin_note

				------------------------------";

				// send email

				mail($hrmail,$subject,$msg,$headers);

			}

		 /* login time grater than 9.15 check */

		 

		 $query_signin = mysql_query(sprintf("INSERT INTO attendance  (`username`,`emp_id`,`signin_date`,`signin_time`,`signin_late_note`,`signout_time`,`signout_late_note`,`working_hours`, `pre_experience`,`status`,`punchin_type`,`punchout_type`,`custom_status`) VALUES ('%s','%s','%s','%s','%s','0','0','0','0','1','','','')", mysql_real_escape_string($_SESSION['username']),mysql_real_escape_string($users['emp_id']),mysql_real_escape_string($signin_date),mysql_real_escape_string($signin_time),mysql_real_escape_string($late_signin_note)));

			 }

		 if($query_signin)

		 {

			 echo "<script>alert('signin successfully');</script>";

			 header("location:attendance.php");

		 }

		 else

		 {

			 echo mysql_error();

		 }

	}

 }

 /////////////////////////////// Signout Process ////////////////////////////

 

 // CORRECT SIGNOUT PROCESS

 if(isset($_POST['c_signout']))

 {

	 $signout_time = date("H:i");

	 // WORKING HOUR CALCULATION

	 $query1 = mysql_fetch_array(mysql_query("SELECT * FROM attendance where username = '".$_SESSION['username']."' and signin_date = '$date_now'"));

	 $working_hours_update = strtotime($signout_time) - strtotime($query1['signin_time']);

	 // Seconds to time conversion

	 $working_hours_time = gmdate("H:i",$working_hours_update);

		  if(isset($_POST['c_signout_remarks']))

			 {

				 $late_signout_note = $_POST['c_signout_remarks'];

			 }

			 else

			 {

				$late_signout_note = ''; 

			 }

			 if($working_hours_time > "00:05") {

	 			$query2 = mysql_query(sprintf("UPDATE attendance set signout_time='%s', signout_late_note = '%s', working_hours ='%s', status = '0' where username = '%s' and signin_date = '$date_now'", 

	 			mysql_real_escape_string($signout_time),

				mysql_real_escape_string($late_signout_note),

				mysql_real_escape_string($working_hours_time),

				mysql_real_escape_string($_SESSION['username'])));

				if($query2) {

					  echo "<script>alert('signout successfully');</script>";

					  unset($_POST);

					  header("location:attendance.php");

				 } else {

					  echo mysql_error();

				 }

			 } 

			 

	 

 }

 ?>	