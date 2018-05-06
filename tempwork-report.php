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

  <title><?php echo $settings['title']; ?> - My Temporary Work Status</title>



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

        <h2 class="content-header-title">My Temporary Work Status</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li><a href="<?php echo $conf_path;?>/my-work-status.php">Work</a></li>

          <li class="active">Temp Work Status</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">

<?php if(isset($_GET['msg'])){

	if($_GET['msg'] == "invalid") { ?>

 <div class="alert alert-danger">

 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>

    	<h4>Error</h4> 

        <strong>sorry!</strong> Please Enter working time correctly .<br>

      </div>

      <?php }

	  if($_GET['msg'] == "success") { ?>

 <div class="alert alert-success">

 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>

    	<h4>Success</h4> 

        report added successfully.. if any changes delete the report and fill again .<br>

      </div>

      <?php } 

	  if($_GET['msg'] == "etime") { ?>

 <div class="alert alert-info">

 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>

    	<h4>Error</h4> 

        Please enter no of hours working

      </div>

      <?php }

	  } ?>



          

<?php

// Select Attendance Details

$w_query = mysql_query("SELECT * FROM attendance WHERE username = '".$_SESSION['username']."' and status = '1'");

// Query Execute check

$ff = mysql_fetch_array($w_query);

$working_hours = gmdate("H:i",strtotime(date("H:i"))-strtotime($ff['signin_time']));

$time_remain ="00:00";

$temp_time = "00:00";

$w_query_exe = mysql_num_rows($w_query);

if($w_query_exe != 0)

{

	?>

    <div class="portlet">

    <?php

	

	// Work Report Not Filled

	$work = mysql_query("SELECT * FROM temporary_report WHERE username = '".$_SESSION['username']."'");

	

	$temp_work = mysql_num_rows($work);

	///////// Time Check ///////////

	if($temp_work == 0)

	{

		// Full working hours is there

		$time_remain = $working_hours;

	}

	else

	{

		// fetch details from temporary report

		while($temp_work_fetch = mysql_fetch_array($work))

		{

			$a = strtotime($temp_work_fetch['time_of_work']);

			$a1=$a-strtotime("00:00");

			$temp_time += $a1;

		}

		$temp_time += strtotime("00:00");

		$temp_remain_time = strtotime($working_hours) - $temp_time ;

		$time_remain = gmdate("H:i",$temp_remain_time);

				

	}

	///////// Time Check End ///////////

	

	////////////////// Add Temporary Report //////////////

	if(isset($_POST['add'])){

		$project_name = $_POST['project_name'];

		$type_of_project = $_POST['type_of_project'];

		// BPO SECTION ONLY ALLOW TOTAL RECORDS OPTION
		if(isset($_POST['total_records'])) {
			$total_records = $_POST['total_records'];
		} else {
			$total_records = "";
		}

		$time_of_work = $_POST['time_of_work_hr'].":".$_POST['time_of_work_min'];

		$comments = $_POST['comments'];

		

		$check_time_remain = strtotime($time_remain);

		$added_time =  strtotime($time_of_work);

		if($time_of_work == "00:00") {

			header("location:$conf_path/tempwork-report.php?msg=etime");

		} else {

		  if($added_time <= $check_time_remain) {

			// correct time

			$insert = mysql_query("INSERT INTO temporary_report (`username`,`emp_id`,`project_name`,`type_of_work`,`time_of_work`,`comments`,`total_time`,`report_date`,`total_records`) VALUES ('".$_SESSION['username']."','".$users['emp_id']."','$project_name','$type_of_project','$time_of_work','$comments','".$fetch['working_hours']."','".$ff['signin_date']."','$total_records')");

			if($insert) {

			header("location:$conf_path/tempwork-report.php?msg=success");	

			} else {

				echo mysql_error();

			}

		 } else {

			// error time

			header("location:$conf_path/tempwork-report.php?msg=invalid");

		 }

		}

	}

	////////////////// Add Temporary Report End //////////////

	

	$time_details = explode(":",$time_remain);

	$hr = $time_details[0];

	$min = $time_details[1];

?>

           



            <div class="portlet-content">  





        <div class="table-responsive">

<form method="post" action="#"  data-validate="parsley" class="form">

              <table 

                class="table table-bordered table-hover">

                  <thead>

                    <tr>

                      <th>Project Name</th>

                      <th>Type of Work</th>

                       <?php // total records only showing on
					 if($users['department'] == "BPO") { ?> <th>Total Records</th> <?php } ?>

                      <th>No of Hour</th>

                      <th>Comments</th>

                      <th>submit</th>

                    </tr>

                  </thead>

                  <tbody>

                    <tr>

                      <td><div class="form-group"><select id="s2_basic" name="project_name" data-required="true" class="form-control project_name">

                     		  <option value="" selected>Select Project Name</option> 

                               <option value="Lunch">Lunch</option>  

                               <option value="Break">Break</option>                  

                              <?php

					$project_ass = mysql_query("SELECT * from project_assignment where username='".$_SESSION['username']."'");

 					 while($row = mysql_fetch_array($project_ass))

						  {

							  $select = mysql_fetch_array(mysql_query("SELECT * from project_list WHERE p_id='".$row['project_name_id']."'"));

							  

							 echo '<option value="'.$select['p_id'].'">'.$select['project_name'].'</option>';

						  }

						   ?>

			              </select>

                          </div>

                      </td>

                      <td><div class="form-group">

                      <select id="task_name" name="type_of_project"  class="form-control select2-input">

			              </select>

                          </div>

                      </td>

                    <?php // total records only showing on
					 if($users['department'] == "BPO") { ?>    <td><div class="form-group"><input type="text" name="total_records" class="form-control" placeholder="Total Records" /></div></td> <?php } ?>

                      <td><div class="form-group">

                       <table> <tr><td><select class="form-control" name="time_of_work_hr" style="width:65px; float:left">

                <?php $j = '00';

				while($j < '24') {

					if($hr == $j) {

						$hrs = "selected";

					} else { $hrs='';

					}

					if(strlen($j) == 1) {

						$j = '0'.$j;

						 echo "<option $hrs value='$j'>$j</option>";

					} else {

                echo "<option $hrs value='$j'>$j</option>";

					}

                $j += '01';} ?>

                </select></td> <td style="vertical-align:middle"> &nbsp; : &nbsp; </td> <td><select class="form-control" name="time_of_work_min" style="width:65px;">

                 <?php $i = '00';

				while($i < '60') {

					if($min == $i) {

						$mins = "selected";

					} else { $mins='';

					}

					if(strlen($i) == 1) {

						$i = '0'.$i;

						 echo "<option $mins value='$i'>$i</option>";

					} else {

                echo "<option $mins value='$i'>$i</option>";

					}

                $i += '01';} ?>

                </select></td> </tr></table>

                </div></td>

                      <td><div class="form-group"><textarea id="comments" name="comments" class="form-control" rows="3" data-required="true"></textarea></div></td>

                      <td><button type="submit" name="add" class="btn btn-success"><i class="fa fa-arrow-circle-o-right"></i> Add</button></td>

                    </tr>

                  </tbody>

                </table>

</form>

                </div> <!-- /.table-responsive -->

        <?php

// Temporary work report filled display check

$temp_rep = mysql_query("select  * from temporary_report where username='".$_SESSION['username']."'");

if($temp_rep) {

	if(mysql_num_rows($temp_rep) != 0){

?>

              

                

                <div class="table-responsive">



              <table 

                class="table table-bordered table-hover">

                  <thead>

                  <tr><th colspan="6"><h4>My work report </h4></th></tr>

                    <tr>

                    

                      <th>Project Name</th>

                      <th>Type of Work</th>

                       <?php // total records only showing on
					 if($users['department'] == "BPO") { ?><th>Total Records</th> <?php } ?>

                      <th>No of Hour</th>

                      <th>Comments</th>

                      <th>submit</th>

                    </tr>

                  </thead>

                  <tbody>

				  <?php // temporary report is there 

					while($report = mysql_fetch_array($temp_rep)) {	

					if($report['project_name'] == "Lunch" ||  $report['project_name'] =="Break") {

						$proj_name = $report['project_name'];

					} else {

					// project name get

					$pro_name = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$report['project_name']."'"));

					$proj_name = $pro_name['project_name'];

					}

					// task anme get

					$task_name = mysql_fetch_array(mysql_query("SELECT * FROM project_task_list WHERE pt_id='".$report['type_of_work']."'"));

					?>

                    <tr>                    

                      <td><?php echo $proj_name;?></td>

                      <td><?php echo $task_name['task_name'];?></td>

                       <?php // total records only showing on
					 if($users['department'] == "BPO") { ?><td><?php echo $report['total_records'];?></td> <?php } ?>

                      <td><?php echo $report['time_of_work'];?></td>

                      <td><?php echo $report['comments'];?></td>

                      <td>

                     <!-- <button type="submit" name="edit" class="btn btn-warning"><i class="fa fa-edit"></i></button>-->

                      <button type="submit" name="delete" onClick="location.href='<?php echo $conf_path;?>/request/deletereport.php?id=<?php echo $report['temp_id'];?>'" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>

                    </tr>

                    <?php } ?>

                  </tbody>

                </table>



                </div> <!-- /.table-responsive -->

<?php } } ?>





            </div> <!-- /.portlet-content -->

             </div> <!-- /.portlet -->    

         <?php

}



