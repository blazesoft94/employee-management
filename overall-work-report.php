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
  <title><?php echo $settings['title']; ?> - Overall Attendance Report</title>

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
        <h2 class="content-header-title">Overall Attendance status</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Overall Attendance Report</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
<div class="portlet-header">




              <h3>
                <i class="fa fa-tasks"></i>
               Select username, month and year to generate attendance report
              </h3>

            </div>
            <div class="portlet-content"> 
            <form class="form parsley-form col-sm-8" method="post">
            <!-- username -->
			<div class="col-sm-4">
             <div class="form-group">  
                  <label for="validateSelect">Select Username: </label>
                  <select name="username" id="username" class="form-control select2-input username">
                   <option value="">Please Select</option>
                  <?php $select = mysql_query("SELECT * FROM users WHERE role!='admin' and status!='disabled'"); 
				  
				  while($row = mysql_fetch_array($select)) {
				  ?>
                  <option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
                   <?php } ?>
                  </select>
                </div>
             </div>
             <!-- username -->
              <div class="col-sm-4">
             <div class="form-group" id="project_name_list">  
                  <label for="project_name">Select Project: </label>
                  <select name="project_name" id="project_name" class="form-control select2-input" >
                  <?php $selectp = mysql_query("SELECT * FROM project_list"); 
				  
				  while($rowp = mysql_fetch_array($selectp)) {
				  ?>
                  <option value="<?php echo $rowp['p_id']; ?>"><?php echo $rowp['project_name']; ?></option>
                   <?php } ?>
                  </select>
                </div>
                </div>
                <div class="col-sm-4">
                <div class="form-group">  
                 <label for="validateSelect">Select Task: </label>
                  <select name="task_name" id="task_name" class="form-control select2-input" >
                  <option value="">All</option>
                  </select>
                  </div>
                </div>
             
             
            <div class="col-sm-6">
             <div class="form-group">  
                  <label for="validateSelect">Select Month: </label>
                  <select name="month" class="form-control select2-input" >
                    <option value="">Please Select</option>
                    <option value="All">All</option>
                    <option value="Jan" <?php if (date('M') == "Jan") { ?> selected <?php } ?>>January</option>
                    <option value="Feb" <?php if (date('M') == "Feb") { ?> selected <?php } ?>>February</option>
                    <option value="Mar" <?php if (date('M') == "Mar") { ?> selected <?php } ?>>March</option>
                    <option value="Apr" <?php if (date('M') == "Apr") { ?> selected <?php } ?>>April</option>
                    <option value="May" <?php if (date('M') == "May") { ?> selected <?php } ?>>May</option>
                    <option value="Jun" <?php if (date('M') == "Jun") { ?> selected <?php } ?>>June</option>
                    <option value="Jul" <?php if (date('M') == "Jul") { ?> selected <?php } ?>>July</option>
                    <option value="Aug" <?php if (date('M') == "Aug") { ?> selected <?php } ?>>August</option>
                    <option value="Sep" <?php if (date('M') == "Sep") { ?> selected <?php } ?>>September</option>
                    <option value="Oct" <?php if (date('M') == "Oct") { ?> selected <?php } ?>>October</option>
                    <option value="Nov" <?php if (date('M') == "Nov") { ?> selected <?php } ?>>November</option>
                    <option value="Dec" <?php if (date('M') == "Dec") { ?> selected <?php } ?>>December</option>
                  </select>
                </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group"> 
                 <label for="validateSelect">Select Year: </label>
                  <select name="year" class="form-control select2-input" data-required="true">
                    <option value="">Please Select</option>
                    <?php
					$yr = date('Y');
					$sy = 2014;
					for($i=$sy;$i<=$yr;$i++) {
					?>
                    <option value="<?php echo $i; ?>" <?php if (date('Y') == $i) { ?> selected <?php } ?>><?php echo $i; ?></option>
                   <?php } ?>
                  </select>
                  </div>
                </div>
                
               
                
                 <div class="col-sm-12">
                 <input class="btn  btn-secondary"  type="submit" name="overall_report" id="submit" value="Submit"/>
                </div>
               
            </form>
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    
             

