<?php

ob_start();

session_start();

include_once("includes/config.php");

$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));

if(isset($_SESSION['username']) and isset($_SESSION['password']))

{

	header("location: $conf_path/welcome.php");

}

else

{

?>





<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  

 <title><?php echo $settings['title'];?> - Login</title>



  <meta charset="utf-8">

  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">



  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">

  <link rel="stylesheet" href="css/font-awesome.min.css">

  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">



    <!-- App CSS -->

  <link rel="stylesheet" href="css/target-admin.css">

  <link rel="stylesheet" href="css/custom.css">





  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

  <![endif]-->

</head>



<body class="account-bg" style="background:url(img/back.png); background-size:100%">







<div class="account-wrapper">



  <div class="account-logo">

    <img src="img/logo-login.png" alt="Techware Admin">

  </div>



    <div class="account-body">



      <h3 class="account-body-title">Pacific Audit Solutions</h3>



      <h5 class="account-body-subtitle">Created by <a target="_blank" href="https://blazeweb.herokuapp.com">BlazeWeb</a></h5>  

      <p style="color:#562f32"><?php echo "Today is " .date("Y-m-d h:i:sa"); ?></p>    



      <form class="form account-form" method="POST" data-validate="parsley">

      <?php

// LOGIN USER DETAILS CHECK

if(isset($_POST['login']))

{

	$select_white_ip = mysql_query('SELECT * FROM whitelist');

	$count_list = mysql_num_rows($select_white_ip);

	$ip = $_SERVER['REMOTE_ADDR'];

	if($count_list > 0) {

		$list_ip_chk = mysql_query("SELECT * FROM whitelist WHERE ip='".$ip."'");

		if(mysql_num_rows($list_ip_chk) == 1) {

			$_SESSION['truelog'] = "success";

		} else {

			$_SESSION['truelog'] = "failed";

		}

		

	} else {

		$_SESSION['truelog'] = "success";

	}

	

	if($_SESSION['truelog'] == "success") {

		if($_POST['token'] == $_SESSION['csrf'])

		{

			if(!empty($_POST['username']) and !empty($_POST['password']))

			{

				

				$username = mysql_real_escape_string(strtolower($_POST['username']));

				$password = md5(mysql_real_escape_string($_POST['password']));

				/*$strlen = strlen($password);

				if(($strlen >= 5) and ($strlen <=15))

				{*/

					$query = sprintf("SELECT * from users where (username = '%s' or email_id = '%s') and password = '%s' and role in ('admin','manager','Supervisor') ",$username,$username,$password);

					$query_result = mysql_query($query);

					if($query_result)

					{

						$count = mysql_num_rows($query_result);

						$user = mysql_fetch_array($query_result);

						if($count == 1)

						{

							// ALLOWED USERS ONLY ACTIVE AND NEW USERS

							$query1 = mysql_query(sprintf("Select * from users where (username = '%s' or email_id = '%s') and password = '%s' and (status='active' or status='newuser')",$username,$username,$password));

							if(mysql_num_rows($query1) == 1) {

								

								// AFTER 90 DAYS NEW USERS CHANGED TO ACTIVE USERS

								$query2 = mysql_query(sprintf("Select * from users where (username = '%s' or email_id = '%s') and password = '%s' and status='newuser'",$username,$username,$password));

								if(mysql_num_rows($query2) == 1) {

									$info = mysql_fetch_array($query2);

									$join_date = strtotime($info['join_date']);

									$now = strtotime(date('d-M-Y')); // or your date as well

     								$datediff = $now - $join_date;

    								$change = floor($datediff/(60*60*24));

									$today = date('d-M-Y');

									if($change > 90) {

										$query4 = mysql_query("INSERT INTO users_history (`user_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$info['idu']."','".$info['status']."','active','".$today."')");

										if($query4) {

											$query5 = mysql_query("UPDATE users SET status='active' WHERE idu='".$info['idu']."'");

										}

									}

								}

							$_SESSION['username'] = $user['username'];

							$_SESSION['password'] = $user['password'];

							$_SESSION['role'] = $user['role'];

							/* page permission granded */

							if($_SESSION['role'] != 'admin') {

								$permission = mysql_query("SELECT * FROM role as r INNER JOIN role_permission as rp ON r.r_id = rp.role_id WHERE r.rolename='".$_SESSION['role']."'");

								if(mysql_num_rows($permission) == 1 ) {

									$perm = mysql_fetch_array($permission);

									$str = rtrim($perm['page_id'],',');

									$_SESSION['permission'] = explode(',', $str);

								}

							}

							/* page permission granded */

							header("Location: $conf_path/welcome.php");

							} else {

								?>

							<div class="alert alert-danger">

								<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

								<strong>Oh snap!</strong> <br>

Login Access disabled temporary or permanent

							 </div>

							<?php

							}

							

						}

						else

						{

							?>

							<div class="alert alert-danger">

								<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

								<strong>Oh snap!</strong> Username and Password is wrong.

							 </div>

							<?php

						}

					}

					

					else

					{

						echo mysql_error();

					}

				/*}

				else

				{?>

			   <!-- <div class="alert alert-warning">

					<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

					<strong> Password </strong>must be between 5 to 15 alphanumeric characters.

				</div>-->

				<?php

					

				}*/

			}

		}

		else

		{

			?>

			<div class="alert alert-danger">

					<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

					<strong>Oh snap! </strong>Your entry was wrong.

			</div>

			<?php

		}

	} else {

		?>

        <div class="alert alert-danger">

					<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

					<strong>Invalid IP Address</strong>.

			</div>

        <?php

		

	}

}

# CSRF TOKEN PROCESS

$token = sha1(uniqid("allianzebpointernational", true));

$_SESSION['csrf'] = base64_encode( time() . md5($token));

# CSRF TOKEN PROCESS END



?>



        <div class="form-group">

          <label for="login-username" class="placeholder-hidden">Username</label>

          <input type="hidden" name="token" value="<?php echo $_SESSION['csrf']; ?>" />

          <input type="text" class="form-control" name="username" id="login-username" data-required="true"  placeholder="Username" tabindex="1">



        </div> <!-- /.form-group -->



        <div class="form-group">

          <label for="login-password" class="placeholder-hidden">Password</label>

          <input type="password" name="password" class="form-control" id="login-password" data-required="true"  placeholder="Password" tabindex="2">

        </div> <!-- /.form-group -->



        <div class="form-group clearfix">

          

      <div class="pull-right">

            <a href="<?php echo $conf_path;?>/forget-password.php">Forgot Password?</a>

          </div> 

        </div> <!-- /.form-group -->



        <div class="form-group">

          <button type="submit" name="login" class="btn btn-success btn-block btn-lg" tabindex="3">

            Sign In &nbsp; <i class="fa fa-play-circle"></i>

          </button>

        </div> <!-- /.form-group -->



      </form>

 <hr/>

   <p> Copyright &copy; 2018</p>



    </div> <!-- /.account-body -->

   



   



  </div> <!-- /.account-wrapper -->







        



 <!--<script src="js/libs/jquery-1.10.1.min.js"></script>-->

 <!-- AJAX RELOAD -->

<!--<script language="javascript" src="jquery-1.4.4.min.js"></script>-->

  

  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>

  <script src="js/libs/bootstrap.min.js"></script>



  <!--[if lt IE 9]>

  <script src="./js/libs/excanvas.compiled.js"></script>

  <![endif]-->

  

  <!-- Plugin JS -->

  <script src="js/plugins/parsley/parsley.js"></script>

  <script src="js/plugins/icheck/jquery.icheck.js"></script>

  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>

  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>

  <script src="js/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>

  <script src="js/plugins/select2/select2.js"></script>



  <!-- App JS -->

  <script src="js/target-admin.js"></script>

</body>

</html>

<?php

}

?>