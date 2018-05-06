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

  <title><?php echo $settings['title']; ?> - Custom Markin/Markout Attendance</title>



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

        <h2 class="content-header-title">Custom Attendance</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>/">Home</a></li>

          <li><a href="<?php echo $conf_path;?>/attendance.php" title="Attendance">Attendance</a></li>

          <li class="active">Daily Attendance (Markin/ Markout)</li>

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

             <p> <strong>INDIA Time</strong> : <span id="clock" class="clockstyle"></span></p>

        

           </div>

 <?php

 // condition check for last punch out process

 $check_login = mysql_query("SELECT * FROM attendance WHERE username = '".$_SESSION['username']."' and signout_time = '0' and signin_date !='$date_now'");

 if(mysql_num_rows($check_login) != 0) {

	 header("location: $conf_path/last-attendance.php");

 }

 

 // work report filled condition check

 $report_check = mysql_query("SELECT * FROM attendance WHERE username ='".$_SESSION['username']."' ORDER BY aid DESC LIMIT 1");

 $fetch_info = mysql_fetch_array($report_check);

 $report_info = mysql_query("SELECT * FROM work_report WHERE username = '".$_SESSION['username']."' and report_date = '".$fetch_info['signin_date']."'");

 // Report check functionality

 $report_check_fun = mysql_num_rows($report_info);

 $fetch_info['signin_date'];

 if($report_check_fun == 0 and !empty($fetch_info['signin_date'])) {

	 // Report Not Completed

	 // Redirect to Work Report

	 $report_check_new = mysql_query("select * from attendance where username='".$_SESSION['username']."' and signout_time='0' and working_hours ='0' and status='1' and 	signin_date !='' ORDER BY aid DESC LIMIT 1");

if(mysql_num_rows($report_check_new) == 0) { 

	header("Location: $conf_path/my-work-status.php");

} 

	

 }

 ?>

 

 

 

 

 

           

<?php

// Custom markin Methods

if(isset($_POST['custom_markin'])) {

	

	$c_signin_time = $_POST['markin_time_hr'].":".$_POST['markin_time_min'];

	$c_signin_remarks = $_POST['c_markin_remarks'];

	

	// check signin condition

	$custom = mysql_query("SELECT * FROM attendance WHERE username='".$_SESSION['username']."' and signin_date='".$date_now."'");

	if(mysql_num_rows($custom) == 0 ) {

		

		/* login time grater than 9.15 check */	 

			$t1 = date("09:15");

			if($c_signin_time > $t1) {

				/* late punchin email */

				$email = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE username='".$_SESSION['username']."'" ));

				$headers = 'From: Techware Eoffice  <'.$conf_mail.'>' . "\r\n";

				$subject = "Late Custom Punchin Mail";

				$msg = "Late Custom Punchin Mail info

				------------------------------

				Username: ".$_SESSION['username']."

				punchin Time: $c_signin_time

				Late Reason: $c_signin_remarks

				------------------------------";

				// send email

				mail($hrmail,$subject,$msg,$headers);

			}

		 /* login time grater than 9.15 check */

		// CUSTOM PUNCHIN TIME SETTING FUNCTION
		if($c_signin_time == "00:00") {
			?>
            <div class="alert alert-danger" style="margin-left:15px; margin-right:16px;">
             <strong>Please enter custom markin time by using time picker</strong><br>
   Now you are not loggedIn.. Try again...
            </div>
            <?php
		} else {

		// insert custom signin details

		$insert_query = mysql_query("INSERT INTO attendance (`username`,`emp_id`,`signin_date`,`signin_time`,`signin_late_note`,`signout_time`,`signout_late_note`,`working_hours`,`status`,`pre_experience`,`punchin_type`,`punchout_type`,`custom_status`) VALUES ('".$_SESSION['username']."','".$users['emp_id']."', '".$date_now."','".$c_signin_time."','".$c_signin_remarks."','0','0','0','1','0','Custom Markin','','1')");

			if($insert_query) {
	
				?>
	
				<div class="alert alert-success" style="margin-left:15px; margin-right:16px;">
	
				  <strong>Custom Markin Successfuly</strong>
	
				</div>
	
				<?php
	
			}
		}

	} else {

		// already puchin today

		?>

        <div class="alert alert-info" style="margin-left:15px; margin-right:16px;">

              <strong>Already Markin Today</strong>

            </div>

        <?php

	}

}



// Custom Markout Methods

