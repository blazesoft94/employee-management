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
  <title><?php echo $settings['title']; ?> - My  Work Report</title>

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
        <h2 class="content-header-title">My Work Report</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">My Work Report</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
<div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
               Select month and year to generate report
              </h3>

            </div>
            <div class="portlet-content"> 
            <form class="col-sm-6" method="post" data-validate="parsley">
            <div class="col-sm-6">
             <div class="form-group">  
                  <label for="validateSelect">Select Date: </label>
                  <select name="select-2" class="form-control select2-input" data-required="true">
                    <option value="">Please Select</option>
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
                  <select name="select-1" class="form-control select2-input" data-required="true">
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
                
               
                <div class="form-group">
                 <div class="col-sm-12">
                  <label>Report Methods:</label>
                  </div>
                  <div class="col-sm-6">
                      <div class="radio">
                        <label class="parsley-success">
                          <input type="radio" checked data-required="true" class="parsley-validated" value="summary_report" name="radio-1">
                          Summary Report
                        </label>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="radio">
                        <label class="parsley-success">
                          <input type="radio" data-required="true" class="parsley-validated" value="detailed_report" name="radio-1">
                          Detailed Report
                        </label>
                      </div>
                  </div>
                </div>
                 <div class="col-sm-6">
                 <input class="btn  btn-secondary"  type="submit" name="submit" id="submit" value="Submit"/>
                </div>
               
            </form>
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    
             
