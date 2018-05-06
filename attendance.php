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
  <title><?php echo $settings['title']; ?> - Daily Attendance</title>

  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- App CSS -->
  <link rel="stylesheet" href="css/target-admin.css">
  <link rel="stylesheet" href="css/custom.css">


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
        <h2 class="content-header-title">Daily Attendance</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>/">Home</a></li>
          <li><a href="<?php echo $conf_path;?>/attendance.php" title="Attendance">Attendance</a></li>
          <li class="active">Daily Attendance</li>
        </ol>
      </div> <!-- /.content-header -->

<!-- ATTENDANCE PAGE FUNCTIONAALITY START-->

<div class="row">
  <div class="col-md-12">
 	<div class="col-md-8">
  <?php
  // TODAY TIME GET FUNCTION - SERVER TIME
  $date_now = date("d-M-Y");

  ?>
 
  <div class="wall">
          <div style="margin-left:15px;">
             <h4>Attendance for the day : <span class="text-primary"><?php echo $date_now;?></span> </h4>
             <p> <strong>INDIA</strong> : <span id="clock" class="clockstyle"></span></p>
        
           </div>
           
 		<form method="post" style="float:left; width:100%"  data-validate="parsley" class="form parsley-form">
 <!-- Part 1 -->
 <?PHP

$check_login = mysql_query("SELECT * FROM attendance WHERE username = '".$_SESSION['username']."' and signout_time = '0' and signin_date !='$date_now'");
$login = mysql_fetch_array($check_login);
$login_check_row = mysql_num_rows($check_login);
$attendance_id  = $login['aid'];
// Shift timing check
$shift_time = mysql_fetch_array(mysql_query("SELECT * FROM shift_time WHERE shift_no = '".$users['shift_id']."'"));
include_once("resources/signin-signout.php");
// Check query execute or not
?>

<?php
if($login_check_row == 0)
{
	// Query not execute
	$select_query = mysql_query("SELECT * FROM attendance WHERE username ='".$_SESSION['username']."' and signin_date= '$date_now'");
	$select_fetch = mysql_fetch_array($select_query);
	$select_rows = mysql_num_rows($select_query);
	// Status and Working hour check
	
	$status = $select_fetch['status'];
	$working_hours = $select_fetch['working_hours'];
	?>
    
    <?php
	// Check status
	if($status == 1)
	{
		?>
         <div class="form-group col-sm-12">
        <?php  $time_check = date("G:i");
		 $working_hours_update = strtotime($time_check) - strtotime($select_fetch['signin_time']);
	 // Seconds to time conversion
	    $working_hours_time = gmdate("H:i",$working_hours_update); ?>
        <p> <strong>Working Hours</strong> : <?php echo $working_hours_time; ?></p>
        <div class="alert alert-warning" style="margin-bottom:0px;">
        <strong>Last punch In Time: </strong> <?php echo $select_fetch['signin_time']; ?>
   		</div>
        </div>
        <div class="form-group col-sm-6">
           		<button class="btn btn-success" disabled type="submit" name="c_signin" >
           		<i class="fa fa-sign-in"></i> Mark in
           		</button>
        	 </div> 
             <?php 
             // next to next punchin avoid  by using working hour based calculation
			 ?>
         <div class="form-group col-sm-6">
           <button class="btn btn-success" style="float:right" <?php if($working_hours_time < "00:05") { ?> disabled <?php } ?> type="submit" name="c_signout" >
           	<i class="fa fa-sign-in"></i> Mark out
           </button>
        </div> 
       
        
        
        <div class="form-group col-sm-12">
        <label for="textarea-input">Remarks :</label>
		<textarea class="form-control " rows="3" cols="10" name="c_signout_remarks" placeholder="Enter your Remarks" ></textarea>
        </div>

		
        
        <?php
		
	}
	else
	{
		// Signin
		$select_query_1 = mysql_query("SELECT signin_date FROM attendance WHERE username ='".$_SESSION['username']."' ORDER BY aid DESC LIMIT 1");
		$select_fetch_1 = mysql_fetch_array($select_query_1);
		$report_check = mysql_query("SELECT * FROM work_report WHERE username = '".$_SESSION['username']."' and report_date = '".$select_fetch_1['signin_date']."'");
		// Report check functionality
		$report_check_fun = mysql_num_rows($report_check);
		
		// Checking Work Report
		
		if($report_check_fun == 0 and !empty($select_fetch_1['signin_date']))
		{
			// Report Not Completed
			// Redirect to Work Report
			header("Location: $conf_path/my-work-status.php");
		}
		else
		{
			$signin_time2 = date("H:i");
			$t11 = date("09:15");
			if(!empty($working_hours))
			 {
				 ?>
                  <div class="alert alert-warning" style="margin-left:15px; margin-right:16px;">
			        <strong>Next Punchin Tomorrow : </strong> Please Co-operate.
                  </div>
                 <?php
			 }
				?>
              <div class="form-group col-sm-6">
           		<button class="btn btn-success" type="submit" name="c_signin" >
           		<i class="fa fa-sign-in"></i> Mark in
           		</button>
        	 </div> 
             <div class="form-group col-sm-6">
          		<button class="btn btn-success"  style="float:right" disabled type="submit" name="c_signout" >
           		<i class="fa fa-sign-in"></i> Mark out
           		</button>
        	</div> 
                 <div class="form-group col-sm-12">
            		<label for="textarea-input">Remarks</label>
            		<textarea class="form-control " <?php if($signin_time2 > $t11) { ?> data-required="true" <?php } ?> rows="3" cols="10" name="c_signin_remarks" placeholder="Enter your Remarks" ></textarea>
            	</div>
              
			
             <?php
		}
	}
}
else
{
	// Query execute
	header("location: $conf_path/last-attendance.php");
}



 
 ?>
    
            
            
           		<!--<div class="form-group col-sm-12">
                    <label for="textarea-input">Remarks</label>
                    <textarea class="form-control " rows="3" cols="10" name="c_signin_remarks" id="textarea-input" placeholder="Enter your Remarks" ></textarea>
                </div>
            	<div class="form-group col-sm-6">
               		<button class="btn btn-success" type="submit" name="c_signin" >
                		<i class="fa fa-sign-in"></i> Sign in
             		 </button>
          		 </div>-->
                 <div class="form-group col-sm-12">
               		<p align="center"><button class="btn btn-info" onClick="location.href='custom-attendance.php'"  type="button">
                		<i class="fa fa-sign-in"></i> Custom
             		 </button>
                     </p>
                 </div>
           </form>
           
          		
          </div>
     </div>  
   