if(isset($_POST['custom_markout'])) {

	$c_signout_time = $_POST['markin_time_hr'].":".$_POST['markin_time_min'];

	$c_signout_remarks = $_POST['c_markin_remarks'];

	// check signin condition

	$custom = mysql_query("SELECT * FROM attendance WHERE username='".$_SESSION['username']."' and signin_date='".$date_now."' and status='1'");

	if(mysql_num_rows($custom) == 1) {

		//update custom punchout info

		$query1 = mysql_fetch_array($custom);

		if($query1['signin_time'] > $c_signout_time) {

			?>

              <div class="alert alert-warning" style="margin-left:15px; margin-right:16px;">

              <strong>Markin Time and Markout Time Issue</strong>

            </div>

            <?php

		} else {

		$working_hours_update = strtotime($c_signout_time) - strtotime($query1['signin_time']);

	 	// Seconds to time conversion

	 	$working_hours_time = gmdate("H:i",$working_hours_update);

		$update = mysql_query("UPDATE attendance SET signout_time='".$c_signout_time."', signout_late_note='".$c_signout_remarks."',working_hours='".$working_hours_time."',status='0',punchout_type='Custom Markout', `custom_status` = '1' WHERE username = '".$_SESSION['username']."' and signin_date = '".$date_now."'");

		if($update) {

			header("Location:my-work-status.php");

		} else {

			echo mysql_error();

		}

		}

	}

	

}





	$select_query = mysql_query("SELECT * FROM attendance WHERE username ='".$_SESSION['username']."' and signin_date= '$date_now'");

	$select_fetch = mysql_fetch_array($select_query);

	if(mysql_num_rows($select_query) == 1) {

		$status = $select_fetch['status'];

		if($status == 1)

		{

		?>

        <div class="alert alert-info" style="margin-left:15px; margin-right:16px;">

        <strong>Last punch In Time</strong> <?php if($select_fetch['punchin_type'] == "Custom Markin") { ?>(Custom)<?php } ?>:   <?php echo $select_fetch['signin_time']; ?>

   		</div>

<?php   } 

	}

?>           

           

           

 		<form method="post" style="float:left; width:100%"  data-validate="parsley" class="form parsley-form">

            <div class="col-sm-6 form-group">

                <label for="textarea-input">Time Picker : <em class="red-col">*</em></label>

                <div style="clear:both"></div>

                <table> <tr><td><select class="form-control" name="markin_time_hr" style="width:65px; float:left">

                 <?php $j = '00';

				while($j < '24') {

					if(strlen($j) == 1) {

						$j = '0'.$j;

						 echo "<option value='$j'>$j</option>";

					} else {

                echo "<option value='$j'>$j</option>";

					}

                $j += '01';} ?>

                </select></td> <td> &nbsp; : &nbsp; </td> <td><select class="form-control" name="markin_time_min" style="width:65px;">

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

            

             <?php

		if(mysql_num_rows($select_query) == 1) {

		$status = $select_fetch['status'];

		if($status == 1)

		{

		?>

         <div class="form-group col-sm-12">

          <button class="btn btn-success" disabled style="float:left" type="submit">

           	<i class="fa fa-sign-in"></i> Custom Mark in

           </button>

           

           

            <button class="btn btn-success" style="float:right"  type="submit" name="custom_markout">

             <i class="fa fa-sign-in"></i> Custom Mark out

             </button>

         </div>

    <?php } else {?>

         <div class="form-group col-sm-12">

           <button class="btn btn-success" type="submit" name="custom_markin" >

           	<i class="fa fa-sign-in"></i> Custom Mark in

           </button>

           

            <button class="btn btn-success" disabled style="float:right"  type="submit">

             <i class="fa fa-sign-in"></i> Custom Mark out

             </button>

          </div>

          <?php } } else { ?>	

          <div class="form-group col-sm-12">

           <button class="btn btn-success" type="submit" name="custom_markin" >

           	<i class="fa fa-sign-in"></i> Custom Mark in

           </button>

           

             <button class="btn btn-success" disabled style="float:right"  type="submit">

             <i class="fa fa-sign-in"></i> Custom Mark out

             </button>

          </div> <?php } ?>

          

          

             <div class="form-group col-sm-12">

             <label for="textarea-input">Remarks : <em class="red-col">*</em></label>

			 <textarea class="form-control " rows="3" cols="10" name="c_markin_remarks" data-required="true"  placeholder="Enter your Remarks" ></textarea>

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

  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>

  <script src="js/libs/bootstrap.min.js"></script>

  

<script>

// TIMER SCRIPT

$(window).load(function(){

var myVar=setInterval(function(){myTimer()},1000);



function myTimer() {

    var d = new Date();

    document.getElementById("clock").innerHTML = d.toLocaleTimeString();

}

});

</script>



	

 



  <!--[if lt IE 9]>

  <script src="./js/libs/excanvas.compiled.js"></script>

  <![endif]-->

  <!-- Plugin JS -->

   <!-- Plugin JS -->

  <script src="js/plugins/parsley/parsley.js"></script>

  <script src="js/plugins/icheck/jquery.icheck.js"></script>

  <script src="js/plugins/select2/select2.js"></script>

  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>

  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>

  <script src="js/plugins/autosize/jquery.autosize.min.js"></script>
<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- App JS -->

  <script src="js/target-admin.js"></script>

  <script src="js/worldtimer.js"></script>

   <!-- Plugin JS -->

  <script src="js/demos/form-extended.js"></script>

  





  

</body>

</html>

<?php

}

?>

