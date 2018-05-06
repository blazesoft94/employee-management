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

	// include_once("includes/permission.php"); 

	if(($_SESSION['role'] == 'manager') || ($_SESSION['role'] == 'admin') || ($permission == "access")) {

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Edit Users</title>



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

        <h2 class="content-header-title">Edit Users</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Edit Users details</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          

<?php

if(isset($_GET['editinfo'])) {

	$u_edit = base64_decode(base64_decode($_GET['editinfo']));

	

?>





    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-user"></i> Edit User Details</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form">

<?php

if(isset($_POST['edit_users'])) {

	$res = '';

	$email_id = mysql_real_escape_string($_POST['email_id']);

	

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

	/*$join_date = mysql_real_escape_string($_POST['join_date']);*/

	$shift_id = mysql_real_escape_string($_POST['shift_id']);

	$ustatus = mysql_real_escape_string($_POST['ustatus']);

	$role = mysql_real_escape_string($_POST['role']);

	$cleave = mysql_real_escape_string($_POST['cleave']);
	
	// BANK INFORMATION
	$bank_name = mysql_real_escape_string($_POST['bank_name']);
	$branch = mysql_real_escape_string($_POST['branch']);
	$beneficiary_name = mysql_real_escape_string($_POST['beneficiary_name']);
	$acc_num = mysql_real_escape_string($_POST['acc_num']);
	$ifsc_code = mysql_real_escape_string($_POST['ifsc_code']);
	
	// EXPERIENCE INFO
	$experience = mysql_real_escape_string(date('Y-m-d',strtotime($_POST['experience'])));

	if($ustatus == 'resigned') {

		$res = date('Y-m-d H:i:s', strtotime(date("d-M-Y")));

	}



		// username checked successfully

	if(!empty($email_id) || !empty($fname) ||  !empty($phone_num) || !empty($gender) || !empty($dob) || !empty($blood_group) || !empty($qualification) || !empty($department) || !empty($designation) || !empty($join_date) || !empty($shift_id) || !empty($role) || !empty($ustatus)) {

		$query_info = mysql_fetch_array(mysql_query("SELECT * FROM users where idu='".$u_edit."'"));

		

		if($query_info['status'] != $ustatus) {

		 $today = date('d-M-Y');

		 $history_manage = mysql_query("INSERT INTO users_history (`user_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$u_edit."','".$query_info['status']."','".$ustatus."','".$today."')");

		}

		

		/* CARRY INFO */

		$uls = mysql_query("SELECT * FROM carry_info where user_id='".$u_edit."'");

		$datetime = date('Y-m-d H:i:s');

		if(mysql_num_rows($uls) == 1) {

			// update

			$dtl = mysql_fetch_array($uls);

			if($query_info['leave_carry'] != $cleave) {

				$update = mysql_query("UPDATE carry_info SET `status`='".$cleave."', `edited_by`='".$_SESSION['username']."',`edited_date` = '".$datetime."' WHERE c_id='".$dtl['c_id']."'");

			}

		} else {

			/// insert

			if($query_info['leave_carry'] != $cleave) {

				$insert_carry = mysql_query("INSERT INTO carry_info (`user_id`,`carry_left`,`status`,`edited_by`,`edited_date`) VALUES ('".$u_edit."','0','".$cleave."','".$_SESSION['username']."','".$datetime."')");

			}

		}

		/* CARRY INFO */

		

		

		if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {

			

		$update = mysql_query(sprintf("UPDATE users SET `email_id`='%s',`fname`='%s',`sex`='%s',`phone_num`='%s',`blood_group`='%s',`dob`='%s',`department`='%s',`designation`='%s',`qualification`='%s',`join_date`='%s',`address`='%s',`shift_id`='%s',`role`='%s',`status`='%s', `resigned_date`='%s',`leave_carry`='%s',`bank_name`='%s', `branch`='%s', `beneficiary_name`='%s', `acc_num`='%s', `ifsc_code`='%s' ,`experience`='%s' WHERE idu='%s'",

		$email_id,$fname,$gender,$phone_num,$blood_group,$dob,$department,$designation,$qualification,$join_date,$address,$shift_id,$role, $ustatus,$res,$cleave,$bank_name,$branch,$beneficiary_name,$acc_num,$ifsc_code,$experience,$u_edit));

		if($update) {?>

          	<div class="alert alert-success">

        	<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        	<strong>User edited succesfully</strong>

			</div>

                <?php

		} else { echo mysql_error(); }

		

		} else { 

		 /* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */

				$max_file_size = 1024*1024; // 1024kb

				$valid_exts = array('jpeg', 'jpg', 'png', 'gif');

				if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {

					if( $_FILES['image']['size'] < $max_file_size ){

						// get file extension

						$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

						if (in_array($ext, $valid_exts)) {

							$path = resize_profile(250,250);

							$update = mysql_query(sprintf("UPDATE users SET `email_id`='%s',`fname`='%s',`sex`='%s',`phone_num`='%s',`blood_group`='%s',`dob`='%s',`department`='%s',`designation`='%s',image='%s', `qualification`='%s', `join_date`='%s', `address`='%s', `shift_id`='%s',`role`='%s',`status`='%s',`resigned_date`='%s',`leave_carry`='%s' ,`bank_name`='%s', `branch`='%s', `beneficiary_name`='%s', `acc_num`='%s', `ifsc_code`='%s', `experience`='%s'   WHERE idu='%s'",

		$email_id,$fname,$gender,$phone_num,$blood_group,$dob,$department,$designation,$path,$qualification,$join_date,$address,$shift_id,$role,$ustatus,$res,$cleave,$bank_name,$branch,$beneficiary_name,$acc_num,$ifsc_code,$experience,$u_edit));

		if($update) {?>

          	<div class="alert alert-success">

        	<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        	<strong>User edited succesfully</strong>

			</div>

                <?php

		} else { echo mysql_error(); }

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

	}

}



$edit_query = mysql_query("Select * from users where idu='".$u_edit."'");

	if(mysql_num_rows($edit_query) == 1) {

		// success

		$row = mysql_fetch_array($edit_query);

?>    

			 <h3>Personal Info </h3>

              <hr/>

          <div class="col-md-8">

         

         

			<div class="col-md-6">

                 <div class="form-group">

                  <label for="name">Username: <em class="red-col">*</em></label>

                  <input type="text" id="username" disabled name="username" value="<?php echo $row['username']; ?>" class="form-control" data-required="true" >

                </div>

            </div>

            <div class="col-md-6">    

                <div class="form-group">

                  <label for="name">Email ID: <em class="red-col">*</em></label>

                  <input type="email" id="email_id" name="email_id" value="<?php echo $row['email_id']; ?>" class="form-control" data-required="true" >

                </div>

             </div>

            

            

             <div class="col-md-6">

                 <div class="form-group">

                  <label for="fname">Name: <em class="red-col">*</em></label>

                  <input type="text" id="fname" name="fname" value="<?php echo $row['fname']; ?>" class="form-control" data-required="true" >

                </div>

            </div>

              <div class="col-md-6">

                <div class="form-group">

                  <label for="phone_num">Phone Number: <em class="red-col">*</em></label>

                  <input type="text" id="phone_num" value="<?php echo $row['phone_num']; ?>" name="phone_num" class="form-control" data-required="true" >

                </div>

            </div>

           

             <div class="col-md-6">

                <div class="form-group">

                  <label for="name">Employee ID: <em class="red-col">*</em></label>

                  <input type="text" id="employee_id" name="employee_id" value="<?php echo $row['employee_id']; ?>" disabled class="form-control" >

                </div>

            </div> 

            

          

            

            

           </div>

            

            <div class="col-md-4">

            <div class="fileupload fileupload-new" data-provides="fileupload">

                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> <?php if(!empty($row['image'])){ ?> <img src='<?php echo $row['image']; ?>' alt="Placeholder" /> <?php } else { ?> <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Placeholder" /> <?php } ?> </div>

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

                          <input type="radio" name="radio-2" value="Male" class="icheck-input" <?php if($row['sex'] == 'Male') { echo "checked"; }?>>

                          Male

                        </label>

                      </div>

                  </div>

                  <div class="col-md-2">

                      <div class="radio">

                        <label>

                          <input type="radio" name="radio-2" class="icheck-input" value="Female" <?php if($row['sex'] == 'Female') { echo "checked"; }?>>

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

                      <input id="dob" name="dob" class="form-control" value="<?php echo date('m/d/Y', strtotime($row['dob'])); ?>" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

            </div>

            <div class="col-md-4">    

                <div class="form-group">

                  <label for="blood_group">Blood Group: <em class="red-col">*</em></label>

                  <select id="blood_group" name="blood_group" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                    <option value="O negative"  <?php if($row['blood_group'] == 'O negative') { echo "selected"; }?>>O−</option>

                    <option value="O positive" <?php if($row['blood_group'] == 'O positive') { echo "selected"; }?>>O+</option>

                    <option value="A negative" <?php if($row['blood_group'] == 'A negative') { echo "selected"; }?>>A−</option>

                    <option value="A positive" <?php if($row['blood_group'] == 'A positive') { echo "selected"; }?>>A+</option>

                    <option value="B negative" <?php if($row['blood_group'] == 'B negative') { echo "selected"; }?>>B−</option>

                    <option value="B positive" <?php if($row['blood_group'] == 'B positive') { echo "selected"; }?>>B+</option>

                    <option value="AB negative" <?php if($row['blood_group'] == 'AB negative') { echo "selected"; }?>>AB-</option>

                    <option value="AB positive" <?php if($row['blood_group'] == 'AB positive') { echo "selected"; }?>>AB+</option>

                  </select>

                </div>

             </div>

             <div class="col-md-4">

                 <div class="form-group">

                  <label for="qualification">Qualification: <em class="red-col">*</em> </label>

                 <input type="text" id="qualification" name="qualification" value="<?php echo $row['qualification']; ?>"class="form-control" data-required="true" >

                </div>

            </div>

             

         </div> 



		<div class="col-md-12">

             <div class="col-md-6">

              <div class="form-group">

                      <label for="address">Address Info: <em class="red-col">*</em></label>

                      <textarea data-required="true" data-minlength="5"  name="address" id="textarea-input" cols="10" rows="2" class="form-control"><?php echo $row['address']; ?></textarea>

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

                    <option value="<?php echo $dpt['department_name']; ?>" <?php if ($row['department'] == $dpt['department_name']) { ?> selected <?php } ?>><?php echo $dpt['department_name']; ?></option>

                     <?php } ?>

                  </select>

                 <!-- <input type="text" id="department" name="department" value="< ?php echo $row['department']; ?>" class="form-control" data-required="true" >-->

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

                    <option value="<?php echo $designation['designation']; ?>" <?php if ($row['designation'] == $designation['designation']) { ?> selected <?php } ?>><?php echo $designation['designation']; ?></option>

                     <?php } ?>

                  </select>

                 <!-- <input type="text" id="designation" name="designation" value="< ?php echo $row['designation']; ?>" class="form-control" data-required="true"/>-->

                  </div>

             </div>

            <div class="col-md-4">

                <div class="form-group">

                  <label for="join_date">Join Date:</label>

                   <div class="input-group date ui-datepicker">

                      <input id="join_date" name="join_date" value="<?php echo date('m/d/Y', strtotime($row['join_date'])); ?>" class="form-control" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

            </div>

            

            

           <div class="col-md-4">

                 <div class="form-group">

                  <label for="shift_id">Shift No: <em class="red-col">*</em></label>

                  <input type="text" id="shift_id" name="shift_id" value="<?php echo $row['shift_id']; ?>" class="form-control" data-required="true" >

                </div>

            </div>

            <div class="col-md-4">    

                <div class="form-group">

                  <label for="role">Role: <em class="red-col">*</em></label>

                  <select id="role" name="role" class="form-control" data-required="true">

                    <option value="">Please Select</option>

                     <?php $dr = mysql_query("SELECT * FROM `role`");

					if(mysql_num_rows($dr) > 0) {

					while($row1 = mysql_fetch_array($dr)) {

						if($_SESSION['role'] == 'admin') {

						?>

                        <option value="<?php echo $row1['rolename']; ?>" <?php if($row['role'] == $row1['rolename']) { echo "selected"; }?>>[ <?php echo $row1['rolename']; ?> ]</option>

                        <?php

						} else {

							if( $row1['rolename'] != "admin") {

							?>

                         <option value="<?php echo $row1['rolename']; ?>" <?php if($row['role'] == $row1['rolename']) { echo "selected"; }?>>[ <?php echo $row1['rolename']; ?> ]</option>

                            <?php

							}

						}

						?>

                        

                        <?php

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

                    <option value="newuser" <?php if($row['status'] == 'newuser') { echo "selected"; }?>>New user</option>

                    <option value="active" <?php if($row['status'] == 'active') { echo "selected"; }?>>Active</option>

                     <option value="inactive" <?php if($row['status'] == 'inactive') { echo "selected"; }?>>Inactive</option>

                    <option value="resigned" <?php if($row['status'] == 'resigned') { echo "selected"; }?>>Resigned</option>

                  </select>

                </div>

             </div>

            

                <div class="col-md-4">    

                <div class="form-group">

                  <label for="Leave">Leave Carry: <em class="red-col">*</em></label>

                  <select id="Leave" name="cleave" class="form-control" data-required="true">

                    <option value="0" <?php if($row['leave_carry'] == '0') { echo "selected"; }?>>[ NO ]</option>

                    <option value="1" <?php if($row['leave_carry'] == '1') { echo "selected"; }?>>[ YES ]</option>

                  </select>

                </div>

             </div>
             
              <!-- ADDITIONAL FIELDS -->
              <div class="col-md-4">    
                <div class="form-group">
                <label for="Leave">Appointed Date:</label>
                 <div class="input-group date ui-datepicker">

                      <input id="experience" name="experience" value="<?php if($row['experience'] != "0000-00-00") { echo date('m/d/Y', strtotime($row['experience']));}?>" class="form-control" type="text">

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
                  <input type="text" name="bank_name" class="form-control" value="<?php echo $row['bank_name']; ?>" placeholder="Enter Bank Name" />
                  
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="Branch">Branch:</label>
                  <input type="text" name="branch" class="form-control" placeholder="Enter Branch Name" value="<?php echo $row['branch']; ?>" />
                </div>
            </div>
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Beneficiary Name">Beneficiary Name: </label>
                  <input type="text" name="beneficiary_name" class="form-control" value="<?php echo $row['beneficiary_name']; ?>" placeholder="Enter Beneficiary Name" />
                </div>
             </div>
            
            
            
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Account Number">Account Number: </label>
                  <input type="text" name="acc_num" class="form-control" value="<?php echo $row['acc_num']; ?>" placeholder="Enter Account Number" />
                </div>
             </div>
             
             
            <div class="col-md-4">    
                <div class="form-group">
                  <label for="Account Number">IFSC Code: </label>
                  <input type="text" name="ifsc_code" class="form-control" value="<?php echo $row['ifsc_code']; ?>" placeholder="Enter IFSC Code" />
                </div>
             </div>
		</div>
      
        <div class="col-md-12">
                <div class="form-group">

                  <button type="submit" name="edit_users" class="btn btn-success"><i class="fa fa-user"></i> Update <i class="fa fa-arrow-right"></i></button>

                </div>
          </div>

        
	

              </form>

   

  

              

        </div>  <!--  /.portlet-content -->

     </div> <!-- /.portlet -->    

             

<?php

} else {

		// error

	}

	

}

?>

        

   </div> <!-- /.col -->



      </div> <!-- /.row -->



    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<?php include_once("includes/footer.php"); ?>



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script type="text/javascript">

$(document).ready(function() {

 // DEPARTMENT AND DESIGNATION PART
	$("#department").change(function() {
		var id=  btoa($(this).val());
		
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

