<?php
ob_start();
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));
if(!(isset($_SESSION['username'])) and !(isset($_SESSION['password'])))
{
	header("Location: $conf_path/");
}
else
{
	// VALUE ARE STORED USING POST METHODS
	if(isset($_POST['submit']))
	{
		if($_SESSION['csrf'] == $_POST['token'])
		{
			if((!empty($_POST['fname'])) and (!empty($_POST['gender'])) and (!empty($_POST['email'])) and (!empty($_POST['address'])) and (!empty($_POST['qualification'])) and (!empty($_POST['phone'])))
			{
				$dob = date('d-M-Y', strtotime($_POST['dob']));
				$query = sprintf("Update `users` SET fname = '%s', sex = '%s', email_id = '%s', address = '%s', phone_num = '%s', qualification = '%s', blood_group = '%s' where username = '%s'",
					mysql_real_escape_string(htmlspecialchars($_POST['fname'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['gender'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['email'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['address'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['phone'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['qualification'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					mysql_real_escape_string(htmlspecialchars($_POST['blood_group'],ENT_QUOTES | ENT_IGNORE, "UTF-8")),
					
					mysql_real_escape_string($_SESSION['username']));
				
				$result_query = mysql_query($query);
				if($result_query)
				{
					header("Location: $conf_path/edit-profile.php?msg=success");
				}
				else
				{
					echo mysql_error();
				}
			}
			else
			{
				header("Location: $conf_path/edit-profile.php?msg=mandatatory");
			}
		}
		else
		{
			header("Location: $conf_path/edit-profile.php?msg=invalid");
		}
	}
/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */
$max_file_size = 1024*400; // 200kb
$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
// thumbnail sizes
$sizes = array(250 => 250);

if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {
	if( $_FILES['image']['size'] < $max_file_size ){
		// get file extension
		$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		if (in_array($ext, $valid_exts)) {
			/* resize image */
			foreach ($sizes as $w => $h) {
				$files[] = resize($w, $h);
			}
			$msg = '<div class="alert alert-success">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Upload image successfully
		</div>';

		} else {
			$msg = '<div class="alert alert-warning">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Unsupported file
		</div>';
		}
	} else{
		$msg = '<div class="alert alert-warning">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Please upload image smaller than 400KB
		</div>';
	}
}
/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
# CSRF TOKEN PROCESS
$token = sha1(uniqid($_SESSION['username'], true));
$_SESSION['csrf'] = base64_encode( time() . md5($token));
# CSRF TOKEN PROCESS END
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Profile</title>

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
  <link rel="stylesheet" href="js/plugins/datepicker/datepicker.css">
  <link rel="stylesheet" href="js/plugins/select2/select2.css">
  <link rel="stylesheet" href="js/plugins/simplecolorpicker/jquery.simplecolorpicker.css">
  <link rel="stylesheet" href="js/plugins/timepicker/bootstrap-timepicker.css">
  <link rel="stylesheet" href="js/plugins/fileupload/bootstrap-fileupload.css">

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
        <h2 class="content-header-title">Edit Profile</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>/index.php">Home</a></li>
          <li class="active">Edit Profile</li>
        </ol>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-md-12">

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
                 <img src="<?php echo $conf_path;?>/uploads/avatar.png" alt="<?php echo $users['username'];?>" />
                 <?php
			 }?>
              </div> <!-- /.thumbnail -->
              <?php if(isset($msg)): ?>
			<?php echo $msg ?>
		<?php endif ?>
         <div class="fileupload fileupload-new text-center" data-provides="fileupload">
         <form action="" method="post" enctype="multipart/form-data">
         <input type="submit" value="Upload" class="btn btn-success" />
                <span class="btn btn-default btn-file">
                    <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="image" accept="image/*" />
                </span>
                <br/>
                <span class="fileupload-preview"></span>
  <button type="button" class="close fileupload-exists" data-dismiss="fileupload" style="float:none">&times;</button>
  
		</form>
              </div>
        
			
			

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

              <h2><?php echo $users['username'];?></h2>

              <h4><?php echo $users['designation'];?> / <?php echo $users['department'];?></h4>
               <button data-icon="fa fa-check-square-o" style=" height:45px; cursor:default" data-type="success" class="btn btn-success howler"><strong>Join Date:</strong> <?php echo date('Y-m-d',strtotime($users['join_date']));?></button>
               <hr/>
            


<?php
// MESSAGE PART
if(isset($_GET['msg']))
{
	if($_GET['msg'] == 'success')
	{
		?>
        <div class="alert alert-success">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; <strong> Profile updated successfully</strong>
		</div>
        <?php
	}
	if($_GET['msg'] == 'mandatatory')
	{
		?>
        <div class="alert alert-warning">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Please fill mandatatory fields
		</div>
        <?php
	}
	if($_GET['msg'] == 'invalid')
	{
		?>
         <div class="alert alert-danger">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; <strong> Invalid format</strong> please try aganin.
		</div>
        <?php
	}
}


?>
 
             
<!-- EDIT PROFILE -->
<div class="well">
                  <strong><em class="red-col">* Required Fields</em></strong> 

          </div>

 <div class="portlet">
 
		

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
                Edit Profile
              </h3>

            </div> <!-- /.portlet-header -->

            <div class="portlet-content">

              <form id="validate-basic" action="#" method="post" data-validate="parsley" class="form parsley-form">
				<input type="hidden" name="token" value="<?php echo $_SESSION['csrf'];?>"/>
                <div class="form-group">
                  <label for="fname">Name: <em class="red-col">*</em></label>
                  <input type="text" id="fname" name="fname" class="form-control" value="<?php echo $users['fname'];?>" placeholder="Enter your name" data-required="true" >
                </div>
                
                 <div class="form-group">
                  <label>Gender: <em class="red-col">*</em></label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" value="Male" <?php if(($users['sex'] == "Male") || empty($users['sex'])){ echo "checked";}?> class="">
                      Male
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" value="Female" <?php if($users['sex'] == "Female"){ echo "checked";}?> class="">
                      Female
                    </label>
                  </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                  <label for="date-2">DOB (date of birth) : <em class="red-col">not editable</em></label>

                  <div class="input-group date ui-datepicker">
                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input id="date-2" name="dob" disabled value="<?php echo date('m/d/Y', strtotime($users['dob']));?>" class="form-control" placeholder="Enter your date of birth" type="text" data-required="true">
                     
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="email">Email: <em class="red-col">*</em></label>
                  <input type="email" id="email" name="email" value="<?php echo $users['email_id'];?>" placeholder="Enter your email address" class="form-control" data-required="true" >
                </div>
                
                  <div class="form-group">
                  <label for="address">Address: <em class="red-col">*</em></label>
                  <textarea name="address" id="address" cols="10" rows="2" data-required="true"  placeholder="Enter your address" class="form-control"><?php echo $users['address'];?></textarea>
                </div>
                
                 <div class="form-group">
                  <label for="Qualification">Qualification: <em class="red-col">*</em></label>
                  <input type="text" id="qualification" value="<?php echo $users['qualification'];?>" name="qualification" placeholder="Enter your qualification details" class="form-control" data-required="true" >
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number: <em class="red-col">*</em></label>
                  <input type="tel" id="phone" name="phone" value="<?php echo $users['phone_num'];?>" class="form-control" placeholder="Enter your phone number" data-required="true" >
                </div>

                <div class="form-group">  
                  <label for="validateSelect">Blood Group: </label>
                  <select id="blood_group" name="blood_group" class="form-control">
                    <option value="">Please Select</option>
                    <option value="O negative"  <?php if($users['blood_group'] == 'O negative') { echo "selected"; }?>>O−</option>
                    <option value="O positive" <?php if($users['blood_group'] == 'O positive') { echo "selected"; }?>>O+</option>
                    <option value="A negative" <?php if($users['blood_group'] == 'A negative') { echo "selected"; }?>>A−</option>
                    <option value="A positive" <?php if($users['blood_group'] == 'A positive') { echo "selected"; }?>>A+</option>
                    <option value="B negative" <?php if($users['blood_group'] == 'B negative') { echo "selected"; }?>>B−</option>
                    <option value="B positive" <?php if($users['blood_group'] == 'B positive') { echo "selected"; }?>>B+</option>
                    <option value="AB negative" <?php if($users['blood_group'] == 'AB negative') { echo "selected"; }?>>AB-</option>
                    <option value="AB positive" <?php if($users['blood_group'] == 'AB positive') { echo "selected"; }?>>AB+</option>
                  </select>
                </div>
                
                
              
               

             <hr/>


                <div class="form-group">

               
                 <button class="btn btn-success" name="submit" type="submit">Submit</button>
                 <button class="btn btn-danger" type="reset">Reset</button>
                </div>

              </form>

            </div> <!-- /.portlet-content -->

          </div> <!-- /.portlet -->
<!-- // EDIT PROFILE END -->         
          
          
          
          


      

            </div> <!-- /.col -->

          </div> <!-- /.row -->

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
  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>
  <script src="js/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>
  <script src="js/plugins/select2/select2.js"></script>
  <script src="js/plugins/fileupload/bootstrap-fileupload.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>



  
</body>
</html>
<?php
}
?>
