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
  <title><?php echo $settings['title']; ?> - Emergency Last Attendance</title>

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
  <link rel="stylesheet" href="js/plugins/timepicker/bootstrap-timepicker.css">

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
        <h2 class="content-header-title">Emergency Attendance</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>/">Home</a></li>
          <li><a href="<?php echo $conf_path;?>/attendance.php" title="Attendance">Attendance</a></li>
          <li class="active">Last Emergency Attendance</li>
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
 <!-- Part 1 -->
 <?PHP
// Shift timing check
$check_login = mysql_query("SELECT * FROM emergency_attendance WHERE username = '".$_SESSION['username']."' and signout_time = '0' and signin_date !='$date_now'");
$login = mysql_fetch_array($check_login);
$login_check_row = mysql_num_rows($check_login);
if($login_check_row == 0)
{
	//header("Location: $conf_path/emergency-attendance.php");
}

$attendance_id  = $login['e_id'];
$attendance_date  = $login['signin_date'];

if(isset($_POST['emergency_markout']))
{
	// SUBMIT BUTTON PRESSED
	$remarks = mysql_real_escape_string($_POST['remarks']);
	$markout_time = $_POST['markout_time_hr'].":".$_POST['markout_time_min'];
	if($login['signin_time'] > $markout_time) {
			?>
              <div class="alert alert-warning" style="margin-left:15px; margin-right:16px;">
              <strong>Markin Time and Markout Time Issue</strong>
            </div>
            <?php
	} else {
	// USER CANNOT SIGNOUT PROPPER DEFAULT TIME TO BE ASSIGNED TO LOGOUT TIME
	$working_hours_update = strtotime($markout_time) - strtotime($login['signin_time']);
	$working_hours_time = gmdate("H:i",$working_hours_update);	
	$update_info = mysql_query("UPDATE emergency_attendance SET signout_time ='".$markout_time."', signout_reason = '".$remarks."', working_hours = '".$working_hours_time."', status ='0', custom_status='1' where username = '".$_SESSION['username']."' and e_id = '".$attendance_id."' and signin_date='".$attendance_date."'");
	if($update_info) {
		//header("Location: $conf_path/emergency-work-status.php");
	} else {
		echo mysql_error();
	}
	}
	
}

?>
  <div class="wall">
          <div class="col-sm-12">
             <h4>Attendance for the day : <span class="text-primary"><?php echo $attendance_date;?></span> </h4>
             <p> <strong>INDIA</strong> : <span id="clock" class="clockstyle"></span></p>
        
           </div>
 		<form method="post" action="#"  data-validate="parsley" class="form parsley-form">
			<div class="col-sm-6 form-group">
                <label for="textarea-input">Time Picker : <em class="red-col">*</em></label>
                <table> <tr><td><select class="form-control" name="markout_time_hr" style="width:65px; float:left">
                 <?php $j = '00';
				while($j < '24') {
					if(strlen($j) == 1) {
						$j = '0'.$j;
						 echo "<option value='$j'>$j</option>";
					} else {
                echo "<option value='$j'>$j</option>";
					}
                $j += '01';} ?>
                </select></td> <td> &nbsp; : &nbsp; </td> <td><select class="form-control" name="markout_time_min" style="width:65px;">
                <?php $i = '00';
				while($i < '61') {
					if(strlen($i) == 1) {
						$i = '0'.$i;
						 echo "<option value='$i'>$i</option>";
					} else {
                echo "<option value='$i'>$i</option>";
					}
                $i += '01';} ?>
                </select></td> </tr></table>
            </div> <!-- /.col -->
            
			<div class="form-group col-sm-12">
           <button class="btn btn-success" disabled type="submit" >
           	<i class="fa fa-sign-in"></i> Emergency Mark in
           </button>
           
           
            <button class="btn btn-success" style="float:right"  type="submit" name="emergency_markout">
             <i class="fa fa-sign-in"></i> Emergency Mark out
             </button>
         </div>
         
            <div class="form-group col-sm-12">
			 <textarea class="form-control " rows="3" cols="10" name="remarks"  placeholder="Enter your Remarks" data-required="true" ></textarea>
            </div>
            
		 	
            <div class="form-group col-sm-12">
                <div class="alert alert-warning">
                    <strong>Last punch In Date/Time: </strong> <?php echo $login['signin_date']."/".$login['signin_time']; ?>
                </div>
            </div>
           </form>
           
          </div>
     </div>  
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
var myVar=setInterval(function(){getval()},1000);
function getval() {
            var currentTime = new Date()
            var hours = currentTime.getHours()
            var minutes = currentTime.getMinutes()
			var sec = currentTime.getSeconds()
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
  <script src="js/plugins/select2/select2.js"></script>
  <!-- App JS -->
  <script src="js/target-admin.js"></script>
   <script src="js/worldtimer.js"></script>
  <script src="js/demos/form-extended.js"></script>
  


  
</body>
</html>
<?php
}
?>
