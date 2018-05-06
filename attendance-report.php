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
  <title><?php echo $settings['title']; ?> - My  Attendance Report</title>

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
        <h2 class="content-header-title">My Attendance status</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">My Attendance</li>
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
            <form class="col-sm-6" method="post">
            <div class="col-sm-6">
             <div class="form-group">  
                  <label for="validateSelect">Select Month: </label>
                  <select name="month" class="form-control select2-input" data-required="true">
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
                
               
                
                 <div class="col-sm-6">
                 <input class="btn  btn-secondary"  type="submit" name="submit" id="submit" value="Submit"/>
                </div>
               
            </form>
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    
             
<?php
// find all attendence report based on years
if(isset($_POST['submit'])) {
	$username = $_SESSION['username'];
	$month  = $_POST['month'];
	$year = $_POST['year'];
	$hmonth = date('m',strtotime($month));
	$hyear = date('Y',strtotime($year));
	// user details selection
	$user_select = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='".$username."'"));
	// attendence selection based on /* username, month, year
	$select_q = mysql_query("SELECT * FROM attendance WHERE username='".$username."' AND signin_date LIKE '%%-$month-$year' order by signin_date");
	$count = mysql_num_rows($select_q);
	
	// select holiday list
	$holiday = mysql_query("SELECT * FROM holiday_list where h_date LIKE '$hyear-$hmonth-%%'");
	$h_count = mysql_num_rows($holiday);
	
	// TOTAL NUMBER OF DAYS CALCULATE
	$m = date('m',strtotime($month));
	if(($month == date('M')) and ($year == date('Y'))) {
		$tdm = date('d');
	} else {
		$tdm = cal_days_in_month(CAL_GREGORIAN,$m,$year);
	}
	
			
	
		
		?>
     <div class="portlet">
        <div class="portlet-header">
            <h3> <i class="fa fa-info"></i> Users Attendance Report Info </h3>
        </div>
        <div class="portlet-content"> 
            <p><strong>Username:</strong> <?php echo $user_select['username']; ?></p>
            <p><strong>Employee ID:</strong> <?php echo $user_select['employee_id']; ?></p>
            <p><strong>Attendance Report month/year:</strong> <?php echo $month."/".$year;?></p>
            <hr/>
            <?php if($count > 0) { ?>
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
                     <th data-filterable="true" data-direction="asc" data-sortable="true" >#</th>
                      <th data-filterable="true" data-sortable="true">Signin Date</th>
                      <th data-filterable="true" data-sortable="true">Signin Time</th>
                      <th data-filterable="true" data-sortable="true">Signout Time</th>
                      <th data-filterable="true" data-sortable="true">Working Hours</th>
                      <th data-filterable="true" data-sortable="true">Signin Note</th>
                      <th data-filterable="true" data-sortable="true">Signout Note</th>
                      <th data-filterable="true" data-sortable="true">Status</th>
                    </tr>
                  </thead>
                  <tbody>
				<?php
				$cd = 0;
				$icd = 0;
				$ogd = 0;
				$tt = 0;
				$numm = 1;
				$lp = 0;
				$ld =0;
				$hds = 0;
				/* New implementation for all attendance management start */
				$j = '01';
				$START_D = $tdm+1;
				while($j < $START_D) {
					if(strlen($j) == 1) { $j = '0'.$j; } else { $j = $j;}
					$display_date = $j."-".$month."-".$year;
					$holiday_list = $hyear."-".$hmonth."-".$j;
					$select_q = mysql_query("SELECT * FROM attendance WHERE username='".$username."' AND signin_date LIKE '".$display_date."'");
					if(mysql_num_rows($select_q) == 1) {
						// working days
						$row = mysql_fetch_array($select_q);
						?>
                     <tr <?php if(!empty($row['punchin_type']) || !empty($row['punchout_type'])) { ?> class="green" <?php } ?>>
                      <td><?php echo $numm; ?> </td>
                      <td><?php echo $row['signin_date']; ?></td>
                      <td><?php echo $row['signin_time']; ?></td>
                      <td><?php echo $row['signout_time']; ?></td>
                      <td><?php echo $row['working_hours']; ?></td>
                      <td><?php echo $row['signin_late_note']; ?></td>
                      <td><?php echo $row['signout_late_note']; ?></td>
                      <td> <?php if(strtotime($row['working_hours']) != 0) {
						$ct = strtotime("08:30");
						$wk = strtotime($row['working_hours']);
						$tt+=strtotime($row['working_hours'])-strtotime('00:00'); 
						if($wk < $ct) {
							$icd +=1;
							?>
							 <span class="label label-danger">Incomplete</span>
							<?php
						} else {
							$cd +=1;
							?>
							<span class="label label-success">Complete</span>
							<?php
						}
					} else {
						$ogd +=1;
						?>
						<span class="label label-secondary">Ongoing</span>
						<?php
					} ?> 
                    <?php 
					  // late punchin mention
					  if(strtotime($row['signin_time']) > strtotime('09:15')) {?> <i class="fa fa-exclamation-circle" style="color: red;"></i><?php $lp +=1;}					
					  ?>
                        
                	  </td>  </tr>
                        <?php
					} else {
						// leave days
						$holiday = mysql_query("SELECT * FROM holiday_list where h_date LIKE '".$holiday_list."'");
						if(mysql_num_rows($holiday) == 1) {
							$display_leave ='<span class="label holiday-info"><i class="fa fa-info-circle"></i> Holiday</span>';
							$class_info ='';
							$hds +=1;
						} else {
							$display_leave ='<span class="label label-danger"><i class="fa fa-info-circle"></i> Leave</span>';
							$class_info ='class="redd"';
							$ld +=1;
						}
						?>
						<tr <?php echo $class_info; ?>>
                          <td><?php echo $numm; ?> </td>
                          <td><?php echo $display_date; ?></td>
                          <td> - </td>
                          <td> - </td>
                          <td> - </td>
                          <td> - </td>
                          <td> - </td>
                          <td> <?php echo $display_leave; ?></td>
                         </tr>
                      <?php
					}
					// LOOP INCREMENT
					$numm +=1;
					$j += '01';
				} 
				/* New implementation for all attendance management end */
                ?>
                
                 </tbody>
                </table>
              </div> <!-- /.table-responsive -->
        <?php
	// display total complete and incomplete days
	$sec = seconds($tt);
	// display total days info
	?>
	<div class="alert alert-danger">
		<strong><?php echo $icd;?> - Incomplete Days</strong>
	</div>
    <div class="alert alert-danger">
		<strong><?php echo $lp;?> - Late Punchin Days</strong>
	</div>
    <div class="alert alert-success">
		<strong><?php echo $cd;?> - complete Days</strong>
	</div>
    <div class="alert alert-info">
		<strong><?php echo $ld;?> - Total Leave</strong>
	</div>
   <div class="alert alert-info">
		<strong><?php echo $hds;?> - Total Holidays</strong>
	</div>
    <div class="alert alert-info">
		<strong><?php echo $sec;?> - Total Working Hours</strong>
	</div>
    <?php
	} else {
		
		// All Attendence Report Else Statement	
		?>
        <div class="pricing-plan">
                    <div class="pricing-plan-header">
                      <h2 class="pricing-plan-title">No Attendance Report Found</h2>
                    </div> <!-- /.pricing-header -->
             </div>
        <?php
		
	}
	?>
    </div> </div>
    <?php
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