<?php
if(isset($_POST['submit'])) {
	$mon = $_POST['select-2'];
	$year = $_POST['select-1'];
	
	if($_POST['radio-1'] == "detailed_report") {
			$query = mysql_query("select * from attendance where username='".$_SESSION['username']."' and signin_date like '%%-$mon-$year'");
			$success = mysql_num_rows($query);
			?>
            <div class="portlet">
                <div class="portlet-header">
                    <h3> <i class="fa fa-info"></i> Detailed Report Info </h3>
                </div>
                <div class="portlet-content"> 
                    <p><strong>Username:</strong> <?php echo $users['username']; ?></p>
                    <p><strong>Employee ID:</strong>  <?php echo $users['employee_id']; ?></p>
                    <p><strong>Report month/year:</strong> <?php echo $mon."/".$year;?></p>
                    <hr/>
			<?php
			if($success > 0) {
?>             
             <!-- attendance Detailed Report  info --> 
         <div class="table-responsive">
              <table 
                class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                data-provide="datatable" 
                data-display-rows="10"
                data-info="true"
                data-search="true"
                data-length-change="true"
                data-paginate="true"
              >
                  <thead>
                    <tr>
                      <th data-direction="asc" data-filterable="true">Report Date</th>
                      <th data-filterable="false" data-sortable="true">Signin Time</th>
                      <th data-filterable="false" data-sortable="true">Signout Time</th>
                       <th  data-filterable="false" data-sortable="true">Working Hours</th>
                      <th data-filterable="false" data-sortable="true">Punchin Note</th>
                      <th data-filterable="false" data-sortable="true">Punchout Note</th>
                      <th data-filterable="true" data-sortable="true">Status</th>
                      <th data-filterable="false">Report Info</th>
                    </tr>
                  </thead>
                  <tbody>
			<?php while($row = mysql_fetch_array($query)) {
					$select3 = mysql_query("select * from work_report where username='".$_SESSION['username']."' and report_date='".$row['signin_date']."'");
					$tid = 	$row['aid'];
					
					 ?>
            		

                   <tr <?php if(!empty($row['punchin_type']) || !empty($row['punchout_type'])) { ?> class="green" <?php } ?> >
                      <td><?php echo $row['signin_date']; ?></td>
                      <td><?php echo $row['signin_time']; ?></td>
                      <td><?php echo $row['signout_time']; ?></td>
                      <td><?php echo $row['working_hours']; ?></td>
                      <td><?php echo $row['signin_late_note']; ?></td>
                      <td><?php echo $row['signout_late_note']; ?></td>
                      <td>
			<?php if($row['working_hours'] != 0 and $row['signout_time'] !=0) {
                        $ct = strtotime("08:30:00");
                        $wk = strtotime($row['working_hours']);
                        if($wk < $ct) {
                            ?>
                             <span class="label label-danger">Incomplete</span>
                            <?php
                        } else {
                            ?>
                            <span class="label label-success">Complete</span>
                            <?php
                        }
                    } else {
                        ?>
                        <span class="label label-secondary">Ongoing</span>
                        <?php
                    } ?>   
                	</td>
                      <td><span class="label label-secondary reporter" style="cursor:pointer" title="<?php echo $tid;?> "><i class="fa fa-hand-o-up"></i> Info</span></td>
                    </tr>
                    
                    <tr class="report" id="<?php echo $tid;?>">
                    <td colspan="8">
                    <!-- Project Info -->
                    <table class="table table-bordered">
                    <thead>
                    	<tr class="report_style">
                        	<td colspan="2">Project Name</td>
                            <td>Type of Work</td>
                            <td>Time of Work</td>
                            <td>Tot Records</td>
                            <td colspan="2">Comments</td>
                            <td>Report date</td>
                        </tr>
                     </thead>
                     <tbody>
                     <?php while($rows = mysql_fetch_array($select3)) { 
					 
					 
					 if($rows['project_name'] == "Lunch" ||  $rows['project_name'] =="Break") {
						$proj_name = $rows['project_name'];
					} else {
					// project name get
					$pro_name = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$rows['project_name']."'"));
					$proj_name = $pro_name['project_name'];
					}				
					// task anme get
					$task_name = mysql_fetch_array(mysql_query("SELECT * FROM project_task_list WHERE pt_id='".$rows['type_of_work']."'"));
					 ?>
                     	<tr>
                        	<td colspan="2"><?php echo $proj_name; ?></td>
                            <td><?php echo $task_name['task_name']; ?></td>
                            <td><?php echo $rows['time_of_work']; ?></td>
                            <td><?php echo $rows['total_records']; ?></td>
                            <td><?php echo $rows['comments']; ?></td>
                            <td colspan="2"><?php echo $rows['report_date']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                     </table>
                     
                    <!-- Project Info -->
                    </td>
                    </tr>
                    <?php  } ?>
                 </tbody>
                </table>
 		</div>
        <?php } else {
			?>
              <div class="pricing-plan">
                    <div class="pricing-plan-header">
                      <h2 class="pricing-plan-title">No Detailed Report Found</h2>
                    </div> <!-- /.pricing-header -->
             </div>
            <?php
	  } ?>
    </div>
</div>  
<!-- attendance Detailed Report  info --> 
<?php
 	} // Detailed Report End
	
	if($_POST['radio-1'] == "summary_report") {
			$query = mysql_query("select * from attendance where username='".$_SESSION['username']."' and signin_date like '%%-$mon-$year'");
			$success = mysql_num_rows($query);
			?>
            <div class="portlet">
                <div class="portlet-header">
                    <h3> <i class="fa fa-info"></i> Summary Report Info </h3>
                </div>
                <div class="portlet-content"> 
                <p><strong>Username:</strong> <?php echo $users['username']; ?></p>
        <p><strong>Employee ID:</strong>  <?php echo $users['employee_id']; ?></p>
        <p><strong>Report month/year:</strong> <?php echo $mon."/".$year;?></p>
        <hr/>
            <?php
			if($success > 0) {
?>             
             <!-- attendance Detailed Report  info --> 

    	
         <div class="table-responsive">
              <table 
                class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                data-provide="datatable" 
                data-display-rows="31"
                data-info="true"
                data-search="true"
                data-length-change="true"
                data-paginate="true"
              >
                  <thead>
                    <tr>
                      <th data-direction="asc" data-filterable="true">Report Date</th>
                      <th data-filterable="false" data-sortable="true">Signin Time</th>
                      <th data-filterable="false" data-sortable="true">Signout Time</th>
                      <th  data-filterable="false" data-sortable="true">Working Hours</th>
                      <th data-filterable="false" data-sortable="true">Punchin Note</th>
                      <th data-filterable="false" data-sortable="true">Punchout Note</th>
                    </tr>
                  </thead>
                  <tbody>
			<?php while($row = mysql_fetch_array($query)) {?>
                   <tr  <?php if(!empty($row['punchin_type']) || !empty($row['punchout_type'])) { ?> class="green" <?php } ?>>
                      <td><?php echo $row['signin_date']; ?></td>
                      <td><?php echo $row['signin_time']; ?></td>
                      <td><?php echo $row['signout_time']; ?></td>
                      <td><?php echo $row['working_hours']; ?></td>
                      <td><?php echo $row['signin_late_note']; ?></td>
                      <td><?php echo $row['signout_late_note']; ?></td>
                    </tr>
             <?php  } ?>
                 </tbody>
                </table>
 		</div>
        <?php } else {
			?>
            <div class="pricing-plan">
                    <div class="pricing-plan-header">
                      <h2 class="pricing-plan-title">No Summary report found</h2>
                    </div> <!-- /.pricing-header -->
             </div>
            <?php
	  }
	  ?>
        
        
    </div>
</div>  
<!-- attendance Detailed Report  info --> 
<?php

 	} // Summary Report End
 
 
} // submit function complete
 
 ?>        
             
             
             
             
        
   </div> <!-- /.col -->

      </div> <!-- /.row -->

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
	  $('.reporter').click(function(){
		  var a = $(this).attr('title');
		  $('#'+a).fadeToggle('fast');
		  
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
}
?>