<?php
// find all attendence report based on years
if(isset($_POST['overall_report'])) {
	// information about overall work report without username
	$username = $_POST['username'];
	$project_name = $_POST['project_name'];
	$task_name =  $_POST['task_name'];
	$month  = $_POST['month'];
	$year = $_POST['year'];
	if($month=='All') {
		$month='%%';
	}
	
if(!empty($_POST['username'])) {
	
	// user details selection
	$user_select = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='".$username."'"));
	if(!empty($project_name)) {
		$sql = "SELECT * FROM work_report where username='".$username."' and project_name ='".$project_name."' and type_of_work like '%".$task_name."%' and 	report_date like '%%-$month-$year'";
	} else {
	$sql = "SELECT * FROM work_report where username='".$username."' and project_name like '%".$project_name."%' and type_of_work like '%".$task_name."%' and report_date like '%%-$month-$year'";
	}
	//echo $sql;
	$result = mysql_query($sql);
    $count = mysql_num_rows($result);
	
	// attendence selection based on /* username, month, year
		
		?>
     <div class="portlet">
        <div class="portlet-header">
            <h3> <i class="fa fa-info"></i> Overall Work Report Info </h3>
        </div>
        <div class="portlet-content"> 
            <p><strong>Username:</strong> <?php echo $user_select['username']; ?></p>
            <p><strong>Employee ID:</strong> <?php echo $user_select['employee_id']; ?></p>
            <p><strong>Attendance Report month/year:</strong> <?php if($month=='%%'){ echo "ALL"; } else { echo $month;} echo " / ".$year;?></p>
            <hr/>
            <?php
            	if($count > 0) { ?>
            <div class="table-responsive">

              <table 
                class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                data-provide="datatable" 
                data-display-rows="25"
                data-info="true"
                data-search="true"
                data-length-change="true"
                data-paginate="true"
              >
                  <thead>
                    <tr>
                     <th data-filterable="true" data-direction="asc" data-sortable="true" >#</th>
                      <th data-filterable="true" data-sortable="true">Project Name</th>
                      <th data-filterable="true" data-sortable="true">Task Name</th>
                      <th data-filterable="true" data-sortable="true">Total Records</th>
                      <th data-filterable="true" data-sortable="true">Comments</th>
                      <th data-filterable="true" data-sortable="true">Working Hours</th>
                      <th data-filterable="true" data-sortable="true">Report Date</th>
                    </tr>
                  </thead>
                  <tbody>
				<?php
				$tt = 0;
				$numm = 1;
                while($row = mysql_fetch_array($result)) {
					if($row['project_name'] == "Lunch" ||  $row['project_name'] =="Break") {
						$proj_name = "";
					} else {
					// project name get
					$pro_name = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$row['project_name']."'"));
					$proj_name = $pro_name['project_name'];
					}

					// task name get
					$taskk_name = mysql_fetch_array(mysql_query("SELECT * FROM project_task_list WHERE pt_id='".$row['type_of_work']."'"));
					if($proj_name)
					{
					?>
                     <tr>
                     <td><?php echo $numm; ?> </td>
                      <td><?php echo $proj_name; ?></td>
                      <td><?php echo $taskk_name['task_name']; ?></td>
                      <td><?php echo $row['total_records']; ?></td>
                      <td><?php echo $row['comments']; ?></td>
                      <td><?php echo $row['time_of_work']; ?></td>
                      <td><?php echo $row['report_date']; ?></td>
                      </tr>

              <?php
						
						$twt = strtotime($row['time_of_work']);
						$tt += $twt - strtotime('00:00:00'); 
						$numm +=1;
					}
                }
                ?>
                
                 </tbody>
                </table>
              </div> <!-- /.table-responsive -->
        <?php
	// display total complete and incomplete days
	$sec = seconds($tt);
	//$m = date('m',strtotime($month));
	//$tdm = cal_days_in_month(CAL_GREGORIAN,$m,$year);
	/*$th = 0;*/
	// calculate total holidays

	 $num_of_days = mysql_query($sql." GROUP BY report_date");
	$total_days = mysql_num_rows($num_of_days);
	?>
   <div class="alert alert-info">
		<strong><?php echo $total_days;?> - Total Number of Days</strong>
	</div>
    <div class="alert alert-info">
		<strong><?php echo $sec;?> - Total Working Hours</strong>
	</div>
    <?php
	} else {
		?>
         <div class="pricing-plan">
                    <div class="pricing-plan-header">
                      <h2 class="pricing-plan-title">No Work Report Found</h2>
                    </div> <!-- /.pricing-header -->
             </div>
        <?php
	}
	?>
    </div></div>
    <?php
} else {
	// without username to  filtering  project list
	$sql = "SELECT * FROM work_report where project_name ='".$project_name."' and type_of_work like '%".$task_name."%' and 	report_date like '%%-$month-$year'";
	$result = mysql_query($sql);
    $count = mysql_num_rows($result);
	$pro_name1 = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$project_name."'"));
	?>
	<div class="portlet">
        <div class="portlet-header">
            <h3> <i class="fa fa-info"></i> Overall Work Report Info </h3>
        </div>
        <div class="portlet-content"> 
            <p><strong>Project Name:</strong> <?php echo $pro_name1['project_name']; ?></p>
            <p><strong>Project Report month/year:</strong> <?php if($month=='%%'){ echo "ALL"; } else { echo $month;} echo " / ".$year;?></p>
            <hr/>
            <?php
            	if($count > 0) { ?>
            <div class="table-responsive">

              <table 
                class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                data-provide="datatable" 
                data-display-rows="25"
                data-info="true"
                data-search="true"
                data-length-change="true"
                data-paginate="true"
              >
                  <thead>
                    <tr>
                     <th data-filterable="true" data-direction="asc" data-sortable="true" >#</th>
                     <th data-filterable="true" data-sortable="true">Username</th>
                      <th data-filterable="true" data-sortable="true">Project Name</th>
                      <th data-filterable="true" data-sortable="true">Task Name</th>
                      <th data-filterable="true" data-sortable="true">Total Records</th>
                      <th data-filterable="true" data-sortable="true">Comments</th>
                      <th data-filterable="true" data-sortable="true">Working Hours</th>
                      <th data-filterable="true" data-sortable="true">Report Date</th>
                    </tr>
                  </thead>
                  <tbody>
				<?php
				$tt = 0;
				$numm = 1;
                while($row = mysql_fetch_array($result)) {
					if($row['project_name'] == "Lunch" ||  $row['project_name'] =="Break") {
						$proj_name = "";
					} else {
					// project name get
					$pro_name = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$row['project_name']."'"));
					$proj_name = $pro_name['project_name'];
					}

					// task name get
					$taskk_name = mysql_fetch_array(mysql_query("SELECT * FROM project_task_list WHERE pt_id='".$row['type_of_work']."'"));
					if($proj_name)
					{
					?>
                     <tr>
                     <td><?php echo $numm; ?> </td>
                     <td><?php echo $row['username']; ?> </td>
                      <td><?php echo $proj_name; ?></td>
                      <td><?php echo $taskk_name['task_name']; ?></td>
                      <td><?php echo $row['total_records']; ?></td>
                      <td><?php echo $row['comments']; ?></td>
                      <td><?php echo $row['time_of_work']; ?></td>
                      <td><?php echo $row['report_date']; ?></td>
                      </tr>

              <?php
						
						$twt = strtotime($row['time_of_work']);
						$tt += $twt - strtotime('00:00:00'); 
						$numm +=1;
					}
                }
                ?>
                
                 </tbody>
                </table>
              </div> <!-- /.table-responsive -->
        <?php
	// display total complete and incomplete days
	$sec = seconds($tt);
	//$m = date('m',strtotime($month));
	//$tdm = cal_days_in_month(CAL_GREGORIAN,$m,$year);
	/*$th = 0;*/
	// calculate total holidays

	$num_of_days = mysql_query($sql." GROUP BY report_date");
	$total_days = mysql_num_rows($num_of_days);
	?>
   <div class="alert alert-info">
		<strong><?php echo $total_days;?> - Total Number of Days</strong>
	</div>
    <div class="alert alert-info">
		<strong><?php echo $sec;?> - Total Working Hours</strong>
	</div>
    <?php
	} else {
		?>
         <div class="pricing-plan">
                    <div class="pricing-plan-header">
                      <h2 class="pricing-plan-title">No Work Report Found</h2>
                    </div> <!-- /.pricing-header -->
             </div>
        <?php
	}
	?>
    </div></div>
    <?php
	
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
<script>
 $(document).ready(function() {
	 
	 // project seslection 
 	$(".username").change(function() {
		var id=$(this).val();
		var dataString = 'q='+ id;
		$.ajax({
			type: "POST",
			url: "request/project.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#project_name").html(html);
			}
		});
	});
	// task selection
	$("#project_name").change(function() {
		var id=$(this).val();
		var dataString = 'q='+ id;
		$.ajax({
			type: "POST",
			url: "request/task.php",
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
