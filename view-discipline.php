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

	if(($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'Supervisor') || ($_SESSION['role'] == 'manager')  || ($permission == "access")) {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
    if(isset($_GET["di_id"]) && isset($_GET["view"]) ){
?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - View Discipline</title>



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

        <h2 class="content-header-title">View Discipline</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">View Discipline</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-file-text"></i> Disciplinary Action Form</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form">

             <?php
    if(isset($_POST["update_discipline_status"])){
        $di_id = $_POST["di_id"];
        $status = $_POST["di_status"];
        if($status == "Pending" || $status == "Completed"){     
            $sql = "UPDATE `disciplines` SET `di_status` = '$status' WHERE `disciplines`.`di_id` = $di_id;";
            if(mysql_query($sql)){
                ?>
    <div class="alert alert-success">
        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        <strong>Discipline Status Changed</strong> successfully.<br><br>
		<!-- <button class="btn btn-danger" onClick="location.href='view-discipline-status.php'">Discipline Info check</button> -->

      </div>
<?php
            }
        }
    }

?>

<?php
$u_name = $_SESSION["username"];
$di_id = $_GET["di_id"];
$sql = "SELECT di_status, u.fname as emp_name, di_hour,di_minute,di_meridian, di_location,di_date,di_description,di_location,di_witnesses,di_violation,di_p_violation,di_action,di_impropriety,di_explanation, di_status from disciplines inner join users u on u.idu = di_emp_idu left join users a on a.idu = di_appointed_to where di_id = $di_id AND a.username = '$u_name' ";
$result = mysql_query($sql);
if(mysql_num_rows($result)==0){
    echo "CANNOT VIEW THIS";
}
else{
    $row = mysql_fetch_array($result);
?>         

  <h3>Employee Info  </h3><hr/> 
          <div class="row">
			<div class="col-md-4">
                <?php $select_project = mysql_query("SELECT * from users WHERE  role!='admin'");?>
                <div class="form-group">
					<label for="validateSelect">Name </label>
                    <p><?php echo $row["emp_name"] ?></p>
                    
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
                    <label for="">Incident Date:</label>
                    <div class="">
                        <p><?php echo date("d/m/Y",  strtotime($discipline_row["di_date"])) ?></p>
                        <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="join_date">Incident Time: </label>
                    <p><?php echo $row["di_hour"] . " : ".$row["di_minute"]. " ".$row["di_meridian"]?></p>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="incident_location">Incident Location:</label>
                    <p><?php echo $row["di_location"]?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_description">Description of Incident:</label>
                    <p><?php echo $row["di_description"]?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_witness">Incident Witnesses:</label>
                    <p><?php echo $row["di_witnesse"]?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incideny_violation">Was this incident in violation of a company policy?</label>
                    <div class="input-group">
                    <p><?php echo $row["di_violation"]?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_policy_violation">If yes, specify which policy and how the incident violated it:</label>
                    <p><?php echo $row["di_p_violation"]?></p>
                </div>
            </div>
        </div>
        
        <h3>Action Taken</h3><hr/> 
        <div class="row" id="">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_action">What action will be taken against the employee?</label>
                        <p><?php echo ($row["di_action"])? $row["di_action"] : "None"?></p>
                </div>
            </div>
            
        </div>
        <div class="row" id="">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="incideny_impropriety">Has the impropriety of the employee’s actions been explained to the employee?</label>
                    <p><?php echo $row["di_impropriety"]?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_employee_explanation">Employee’s explanation of conduct (if any):</label>
                        <p><?php echo $row["di_explanation"]?></p>
                </div>
            </div>
        </div>
        <div class="row" id="">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_status">Status<em class="red-col"></em></label>
                    <div class="input-group">
                        <select class="form-control" name="di_status" id="">
                            <option <?php echo ($row["di_status"] == "Pending")? "selected":"" ?> value="Pending">Pending</option>
                            <option <?php echo ($row["di_status"] == "Completed")? "selected":"" ?> value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <input style="display:none" name="di_id" value=<?php echo $di_id ?>
        <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" name="update_discipline_status" class="btn btn-success"><i class="fa fa-file-text-o"></i> Update Status <i class="fa fa-arrow-right"></i></button>
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
} //if user not assigned
} else {

	header("Location: welcome.php"); 

}
    }
    else {
        
            header("Location: welcome.php"); 
        
        }


}

?>