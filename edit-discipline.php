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

	if(($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')  || ($permission == "access")) {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
    if(isset($_GET["di_id"]) && isset($_GET["show_edit"]) ){
    
?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Add Discipline</title>



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

        <h2 class="content-header-title">Edit Discipline</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Edit Discipline</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-file-text"></i> Disciplinary Action Form</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form">

          

<?php

if(isset($_POST['edit_discipline'])) {
    $di_id = (int) mysql_real_escape_string($_POST['di_id']);
	$d_emp_id = (int) mysql_real_escape_string($_POST['username']);
	$d_date = mysql_real_escape_string(date('Y-m-d', strtotime($_POST['incident_date'])));
	$d_hour = mysql_real_escape_string($_POST['incident_hour']);
	$d_minute = mysql_real_escape_string($_POST['incident_minute']);
	$d_meridian = mysql_real_escape_string($_POST['incident_meridian']);
	$d_location = mysql_real_escape_string($_POST['incident_location']);
	$d_description = mysql_real_escape_string($_POST['incident_description']);
	$d_witnesses = mysql_real_escape_string($_POST['incident_witness']);
	$d_violation = mysql_real_escape_string($_POST['incident_violation']);
	$d_p_violation = mysql_real_escape_string($_POST['incident_policy_violation']);
	$d_action = mysql_real_escape_string($_POST['incident_action']);
	$d_impropriety = mysql_real_escape_string($_POST['incident_impropriety']);
    $d_explanation = mysql_real_escape_string($_POST['incident_employee_explanation']);
    // echo "emp id is:   $d_emp_id";

		if(!empty($emp_id) || !empty($d_date) || !empty($d_hour) || !empty($d_minute) || !empty($d_meridian) || !empty($d_location) || !empty($d_description) || !empty($d_witnesses) || !empty($d_violation) || !empty($d_action) || !empty($d_impropriety))  {

            $insert = mysql_query("UPDATE `disciplines` SET `di_emp_idu` = '$d_emp_id', `di_date` = '$d_date', `di_hour` = '$d_hour', `di_minute` = '$d_minute', `di_location` = '$d_location', `di_description` = '$d_description', `di_witnesses` = '$d_witnesses', `di_violation` = '$d_violation', `di_p_violation` = '$d_p_violation', `di_action` = '$d_action', `di_impropriety` = '$d_impropriety', `di_explanation` = '$d_explanation' WHERE `disciplines`.`di_id` = $di_id;");
            if($insert) {
                $inser_id = mysql_insert_id();
                $today = date('d-M-Y');
                $update_history = mysql_query("INSERT INTO discipline_history (`dh_di_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$inser_id."','','pending','".$today."')");

        ?>
        <div class="alert alert-success">
        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        <strong>Discipline Edited</strong> successfully.<br><br>
		<!-- <button class="btn btn-danger" onClick="location.href='view-discipline-status.php'">Discipline Info check</button> -->

      </div>
        <?php
            } else {
                echo mysql_error();
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
}

?>         
<?php
$di_id = $_GET["di_id"];
$sql = "SELECT * from disciplines,users where di_id = $di_id and di_emp_idu = idu";
$result = mysql_query($sql);
if(mysql_num_rows($result)>0){
$discipline_row = mysql_fetch_array($result);
?>
  <h3>Employee Info </h3><hr/> 
          <div class="row">
			<div class="col-md-4">
                <input name="di_id" style="display:none" value="<?php echo $discipline_row["di_id"]?>">
                <?php $select_project = mysql_query("SELECT * from users WHERE  role!='admin'");?>
                <div class="form-group">
					<label for="validateSelect">Name <em class="red-col">*</em></label>
                  <select name="username" class="form-control select2-input" data-required="true">
                    <option value="">Select Employee</option>
                    <?php  while($row = mysql_fetch_array($select_project)) {
					?>
                    
                    <option  <?php echo ($discipline_row["di_emp_idu"] == $row["idu"])? "selected":"" ?> value="<?php echo $row['idu'] ?>"><?php echo $row['fname'];?></option>
                    <?php } 
                    ?>
                    
                  </select>
                </div>

            </div>

            <div class="col-md-6">

            </div>
        </div>
        <br>
        <h3>Incident Info </h3><hr/> 
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="join_date">Incident Date: <em class="red-col">*</em></label>
                    <div class="input-group date ui-datepicker">
                        <input value="<?php echo date("d/m/Y",  strtotime($discipline_row["di_date"])) ?>" id="join_date" name="incident_date" class="form-control" type="text" data-required="true">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="join_date">Incident Time: <em class="red-col">*</em></label>
                    <div class="input-group">
                        <select name="incident_hour" id="incident_hour">
                        <?php 
                            for($count =1; $count<=12; $count++){
                        ?>
                            <option  <?php echo ($discipline_row["di_hour"] == $count)? "selected":"" ?> value="<?php echo( sprintf("%02s",$count)) ?>"><?php echo( sprintf("%02s",$count)) ?></option>
                        <?php }?>
                        </select>&nbsp;
                        :&nbsp;
                        <select  name="incident_minute" id="incident_minute">
                        <?php 
                            for($count =1; $count<60; $count++){
                        ?>
                            <option  <?php echo ($discipline_row["di_minute"] == $count)? "selected":"" ?> value="<?php echo( sprintf("%02s",$count)) ?>"><?php echo( sprintf("%02s",$count)) ?></option>
                        <?php }?>
                        </select>&nbsp;&nbsp;
                        <select name="incident_meridian" id="incident_meridian">
                            <option <?php echo ($discipline_row["di_meridian"] == "AM")? "selected":"" ?> value="AM">AM</option>
                            <option <?php echo ($discipline_row["di_meridian"] == "PM")? "selected":"" ?> value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="incident_location">Incident Location:<em class="red-col">*</em></label>
                    <input value="<?php echo $discipline_row["di_location"] ?>" id="incident_location" name="incident_location" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_description">Description of Incident:<em class="red-col">*</em></label>
                    <input value="<?php echo $discipline_row["di_description"] ?>" id="incident_description" name="incident_description" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_witness">Incident Witnesses:<em class="red-col">*</em></label>
                    <input value="<?php echo $discipline_row["di_witnesses"] ?>" id="incident_witness" name="incident_witness" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incideny_violation">Was this incident in violation of a company policy?<em class="red-col">*</em></label>
                    <div class="input-group">
                        <select class="form-control" name="incident_violation" id="">
                            <option <?php echo ($discipline_row["di_violation"] == "Yes")? "selected":"" ?>  value="Yes">Yes</option>
                            <option <?php echo ($discipline_row["di_violation"] == "No")? "selected":"" ?> value="No">No</option>
                            <option <?php echo ($discipline_row["di_violation"] == "NA")? "selected":"" ?> value="NA">NA</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_policy_violation">If yes, specify which policy and how the incident violated it:</label>
                    <textarea value="<?php echo $discipline_row["di_p_violation"] ?>" cols="8" rows="3" id="incident_policy_violation" name="incident_policy_violation" class="form-control"><?php echo $discipline_row["di_p_violation"] ?></textarea>
                </div>
            </div>
        </div>
        
        <h3>Action Taken</h3><hr/> 
        <div class="row" id="">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_action">What action will be taken against the employee?<em class="red-col">*</em></label>
                        <input value="<?php echo $discipline_row["di_action"] ?>" id="incident_action" name="incident_action" type="text" class="form-control">
                </div>
            </div>
            
        </div>
        <div class="row" id="">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="incideny_impropriety">Has the impropriety of the employee’s actions been explained to the employee?<em class="red-col">*</em></label>
                    <div class="input-group">
                        <select class="form-control" name="incident_impropriety" id="">
                            <option <?php echo ($discipline_row["di_violation"] == "Yes")? "selected":"" ?> value="Yes">Yes</option>
                            <option <?php echo ($discipline_row["di_violation"] == "No")? "selected":"" ?> value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_employee_explanation">Employee’s explanation of conduct (if any):</label>
                        <textarea value="<?php echo $discipline_row["di_explanation"] ?>" cols="8" rows="3" id="incident_employee_explanation" name="incident_employee_explanation" class="form-control"><?php echo $discipline_row["di_explanation"] ?></textarea>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_employee_explanation">Handled by:</label>
                </div>
            </div>
        </div> -->
        <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" name="edit_discipline" class="btn btn-success"><i class="fa fa-file-text-o"></i> Edit Disciplinary Form <i class="fa fa-arrow-right"></i></button>
                </div>
        </div>
        

    </form>

   

  

              

        </div>  <!--  /.portlet-content -->

     </div> <!-- /.portlet -->    
                    <?php } ?>
             



        

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
	// $("#incident_hour").append("<option value='14'>14</option>");
	

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
else{
	header("Location: welcome.php"); 
    
}
    
}

?>