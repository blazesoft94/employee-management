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

	include_once("includes/permission.php"); 

	if(($_SESSION['role'] == 'admin') || ($permission == "access")) {

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Add Users</title>



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

  <link rel="stylesheet" href="js/plugins/datepicker/datepicker.css">

  <link rel="stylesheet" href="js/plugins/simplecolorpicker/jquery.simplecolorpicker.css">

  <link rel="stylesheet" href="js/plugins/timepicker/bootstrap-timepicker.css">

  <link rel="stylesheet" href="js/plugins/fileupload/bootstrap-fileupload.css">





  <!-- App CSS -->

  <link rel="stylesheet" href="css/target-admin.css">





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

        <h2 class="content-header-title">Add Users</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Add Users</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-user"></i> User Details</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form">

          

<?php

if(isset($_POST['add_users'])) {

	$username = preg_replace('/\s+/','',strtolower(mysql_real_escape_string($_POST['username'])));

	$email_id = mysql_real_escape_string($_POST['email_id']);

	$employee_id = mysql_real_escape_string($_POST['employee_id']);

	

	$fname = mysql_real_escape_string($_POST['fname']);

	$phone_num = mysql_real_escape_string($_POST['phone_num']);

	

	$gender = mysql_real_escape_string($_POST['radio-2']);

	$dob = mysql_real_escape_string(date('Y-m-d', strtotime($_POST['dob'])));

	$blood_group = mysql_real_escape_string($_POST['blood_group']);

	

	$qualification = mysql_real_escape_string($_POST['qualification']);

	$address = mysql_real_escape_string($_POST['address']);

	

	// office details
	$department = mysql_real_escape_string($_POST['department']);
	$designation = mysql_real_escape_string($_POST['designation']);
	$join_date = mysql_real_escape_string(date('Y-m-d H:i:s', strtotime($_POST['join_date'])));
	$shift_id = mysql_real_escape_string($_POST['shift_id']);
	$role = mysql_real_escape_string($_POST['role']);
	$ustatus = mysql_real_escape_string($_POST['ustatus']);
	$cleave = mysql_real_escape_string($_POST['cleave']);
	$emp_id = $_POST['emp_id'];
	
	// BANK INFORMATION
	$bank_name = mysql_real_escape_string($_POST['bank_name']);
	$branch = mysql_real_escape_string($_POST['branch']);
	$beneficiary_name = mysql_real_escape_string($_POST['beneficiary_name']);
	$acc_num = mysql_real_escape_string($_POST['acc_num']);
	$ifsc_code = mysql_real_escape_string($_POST['ifsc_code']);
	
	// EXPERIENCE INFO
	$experience = mysql_real_escape_string(date('Y-m-d',strtotime($_POST['experience'])));

	$select = mysql_query("SELECT * FROM users WHERE username='".$username."'");

	if(mysql_num_rows($select) == 0)  {

		// username checked successfully

		if(!empty($username) || !empty($email_id) || !empty($employee_id) || !empty($fname) ||  !empty($phone_num) || !empty($gender) || !empty($dob) || !empty($blood_group) || !empty($qualification) || !empty($department) || !empty($designation) || !empty($join_date) || !empty($shift_id) || !empty($role) || !empty($ustatus))  {

			/* image upload check and filter */

		if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {

		$insert = mysql_query("INSERT INTO users (`username`,`password`,`email_id`,`fname`,`sex`,`employee_id`,`phone_num`,`blood_group`,`dob`,`salted`,`department`,`designation`,`qualification`,`join_date`,`address`,`image`,`emp_id`,`shift_id`,`role`,`status`,`resigned_date`,`leave_carry`,`bank_name`,`branch`,`beneficiary_name`,`acc_num`,`ifsc_code`,`experience`) VALUES 	('".$username."','".md5($username)."','".$email_id."','".$fname."','".$gender."','".$employee_id."','".$phone_num."','".$blood_group."','".$dob."','','".$department."','".$designation."','".$qualification."','".$join_date."','".$address."','','".$emp_id."','".$shift_id."','".$role."','".$ustatus."','','".$cleave."','".$bank_name."','".$branch."','".$beneficiary_name."','".$acc_num."','".$ifsc_code."','".$experience."')");

		if($insert) {

		$inser_id = mysql_insert_id();

		$today = date('d-M-Y');

		$update_history = mysql_query("INSERT INTO users_history (`user_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$inser_id."','','".$ustatus."','".$today."')");

		if($cleave == "1") { 

		$datetime = date('Y-m-d H:i:s');

		$update_carry = mysql_query("INSERT INTO carry_info (`user_id`,`carry_left`,`status`,`edited_by`,`edited_date`) VALUES ('".$inser_id."','','1','".$_SESSION['username']."','".$datetime."')");

		}

		?>

        <div class="alert alert-success">

        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        <strong>User added</strong> successfully.<br><br>



		<button class="btn btn-danger" onClick="location.href='users-list.php?userid=<?php echo base64_encode(base64_encode($inser_id)); ?>'">User Info check</button>

      </div>

        <?php

		} else {

			echo mysql_error();

		}

		} else {

			/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */

				$max_file_size = 1024*1024; // 1024kb

				$valid_exts = array('jpeg', 'jpg', 'png', 'gif');

				if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {

					if( $_FILES['image']['size'] < $max_file_size ){

						// get file extension

						$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

						if (in_array($ext, $valid_exts)) {

							/* resize image */

							/*foreach ($sizes as $w => $h) {

								$files = resize_thoughts($w, $h);

							}*/

							/*list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

							$path = resize_thoughts($w,$h);*/

							$path = resize_profile(250,250);

							$insert = mysql_query("INSERT INTO users (`username`,`password`,`email_id`,`fname`,`sex`,`employee_id`,`phone_num`,`blood_group`,`dob`,`salted`,`department`,`designation`,`qualification`,`join_date`,`address`,`image`,`emp_id`,`shift_id`,`role`,`status`,`resigned_date`,`leave_carry`,`bank_name`,`branch`,`beneficiary_name`,`acc_num`,`ifsc_code`,`experience`) VALUES 	('".$username."','".md5($username)."','".$email_id."','".$fname."','".$gender."','".$employee_id."','".$phone_num."','".$blood_group."','".$dob."','','".$department."','".$designation."','".$qualification."','".$join_date."','".$address."','".$path."','".$emp_id."','".$shift_id."','".$role."','".$ustatus."','','".$cleave."','".$bank_name."','".$branch."','".$beneficiary_name."','".$acc_num."','".$ifsc_code."','".$experience."')");

							if($insert) {

								$inser_id = mysql_insert_id();

								$today = date('d-M-Y');

								$update_history = mysql_query("INSERT INTO users_history (`user_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$inser_id."','','".$ustatus."','".$today."')");

								if($cleave == "1") { 

									$datetime = date('Y-m-d H:i:s');

									$update_carry = mysql_query("INSERT INTO carry_info (`user_id`,`carry_left`,`status`,`edited_by`,`edited_date`) VALUES ('".$inser_id."','0','1','".$_SESSION['username']."','".$datetime."')");

								}

		?>

        <div class="alert alert-success">

        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        <strong>Added User</strong> successfully your list.<br><br>



		<button class="btn btn-danger" onClick="location.href='users-list.php?userid=<?php echo base64_encode(base64_encode($inser_id)); ?>'">User Info check</button>

      </div>

        <?php

		} else {

			echo mysql_error();

		}

						} else {

							echo '<div class="alert alert-warning">

							<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

							<i class="fa fa-envelope"></i>&nbsp; Unsupported file

						</div>';

						}

					} else{

						echo '<div class="alert alert-warning">

							<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

							<i class="fa fa-envelope"></i>&nbsp; Please upload image smaller than 400KB

						</div>';

					}

				}

				/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */

		}

		

		} else {

			// please filled all fields

			?>

			<div class="alert alert-danger">

        	<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        	<strong>Please fill all the fields</strong>

			</div>

            <?php

		}

		

	} else {

		// username already there

		?>

        <div class="alert alert-danger">

        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        <strong>Username</strong> already inserted.

		</div>

        <?php

	}

	

	

	

	

}

?>         

  <h3>Personal Info </h3>

          <hr/> 

          <div class="col-md-8">

        

			<div class="col-md-6">

                 <div class="form-group">

                  <label for="name">Username: <em class="red-col">*</em></label>

                  <input type="text" id="username" name="username" class="form-control" data-required="true" >

                </div>

            </div>

            <div class="col-md-6">    

                <div class="form-group">

                  <label for="name">Email ID: <em class="red-col">*</em></label>

                  <input type="email" id="email_id" name="email_id" class="form-control" data-required="true" >

                </div>

             </div>

            

            

            <div class="col-md-6">

                 <div class="form-group">

                  <label for="fname">Name: <em class="red-col">*</em></label>

                  <input type="text" id="fname" name="fname" class="form-control" data-required="true" >

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                  <label for="phone_num">Phone Number: <em class="red-col">*</em></label>

                  <input type="text" id="phone_num" name="phone_num" class="form-control" data-required="true" >

                </div>

            </div>

             <div class="col-md-6">

                <div class="form-group">

                  <label for="name">Employee ID: <em class="red-col">*</em></label>

<?php 

$chek_info = mysql_query("SELECT * FROM users  order by emp_id DESC LIMIT 1");

if(mysql_num_rows($chek_info) == 0) {

	$emp_id = "TW-100";

} else {

	$ff = mysql_fetch_array($chek_info);

	$ss = $ff['emp_id'] + 1;

	$emp_id = "TW-".$ss;

}



?>                  

                  

                  <input type="text" id="employee_id" name="employee_id" value="<?php echo $emp_id; ?>" readonly class="form-control" >

                  <input type="hidden" name="emp_id" value="<?php echo $ss; ?>"/>

                </div>

            </div>

            

            

           </div>

            

            <div class="col-md-4">

            <div class="fileupload fileupload-new" data-provides="fileupload">

                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Placeholder" /></div>

                  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                  <div>

                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="image" /></span>

                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                  </div>

              </div> <!-- /.col -->

            

            </div>

            

            

<div class="col-md-12">

 <div class="col-md-12">

                <div class="form-group">

                  <label for="phone_num">Gender: <em class="red-col">*</em></label>

                <div class="col-md-12">

                

                  </div>

                  <div class="col-md-2">

                      <div class="radio">

                        <label>

                          <input type="radio" name="radio-2" value="Male" class="icheck-input" checked>

                          Male

                        </label>

                      </div>

                  </div>

                  <div class="col-md-2">

                      <div class="radio">

                        <label>

                          <input type="radio" name="radio-2" class="icheck-input" value="Female">

                          Female

                        </label>

                      </div>

                  </div>

                 

                </div>

            </div> 

			<div class="col-md-4">

                 <div class="form-group">

                  <label for="dob">Date of Birth(DOB): <em class="red-col">*</em></label>

                  <div class="input-group date ui-datepicker">

                      <input id="dob" name="dob" class="form-control" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

            </div>

            <div class="col-md-4">    

                <div class="form-group">

                  <label for="blood_group">Blood Group: <em class="red-col">*</em></label>

                  <select id="blood_group" name="blood_group" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <option value="O negative">O−</option>

                    <option value="O positive">O+</option>

                    <option value="A negative">A−</option>

                    <option value="A positive">A+</option>

                    <option value="B negative">B−</option>

                    <option value="B positive">B+</option>

                    <option value="AB negative">AB-</option>

                    <option value="AB positive">AB+</option>

                  </select>

                </div>

             </div>

             <div class="col-md-4">

                 <div class="form-group">

                  <label for="qualification">Qualification: <em class="red-col">*</em> </label>

                 <input type="text" id="qualification" name="qualification" class="form-control" data-required="true" >

                </div>

            </div>

             

         </div> 



		<div class="col-md-12">

             <div class="col-md-6">

              <div class="form-group">

                      <label for="address">Address Info: <em class="red-col">*</em></label>

                      <textarea data-required="true" data-minlength="5" name="address" id="textarea-input" cols="10" rows="2" class="form-control"></textarea>

                    </div>

             </div>

             <div class="col-md-6">

             </div>

         </div>

         <div class="col-md-12">

         <h3>Office Info </h3>

         <hr/>

         <div class="col-md-4">

                 <div class="form-group">

                  <label for="department">Department: <em class="red-col">*</em></label>

                  <select id="department" name="department" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <?php $department = mysql_query("SELECT * FROM department Group By department_name");

					while($dpt = mysql_fetch_array($department)) {

						?>

                    <option value="<?php echo $dpt['department_name']; ?>"><?php echo $dpt['department_name']; ?></option>

                     <?php } ?>

                  </select>

                  

                </div>

            </div>

            <div class="col-md-4">    

                <div class="form-group">

                  <label for="designation">Designation: <em class="red-col">*</em></label>

                  

                   <select id="designation" name="designation" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <?php $des = mysql_query("SELECT * FROM department Group By designation");

					while($designation = mysql_fetch_array($des)) {

						?>

                    <option value="<?php echo $designation['designation']; ?>"><?php echo $designation['designation']; ?></option>

                     <?php } ?>

                  </select>

                 

                </div>

             </div>

            <div class="col-md-4">

                <div class="form-group">

                  <label for="join_date">Join Date: <em class="red-col">*</em></label>

                   <div class="input-group date ui-datepicker">

                      <input id="join_date" name="join_date" class="form-control" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

            </div>

            

            

           <div class="col-md-4">

                 <div class="form-group">

                  <label for="shift_id">Shift No: <em class="red-col">*</em></label>

                  <select id="shift_id" name="shift_id" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                     <?php $shf = mysql_query("SELECT * FROM shift_time");

					while($st = mysql_fetch_array($shf)) {

						?>

                    <option value="<?php echo $st['shift_no']; ?>"><?php echo $st['shift_no']."- (".$st['shift_start_time']." - ".$st['shift_end_time'].")"; ?></option>

                     <?php } ?>

                  </select>

                 

                </div>

            </div>

            <div class="col-md-4">    

                <div class="form-group">

                  <label for="role">Role: <em class="red-col">*</em></label>

                  <select id="role" name="role" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <?php $dr = mysql_query("SELECT * FROM `role`");

					if(mysql_num_rows($dr) > 0) {

					while($row = mysql_fetch_array($dr)) {

						if($_SESSION['role'] == 'admin') {

						?>

                        <option value="<?php echo $row['rolename']; ?>">[ <?php echo $row['rolename']; ?> ]</option>

                        <?php

						} else {

							if( $row['rolename'] != "admin") {

							?>

                         <option value="<?php echo $row['rolename']; ?>">[ <?php echo $row['rolename']; ?> ]</option>

                            <?php

							}

						}

					}

					}

				?>

                  </select>

                </div>

             </div>

             

             <div class="col-md-4">    

                <div class="form-group">

                  <label for="role">Status: <em class="red-col">*</em></label>

                  <select id="role" name="ustatus" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <option value="newuser">New user</option>

                    <option value="active">Active</option>

                     <option value="inactive">Inactive</option>

                    <option value="resigned">Resigned</option>

                  </select>

                </div>

             </div>

             

               <div class="col-md-4">    

                <div class="form-group">

                  <label for="Leave">Leave Carry: <em class="red-col">*</em></label>

                  <select id="Leave" name="cleave" class="form-control" data-required="true">

                    <option value="0" selected>[ NO ]</option>

                    <option value="1">[ YES ]</option>

                  </select>

                </div>

             </div> 
             
              <!-- ADDITIONAL FIELDS -->
              <div class="col-md-4">    
                <div class="form-group">
                <label for="Leave">Appointed Date:</label>
                 <div class="input-group date ui-datepicker">

                      <input id="experience" name="experience" class="form-control" type="text">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>
                </div>
              </div>
              
              

		</div>
        
        <div class="col-md-12 alert-messagess">
         <h3>Bank Information <span>Not Sharable</span></h3>
         <hr/>
         <div class="col-md-4">
                 <div class="form-group">
                  <label for="Bank Name">Bank Name: </label>
                  <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name" />
                  
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="Branch">Branch:</label>
                  <input type="text" name="branch" class="form-control" placeholder="Enter Branch Name" />
                </div>
            </div>
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Beneficiary Name">Beneficiary Name: </label>
                  <input type="text" name="beneficiary_name" class="form-control" placeholder="Enter Beneficiary Name" />
                </div>
             </div>
            
            
            
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Account Number">Account Number: </label>
                  <input type="text" name="acc_num" class="form-control" placeholder="Enter Account Number" />
                </div>
             </div>
             
             
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Account Number">IFSC Code: </label>
                  <input type="text" name="ifsc_code" class="form-control" placeholder="Enter IFSC Code" />
                </div>
             </div>
		</div>
      
        <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" name="add_users" class="btn btn-success"><i class="fa fa-user"></i> Add Users <i class="fa fa-arrow-right"></i></button>
                </div>
          </div>

              </form>

   

  

              

        </div>  <!--  /.portlet-content -->

     </div> <!-- /.portlet -->    

             



        

   </div> <!-- /.col -->



      </div> <!-- /.row -->



    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<?php include_once("includes/footer.php"); ?>



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script type="text/javascript">

$(document).ready(function() {

//keyup function
$('#phone_num').keypress(function(event){
 console.log(event.which);
 if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
    event.preventDefault();
 }
});
	
	// DEPARTMENT AND DESIGNATION PART
	$("#department").change(function() {
		var id=btoa($(this).val());
		var dataString = 'q='+ id;
		$.ajax({
			type: "POST",
			url: "request/user_designation.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#designation").html(html);
			}
		});
	});
	
	

  $(".hidecontent").hide();

  //toggle the componenet with class msg_body

  $(".heading-hide").click(function()

  {

    $(this).next(".hidecontent").slideToggle(1000);

  });

});

</script>

  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>

  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>

  <script src="./js/libs/excanvas.compiled.js"></script>

  <![endif]-->

  <!-- Plugin JS -->

  <script src="js/plugins/icheck/jquery.icheck.js"></script>

  <script src="js/plugins/select2/select2.js"></script>

   <script src="js/plugins/parsley/parsley.js"></script>

  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>

  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>

  <script src="js/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>

  <script src="js/plugins/autosize/jquery.autosize.min.js"></script>

  <script src="js/plugins/textarea-counter/jquery.textarea-counter.js"></script>

  <script src="js/plugins/fileupload/bootstrap-fileupload.js"></script>

  

   <!-- Plugin JS -->

  <script src="./js/plugins/datatables/jquery.dataTables.min.js"></script>

  <script src="./js/plugins/datatables/DT_bootstrap.js"></script>



  <!-- App JS -->

  <script src="js/target-admin.js"></script>

  

  <!-- Plugin JS -->

  <script src="js/demos/form-extended.js"></script>

    <script src="js/demos/form-validation.js"></script>



</body>

</html>

<?php

} else {

	header("Location: welcome.php"); 

}

}

?>

