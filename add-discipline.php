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

        <h2 class="content-header-title">Add Discipline</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Add Discipline</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-file-text"></i> Disciplinary Action Form</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form">

          

<?php

if(isset($_POST['add_discipline'])) {

	$d_emp_id = (int) mysql_real_escape_string($_POST['username']);
	$d_date = mysql_real_escape_string(date('Y-m-d H:i:s', strtotime($_POST['incident_date'])));
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

            $insert = mysql_query("INSERT INTO `disciplines` (`di_id`, `di_emp_idu`, `di_date`, `di_hour`, `di_minute`, `di_meridian`, `di_location`, `di_description`, `di_witnesses`, `di_violation`, `di_p_violation`, `di_action`, `di_impropriety`, `di_explanation`) VALUES (NULL, '$d_emp_id', '$d_date', '$d_hour', '$d_minute', '$d_meridian', '$d_location', '$d_description', '$d_witnesses', '$d_violation', '$d_p_violation', '$d_action', '$d_impropriety', '$d_explanation');");
            if($insert) {
                $inser_id = mysql_insert_id();
                $today = date('d-M-Y');
                $update_history = mysql_query("INSERT INTO discipline_history (`dh_di_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$inser_id."','','pending','".$today."')");

        ?>
        <div class="alert alert-success">
        <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        <strong>Discipline added</strong> successfully.<br><br>
		<!-- <button class="btn btn-danger" onClick="location.href='discipline-list.php?d_id=<?php// echo base64_encode(base64_encode($inser_id)); ?>'">Discipline Info check</button> -->

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

  <h3>Employee Info </h3><hr/> 
          <div class="row">
			<div class="col-md-4">
                <?php $select_project = mysql_query("SELECT * from users WHERE  role!='admin'");?>
                <div class="form-group">
					<label for="validateSelect">Name <em class="red-col">*</em></label>
                  <select name="username" class="form-control select2-input" data-required="true">
                    <option value="">Select Employee</option>
                    <?php  while($row = mysql_fetch_array($select_project)) {
					?>
                    
                    <option value="<?php echo $row['idu'] ?>"><?php echo $row['fname'];?></option>
                    <?php } ?>
                    
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
                        <input id="join_date" name="incident_date" class="form-control" type="text" data-required="true">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="join_date">Incident Time: <em class="red-col">*</em></label>
                    <div class="input-group">
                        <select name="incident_hour" id="incident_hour">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>&nbsp;
                        :&nbsp;
                        <select  name="incident_minute" id="incident_minute">
                            <!-- <option value="05">05</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="35">35</option>
                            <option value="40">40</option>
                            <option value="45">45</option>
                            <option value="50">50</option>
                            <option value="55">55</option> -->
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <option value="32">32</option>
                            <option value="33">33</option>
                            <option value="34">34</option>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
                            <option value="46">46</option>
                            <option value="47">47</option>
                            <option value="48">48</option>
                            <option value="49">49</option>
                            <option value="50">50</option>
                            <option value="51">51</option>
                            <option value="52">52</option>
                            <option value="53">53</option>
                            <option value="54">54</option>
                            <option value="55">55</option>
                            <option value="56">56</option>
                            <option value="57">57</option>
                            <option value="58">58</option>
                            <option value="59">59</option>
                            <option value="60">60</option>
                        </select>&nbsp;&nbsp;
                        <select name="incident_meridian" id="incident_meridian">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
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
                    <input id="incident_location" name="incident_location" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_description">Description of Incident:<em class="red-col">*</em></label>
                    <input id="incident_description" name="incident_description" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_witness">Incident Witnesses:<em class="red-col">*</em></label>
                    <input id="incident_witness" name="incident_witness" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incideny_violation">Was this incident in violation of a company policy?<em class="red-col">*</em></label>
                    <div class="input-group">
                        <select class="form-control" name="incident_violation" id="">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="NA">NA</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="incident_policy_violation">If yes, specify which policy and how the incident violated it:</label>
                    <textarea cols="8" rows="3" id="incident_policy_violation" name="incident_policy_violation" class="form-control"></textarea>
                </div>
            </div>
        </div>
        
        <h3>Action Taken</h3><hr/> 
        <div class="row" id="">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_action">What action will be taken against the employee?<em class="red-col">*</em></label>
                        <input id="incident_action" name="incident_action" type="text" class="form-control">
                </div>
            </div>
            
        </div>
        <div class="row" id="">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="incideny_impropriety">Has the impropriety of the employee’s actions been explained to the employee?<em class="red-col">*</em></label>
                    <div class="input-group">
                        <select class="form-control" name="incident_impropriety" id="">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">            
                <div class="form-group">
                        <label for="incident_employee_explanation">Employee’s explanation of conduct (if any):</label>
                        <textarea cols="8" rows="3" id="incident_employee_explanation" name="incident_employee_explanation" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" name="add_discipline" class="btn btn-success"><i class="fa fa-file-text-o"></i> Add Disciplinary Form <i class="fa fa-arrow-right"></i></button>
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

} else {

	header("Location: welcome.php"); 

}

}

?>