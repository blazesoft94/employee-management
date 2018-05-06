<?php

ob_start();

session_start();

include_once("../includes/config.php");

include_once("../includes/function.php");

if(isset($_POST['reset_email']))

{

	 $settings = mysql_fetch_array(mysql_query("SELECT * from settings"));

	 $result = mysql_query("SELECT * FROM users WHERE email_id = '".$_POST['reset_email']."'");

	 $count = mysql_num_rows($result);

	 if($count == 1)

	 {

		 	$fetch = mysql_fetch_array($result);

			$salt = md5(mt_rand());

			$makeSalt = sprintf("UPDATE users SET salted = '%s' WHERE email_id = '%s'", mysql_real_escape_string($salt), mysql_real_escape_string($fetch['email_id']));

			$success = mysql_query($makeSalt);

			if($success)

			{

				// RECOVER MAIL SENDING FUNCTION

				recoverPass($fetch['email_id'],$settings['title'],$conf_path,$conf_mail,$fetch['username'], $salt);

				echo "<div class='alert alert-success'><i class='fa fa-envelope'></i> &nbsp;An automated email has been sent to your registered email address with the password reset instructions</div>";

			}

			else

			{

				echo "<div class='alert alert-danger'><i class='fa fa-envelope'></i> &nbsp;Error try again</div>";

			}

	 }

	 else

	 {

		 echo "<div class='alert alert-danger'><i class='fa fa-envelope'></i> &nbsp;Please enter registered mail id</div>";

	 }

}



?>