<?php
$anounce = mysql_query("SELECT * FROM announcement WHERE display_from <='".date("Y-m-d")."' ORDER BY ann_id DESC LIMIT 4");
if(mysql_num_rows($anounce) > 0) {
?>
     <div class="col-md-4">
     <!-- announcement ionfo -->
         <div class="portlet">
            <div class="portlet-header">
              <h3><i class="fa fa-file-text-o"></i> Announcement</h3>
            </div> <!-- /.portlet-header -->
           <div class="portlet-content panel-thread scrollable-panel" style="padding-bottom:1px;">
               <ul class="panel-lists" style="margin-bottom:0;">
               <?php while($ann = mysql_fetch_array($anounce)) {
               echo '<li>
                <div class="panel-list-content" style="margin-left:0;">
               	<span class="panel-list-title announcement">'.$ann['title'].'</span>
				<p>'.$ann['content'].'</p>
                <span class="panel-list-meta">'.$ann['display_from'].' - '.$ann['display_to'].'</span>
                </div>
                </li>';
				   
			    }?>
               </ul>
           </div>
            
      <!-- announcement ionfo -->
     </div>
<?php 
} ?>
 
  </div>
</div>

<!-- // ATTENDANCE PAGE FUNCTIONAALITY END-->
     
   <div class="row">
<div class="col-md-12">
<hr/>
<table class="flags_style">
<tr>
	<td>US CST<br><img src="img/flag/United-states.png" alt="us"/><br/><span id="Chicago"></span></td>
    <td>US PST<br><img src="img/flag/United-states.png" alt="us"/><br><span id="SanFrancisco"></span></td>
    <td>US EST<br><img src="img/flag/United-states.png" alt="us"/><br><span id="NewYork"></span></td>
    <td>London<br><img src="img/flag/England.png" alt="London"/><br><span id="London"></span></td>
    <td>France<br><img src="img/flag/France.png" alt="France"/><br><span id="Paris"></span></td>
    <td>Germany<br><img src="img/flag/Germany.png" alt="Germany"/><br><span id="Berlin"></span></td>
    <td>Italy<br><img src="img/flag/Italy.png" alt="Italy"/><br><span id="Rome"></span></td>
    <td>Singapore<br><img src="img/flag/Singapore.png" alt="Singapore"/><br><span id="HongKong"></span></td>
    <td>Australia<br><img src="img/flag/Australia.png" alt="Australia"/><br><span id="Sydney"></span></td>
</tr> 
</table>  
<hr/>
</div></div>
   
   
   
   
   

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->



<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
  
<script>
// TIMER SCRIPT
$(window).load(function(){
var myVar = setInterval(function(){getval()},1000);
function getval() {
            var currentTime = new Date();
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
			var sec = currentTime.getSeconds();
			if (hours < 10) {
                hours = "0" + hours;
			}
            if (minutes < 10) {
                minutes = "0" + minutes;
			}
			if (sec < 10) {
                sec = "0" + sec;
			}
            var current_time = hours + ":" + minutes + ":" + sec;
			 document.getElementById("clock").innerHTML = current_time;
        }
/*function myTimer() {
    var d = new Date();
    document.getElementById("clock").innerHTML = d.toLocaleTimeString();
}*/
});
</script>

	
  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
   <!-- Plugin JS -->
  <script src="js/plugins/parsley/parsley.js"></script>
  <script src="js/plugins/icheck/jquery.icheck.js"></script>
  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>
 <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
  <script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="js/plugins/select2/select2.js"></script>
  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  <script src="js/worldtimer.js"></script>
  


  
</body>
</html>
<?php
}
?>
