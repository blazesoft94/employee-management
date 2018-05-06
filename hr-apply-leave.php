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

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - My  Leave Apply</title>



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

        <h2 class="content-header-title">Apply leave</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Apply leave</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

<div class="portlet-header">



              <h3>

                <i class="fa fa-tasks"></i>

               Leave apply details info

              </h3>



            </div>

            <div class="portlet-content">

<?php

// leave status

/* 0 - pending

   1 - success

   2 - reject 

   3 - usercancel */

if(isset($_POST['leave_apply'])) {

	$l_from = mysql_real_escape_string($_POST['l_from']);

	$l_to = mysql_real_escape_string($_POST['l_to']);

	$l_reason = mysql_real_escape_string($_POST['l_reason']);

	$l_day = $_POST['radio-1'];
	
	$name = $_POST['username'];

	$apply_date = date("d-M-Y H:i:s");	

	/* half day ... full day checking */

	if($l_day == "half") {

		// checking from and to date are same or not

		if($l_from  == $l_to) {

			$leave_checking = "correct";

		} else {

			$leave_checking = "wrong";

		}

	} else {

		$leave_checking = "correct";

	}

	/* half day ... full day checking */

	// date overlapping checked

	/* previous date leave check */

	/*if(strtotime(date("d-M-Y")) <= strtotime($l_from)) {*/

		if(strtotime($l_from) <= strtotime($l_to)) {

			if($leave_checking == "correct" and !empty($name)) {

				/* date split function */

				$mf = date('m',strtotime($l_from));

				$fmy = date('Y',strtotime($l_from));

				$mt = date('m',strtotime($l_to));

				$tmt = date('Y',strtotime($l_to));
				

				// from and to months equal or not check

				if($mf == $mt) {

				  $leave = mysql_query("INSERT INTO leave_management (`username`,`leave_from`,`leave_to`,`half_full`,`leave_reason`,`apply_date`,`status`,`approve_date`,`cancel_date`,`change_status_person`) VALUES ('".$name."','".$l_from."','".$l_to."','".$l_day."','".$l_reason."','".$apply_date."','0','','','')");

				  if($leave) { header("Location: hr-apply-leave.php?msg=success");} 

				  else { echo mysql_error();}

				} else {

					// from and to months are different

					// Get the number of days in a month for a specified year and calendar

					$Tdays = cal_days_in_month(CAL_GREGORIAN,$mf,$fmy);

					// month end date as a leave date

					$fleave_to = $mf."/".$Tdays."/".$fmy;

					$Tleave_from = $mt."/01/".$tmt;

					$leave1 = mysql_query("INSERT INTO leave_management (`username`,`leave_from`,`leave_to`,`half_full`,`leave_reason`,`apply_date`,`status`,`approve_date`,`cancel_date`,`change_status_person`) VALUES ('".$name."','".$l_from."','".$fleave_to."','".$l_day."','".$l_reason."','".$apply_date."','0','','','')");

					$leave2 = mysql_query("INSERT INTO leave_management (`username`,`leave_from`,`leave_to`,`half_full`,`leave_reason`,`apply_date`,`status`,`approve_date`,`cancel_date`,`change_status_person`) VALUES ('".$name."','".$Tleave_from."','".$l_to."','".$l_day."','".$l_reason."','".$apply_date."','0','','','')");

					if($leave1 and $leave2) { header("Location: hr-apply-leave.php?msg=success");} 

				}

			} else {

				header ("Location: hr-apply-leave.php?msg=wrong");

			}

		} else {

			header ("Location: hr-apply-leave.php?msg=lerror");

		}

	/*} else {

		header ("Location: apply-leave.php?msg=error");

	}*/

}

?>       



<?php if(isset($_GET['msg'])) {

	if($_GET['msg'] == "success") { ?>

		 <div class="alert alert-success">

            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

            <strong>Leave </strong> applied successfully and waiting for process<br>

if you want to know about leave status click link(<a href="leave-request-info.php">Leave Status</a>)

          </div>

	<?php }

	

	if($_GET['msg'] == "lerror") { ?>

		 <div class="alert alert-danger">

            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

            <strong>Error </strong>Selecting date

          </div>

	<?php }

	

	if($_GET['msg'] == "wrong") { ?>

		 <div class="alert alert-danger">

            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

            <strong>Leave Date and Leave type(full/half) Issue </strong>(or) Missing username details<br>

[Please Check your from,end date and Leave type(full/half)]

          </div>

	<?php }

	

	if($_GET['msg'] == "error") { ?>

		 <div class="alert alert-danger">

            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

            <strong>cannot apply leave</strong> for this date

          </div>

	<?php }

} ?>

   

           

            <form method="post" class="form parsley-form col-sm-6" data-validate="parsley">
              <div class="col-sm-12">
              <div class="form-group">
					<label for="validateSelect">Username <em class="red-col"> *</em></label>
                  <select name="username" class="form-control select2-input" data-required="true">
                    <option value="">Select Username</option>
                    <?php $users = mysql_query("SELECT * from users WHERE  role!='admin' and (status='active' or status='newuser')");
						if(mysql_num_rows($users) != 0) {
						 while($row = mysql_fetch_array($users)) {
					?>
                    <option value="<?php echo $row['username'] ?>"><?php echo $row['fname']." [ ".$row['username']." ] ";?></option>
                    <?php } 
						}?>
                  </select>
				</div>
              </div>

            <div class="col-sm-6">

             <div class="form-group">

                   <label for="date-2">Leave From: <em class="red-col"> *</em></label>



                  <div class="input-group date ui-datepicker">

                      <input id="date-2" name="l_from" class="form-control" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

             </div>

             <div class="col-sm-6">

              <div class="form-group">

                  <label for="date-2">Leave To: <em class="red-col"> *</em></label>



                  <div class="input-group date ui-datepicker">

                      <input id="date-1" name="l_to" class="form-control" type="text" data-required="true">

                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                  </div>

                </div>

                 

             </div>

             

             

           

            <div class="col-sm-12">

             <div class="form-group">

                  <label for="textarea-input">Leave Reason: <em class="red-col"> *</em></label>

                  <textarea class="form-control parsley-validated"  rows="2" cols="10" id="textarea-input" name="l_reason" data-minlength="5" data-required="true"></textarea>

                  </div>

                </div>

             

                

               

                <div class="form-group">

                 <div class="col-sm-12">

                  <label>Leave type(full/half): <em class="red-col"> *</em></label>

                  </div>

                  <div class="col-sm-6">

                      <div class="radio">

                        <label class="parsley-success">

                          <input type="radio"  checked data-required="true" class="parsley-validated" value="full" name="radio-1">

                          Full Day

                        </label>

                      </div>

                  </div>

                  <div class="col-sm-6">

                      <div class="radio">

                        <label class="parsley-success">

                          <input type="radio" data-required="true" class="parsley-validated" value="half" name="radio-1">

                          Half Day

                        </label>

                      </div>

                  </div>

                </div>

                 <div class="col-sm-6">

                 <input class="btn  btn-secondary"  type="submit" name="leave_apply" id="submit" value="Submit"/>

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

}

?>

