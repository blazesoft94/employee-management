<?php

ob_start();

session_start();

include_once("includes/config.php");

include_once("includes/function.php");

$setting = mysql_fetch_array(mysql_query("select * from settings"));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $setting['title'];?> - Forget Password</title>



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

    <img src="img/logo-login.png" alt="Target Admin">

  </div>



    <div class="account-body">



<?php



if(isset($_GET['r'])) {

	?>

	 <h3 class="account-body-title">Password Set Field</h3>

     <h5 class="account-body-subtitle">Update New password</h5>

     <form class="form account-form" data-validate="parsley" method="POST" action="#">

     

<?php

if(isset($_POST['update_pass'])) {

	

	$pass1 = $_POST['pass1'];

	$pass2 = $_POST['pass2'];

	$username = $_GET['username'];

	$resetcode = $_GET['resetcode'];

	$select_query = mysql_query("Select * FROM 	users WHERE username='".$username."' and salted='".$resetcode."'");

	

	if(mysql_num_rows($select_query) == 1) {

		 if($pass1 == $pass2) {

			 $update_pass = mysql_query("UPDATE users SET password='".md5($pass2)."',salted='' WHERE username='".$username."' and salted='".$resetcode."'");

			 if($update_pass){ 

			 	// success msg

				?>

                 <div class="alert alert-danger">

        			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        			<strong>Password Change</strong> successfully.. login with new credentials

      			</div>

                <META http-equiv="refresh" content="5;URL=<?php echo $conf_path; ?>">

                <?php

			 } 

			 

		 } else {

			 // mismatch password

			 ?>

      <div class="alert alert-danger">

        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        <strong>Mismatch!</strong> New and Retype password

      </div>

             <?php

		 }

		

	} else {

		// wrong salted and password

		?>

         <div class="alert alert-danger">

        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        <strong>Wrong!</strong> Password reset code

      </div>

        <?php

		

	}

}





?>



     

     

		<div class="alert alert-danger forget_msg" style="display:none"></div>

        <div class="success_msg" style="display:none"></div>

       

        <div class="form-group">

          <label for="pass1" class="placeholder-hidden">New password</label>

          <input type="password" class="form-control" id="pass1" name="pass1" data-required="true" placeholder="New password" tabindex="1">

        </div> <!-- /.form-group -->

        

         <div class="form-group">

          <label for="pass2" class="placeholder-hidden">Retype password</label>

          <input type="password" class="form-control" id="pass2" data-required="true" data-parsley-equalto="#pass1" placeholder="Retype password" tabindex="1" name="pass2">

        </div> <!-- /.form-group -->



        <div class="form-group">

          <button type="submit" name="update_pass" id="update_pass" class="btn btn-success btn-block btn-lg" tabindex="2">

            Update Password &nbsp; <i class="fa fa-refresh"></i>

          </button>

        </div> <!-- /.form-group -->



        <div class="form-group">

          <a href="<?php echo $conf_path;?>"><i class="fa fa-angle-double-left"></i> &nbsp;Back to Login</a>

        </div> <!-- /.form-group -->

      </form>

     

	<?php

} else { ?>

      <h3 class="account-body-title">Password Reset</h3>



      <h5 class="account-body-subtitle">We'll email you instructions on how to reset your password.</h5>



      <form class="form account-form" method="POST" action="#">

		<div class="alert alert-danger forget_msg" style="display:none"></div>

        <div class="success_msg" style="display:none"></div>

       

        <div class="form-group">

          <label for="forgot-email" class="placeholder-hidden">Your Email</label>

          <input type="text" class="form-control" id="forgot-email" placeholder="Your Email" tabindex="1">

        </div> <!-- /.form-group -->



        <div class="form-group">

          <button type="button" name="reset_pass" id="reset_pass" class="btn btn-secondary btn-block btn-lg" tabindex="2">

            Reset Password &nbsp; <i class="fa fa-refresh"></i>

          </button>

        </div> <!-- /.form-group -->



        <div class="form-group">

          <a href="<?php echo $conf_path;?>"><i class="fa fa-angle-double-left"></i> &nbsp;Back to Login</a>

        </div> <!-- /.form-group -->

      </form>

      

 <?php } ?>     

  



    </div> <!-- /.account-body -->



  </div> <!-- /.account-wrapper -->



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script>

  function validateEmail($email) {

  	var emailReg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

 	 if( !emailReg.test( $email ) ) {

    return false;

  	} else {

   	 return true;

  	}

	}

  $(document).ready(function(){

	  $('#reset_pass').click(function(){

		var email = $('#forgot-email').val();

		if(email.replace(/\s+/g, '') == '')

		{

			$('.forget_msg').html('<i class="fa fa-envelope"></i> &nbsp;Please enter your email address');

			$('.forget_msg').slideToggle('300').delay('4000').fadeOut('slow');

		}

		else if( !validateEmail( email))

		 {

			$('.forget_msg').html('<i class="fa fa-envelope"></i> &nbsp;Please enter valid email address');

			$('.forget_msg').slideToggle('300').delay('4000').fadeOut('slow');

		 }

		 else

		 {

			 $.ajax({

				 type:"post",

				 data: { reset_email:email },

				 url:"request/forget-password.php",

				 cache:false,

				 crossDomain: true,

				 success: function(msg)

				 {
					

					 $('#forgot-email').val('');

					 $('.success_msg').html(msg);

					 $('.success_msg').slideToggle('300').delay('5000').fadeOut('slow');

				 },

				 error: function(msg,et)

				 {

					 alert(msg);

				 }

				 

				 

			 });

		 }

		  

	  });

  });

  </script>

  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>

  <script src="js/libs/bootstrap.min.js"></script>

  <script src="js/plugins/parsley/parsley.js"></script>

  <!--[if lt IE 9]>

  <script src="./js/libs/excanvas.compiled.js"></script>

  <![endif]-->

  <!-- App JS -->

  <script src="js/target-admin.js"></script>

  





  



</body>

</html>

