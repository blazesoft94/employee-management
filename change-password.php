<?php
ob_start();
session_start();
include_once('includes/config.php');
$settings = mysql_fetch_array(mysql_query('Select * from settings'));
if((!isset($_SESSION['username'])) and (!isset($_SESSION['password'])))
{
	header("Location: $conf_path");
}
else
{
$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username = '%s'", mysql_real_escape_string($_SESSION['username']))));

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title'];?> - Change Password</title>

  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Plugin CSS -->
  <link rel="stylesheet" href="js/plugins/icheck/skins/minimal/blue.css">
  <link rel="stylesheet" href="js/plugins/select2/select2.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="css/target-admin.css">
  <link rel="stylesheet" href="css/custom.css">


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>

<body>

  <?php include_once("includes/users-top.php"); ?>

  <?php include_once("includes/users-menu.php"); ?>


<div class="container">

  <div class="content">

    <div class="content-container">

      

      <div class="content-header">
        <h2 class="content-header-title">Change Password</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>/index.php">Home</a></li>
          <li class="active">Change Password</li>
        </ol>
      </div> <!-- /.content-header -->
      

      

      <div class="row">

       




        <div class="col-sm-12">
         <div class="row">

            <div class="col-md-3 col-sm-5">

              <div class="thumbnail">
             <?php if(!empty($users['image']))
			 {?>
                  <img src="<?php echo $conf_path;?>/<?php echo $users['image'];?>" alt="<?php echo $users['username'];?>" />
                  <?php
			 }
			 else
			 {
				 ?>
                 <img src="http://www.gravatar.com/avatar/<?php echo md5($users['email_id']);?>?s=250&d=mm" alt="<?php echo $users['username'];?>" />
                 <?php
			 }?>
              </div> <!-- /.thumbnail -->

              <br />

              <div class="list-group">  

                <a href="<?php echo $conf_path;?>/my-profile.php" class="list-group-item">
                  <i class="fa fa-user"></i> &nbsp;&nbsp;My Profile 

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                </a> 

                <a href="<?php echo $conf_path;?>/edit-profile.php" class="list-group-item">
                  <i class="fa fa-book"></i> &nbsp;&nbsp;Edit Profile

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                 
                </a> 

                <a href="<?php echo $conf_path;?>/change-password.php" class="list-group-item">
                  <i class="fa fa-cog"></i> &nbsp;&nbsp;Change Password

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                </a> 

                <p class="list-group-item bg-success" style="background:#09c; border:1px solid #ccc; color:#f2f2f2">
                   &nbsp;&nbsp;<strong>Employee ID: <?php echo $users['employee_id'];?></strong>

                </p> 

               
              </div> <!-- /.list-group -->

            </div> <!-- /.col -->
         <div class="col-md-9 col-sm-7">
       
<?php
// PASSWORD CHANGE CHECKING CONDITION
if(isset($_POST['changepass']))
{
	$oldpass = md5(mysql_real_escape_string($_POST['old_Pass']));
	$newpass = md5(mysql_real_escape_string($_POST['new_pass']));
	$confirmpass = md5(mysql_real_escape_string($_POST['confirm_pass']));
	if($_SESSION['csrf'] == $_POST['token'])
	{
		if($oldpass == $_SESSION['password'])
		{
			if($newpass == $confirmpass)
			{
				$query = mysql_query(sprintf("update users set password='%s' where username = '%s'",$confirmpass,mysql_real_escape_string($_SESSION['username']))); 
				if($query)
				{
					$_SESSION['password'] = $confirmpass;
					?>
                    <div class="alert alert-success">
                    <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
                    <strong>Password </strong> Changed Successfully.. Try your new password to login 
     			</div>
                    <?php
				}
				else
				{
					echo mysql_error();
				}
			}
			else
			{
				?>
                <div class="alert alert-danger">
                    <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
                    <strong>Mismatch! </strong> of your New and Retype Password. 
     			</div>
                <?php
			}
		}
		else
		{
			?>
             <div class="alert alert-danger">
       			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		<strong>Oh snap! </strong>Your Old Password was wrong,
				 please enter your old password correct
     		</div>
            
            <?php
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
	
}



?> 
        
        

          <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-lock"></i>
                Change Password
              </h3>

            </div> <!-- /.portlet-header -->

            <div class="portlet-content">

              <form id="validate-basic" method="post" action="#" data-validate="parsley" class="form parsley-form">

                <div class="form-group">
                  <label for="Old Password">Old Password</label>
                  <input type="hidden" name="token" value="<?php echo $_SESSION['csrf']?>"/>
                  <input type="password" id="name" name="old_Pass" class="form-control" placeholder="Current Password" data-required="true" >
                </div>
                 <div class="form-group">
                  <label for="New Password">New Password</label>
                  <input type='password' id="user_password" data-minlength="4" data-maxlength="15" size="15" placeholder="Password must be between 4 to 15 alphanumeric characters." data-notblank="true" name="new_pass" class="form-control" data-required="true" >
                </div>
                 <div class="form-group">
                  <label for="retype password">Retype New Password</label>
                  <input type="password"  name="confirm_pass" id="user_password_confirmation" placeholder="Retype New password" class="form-control" data-equalto="#user_password" data-equalto-message="The password confirmation should match the New password" data-required="true" >
                </div>

                <div class="form-group">
                  <button type="submit" name="changepass" class="btn btn-success">Submit</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                   <button type="button" class="btn btn-default">Cancel</button>
                </div>

              </form>

            </div> <!-- /.portlet-content -->

          </div> <!-- /.portlet -->
          
          </div></div>
        </div> <!-- /.col -->

      </div> <!-- /.row -->


        

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>


  <script src="js/libs/jquery-1.10.1.min.js"></script>
  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
  
  <!-- Plugin JS -->
  <script src="js/plugins/parsley/parsley.js"></script>
  <script src="js/plugins/icheck/jquery.icheck.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  
</body>
</html>
<?php
}
?>