else

{

	// Work Report Filled

	?>

    <div class="alert alert-info">

    	<h3>Fill this Temporary Report after Signin</h3> 

        <strong>sorry!</strong> This report will display after signin .<br>

		IF YOU WANT TO SIGNIN, CLICK BELOW BUTTON

      </div>

      <button class="btn btn-success ui-popover" data-placement="right" data-toggle="tooltip" data-original-title="Signin Details" data-content="Click this link to signin your account." onClick="location.href='<?php echo $conf_path;?>/attendance.php'" data-trigger="hover" type="button">Click to Signin</button>

    <?PHP

}

?>     

   </div> <!-- /.col -->



      </div> <!-- /.row -->



    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<?php include_once("includes/footer.php"); ?>



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script>

 $(document).ready(function() {

	// task selection

	$(".project_name").change(function() {

		var id=$(this).val();
		
		// additional option for required fields 
		if(id == "Lunch" || id == "Break") {
			$('.form').parsley().destroy();
			$('.form').removeAttr("data-validate");
			$('#comments').attr('data-parsley-required', 'false');
			$('#comments').attr('data-required', 'false');
		}  else {
			$('.form').parsley();
			$('#comments').attr('data-parsley-required', 'true');
			$('#comments').attr('data-required', 'true');
		}
		 
		var dataString = 'q='+ id;

		$.ajax({

			type: "POST",

			url: "request/user_task.php",

			data: dataString,

			cache: false,

			success: function(html)

			{

			$("#task_name").html(html);

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



  <!-- App JS -->

  <script src="js/target-admin.js"></script>

  

  <!-- Plugin JS -->

  <script src="js/demos/form-extended.js"></script>



</body>

</html>

<?php

}

?>

