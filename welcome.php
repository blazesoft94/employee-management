<?php

ob_start();

session_start();

include_once("includes/config.php");

$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));

if(!(isset($_SESSION['username'])) and !(isset($_SESSION['password'])))

{

	header("Location: $conf_path/");

}

else

{

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
/*if($_SESSION['role'] != 'admin') { 
	header("Location:attendance.php");
}
*/
?>



<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Welcome</title>



  <meta charset="utf-8">

  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">



  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">

  <link rel="stylesheet" href="css/font-awesome.min.css">

  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">



  <!-- Plugin CSS -->

  <link rel="stylesheet" href="js/plugins/morris/morris.css">

  <link rel="stylesheet" href="js/plugins/icheck/skins/minimal/blue.css">

  <link rel="stylesheet" href="js/plugins/select2/select2.css">

  <link rel="stylesheet" href="js/plugins/fullcalendar/fullcalendar.css">



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



      



      <div>

       
      <div class="row">
      <div class="col-md-12">
       <h3 class="heading-inline">Welcome <?php echo $users['fname']."&nbsp;".$users['lname']; ?></h3>
       <hr/>
       <div class="clear"></div>
       </div>
		<div class="col-md-8">
       </div>
        
        
<!-- birthday notification part -->
		<div class="col-md-4">
        	<div class="col-md-12">
				<div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-file-text-o"></i>
                Birthday Information
              </h3>
            </div> <!-- /.portlet-header -->
            
       
            

            <div class="portlet-content panel-thread" style="overflow: hidden; padding-bottom:1px;" tabindex="5000">

<?php
$date_info = date('d');
$month_info = date('m');
// Today Birthday List
$select = mysql_query("SELECT * FROM users WHERE dob LIKE '%%%%-$month_info-$date_info'");
if(mysql_num_rows($select) > 0) {
?>
<p style="background:#444444;color: #ffffff;margin: -22px -15px 15px;padding: 10px;">Today Birthday</p>     
<ul class="panel-lists">

<?PHP
while($row = mysql_fetch_array($select)){
	?>
    <li>
                  <img class="panel-list-avatar" alt="Avatar" <?php if(!empty($row['image'])) { ?> src="<?php echo $conf_path."/".$row['image']; ?>" <?php } else { ?>src="<?php echo $conf_path."/uploads/avatar.png";?>" <?php } ?>>
                  <div class="panel-list-content">
                      <span class="panel-list-time"><a href="<?php echo $conf_path."/birthdays.php"; ?>"><i class="fa fa-external-link"></i></a></span>
                      <span class="panel-list-title" style="text-transform:capitalize"><?php echo $row['fname']; ?></span>
                      <span class="panel-list-meta"><?php echo date('d | M',strtotime($row['dob']));?></span>
                  </div>
                </li>
<?PHP } ?>
</ul>
<?PHP
}
?>
<?php
// Upcomming Birthday list
  $O_month = date('m');
  $T_month = date('m', strtotime("last day of next month"));
  if($T_month == "12") {
	  $TH_month = "01";
  }else if($T_month <= "11") {
	  $TH_month = $T_month + "01";
  }
  if(strlen($TH_month) == 1) {
	  $TH_month="0".$TH_month;
  }
  // another methods for getting months 
/* echo $date = date('m',strtotime('first day of +1 month'));
  echo $date = date('m',strtotime('first day of +2 month'));
*/
 //$upcomming = mysql_query("SELECT * FROM users WHERE dob >= '%-".$tomorrow."' and dob <= '%-".$endday."'");
$upcomming = mysql_query("SELECT * FROM `users` WHERE `dob` like '%-".$O_month."-%' or `dob` like '%-".$T_month."-%' or `dob` like '%-".$TH_month."-%' ORDER BY DAYOFYEAR(`dob`) < DAYOFYEAR(CURDATE()) , DAYOFYEAR(`dob`)");
if(mysql_num_rows($upcomming) > 0 ) {
	?>
    <p style="background:#6578ba;color: #ffffff;margin: -22px -15px 15px;padding: 10px;">Upcomming Birthdays</p>   
    <ul class="panel-lists" style="margin-bottom:0;">
    <?php
	while($info = mysql_fetch_array($upcomming)) {
		$aa = false;
		if(date('m') == date('m',strtotime($info['dob']))) {
			if(date('d') < date('d',strtotime($info['dob']))) {
				$aa= true;
			}
		} else {
			$aa= true;
		}
		if($aa == true) {
		?>
		<li>
                  <img class="panel-list-avatar" alt="Avatar" <?php if(!empty($info['image'])) { ?> src="<?php echo $conf_path."/".$info['image']; ?>" <?php } else { ?>src="<?php echo $conf_path."/uploads/avatar.png";?>" <?php } ?>>
                  <div class="panel-list-content">
                      
                      <span class="panel-list-title" style="text-transform:capitalize"><?php echo $info['fname']; ?></span>
                      <span class="panel-list-meta"><?php echo date('d | M',strtotime($info['dob']));?></span>
                  </div>
                </li>
                <?php } ?>
	<?php }
	?>
    </ul>
	<?php
} else {
	echo '<div class="alert alert-info"><p>No Upcoming Birthdays</p></div>';
}
?>                
              


            </div> <!-- /.portlet-content --> 

          </div>   
            </div>
            

    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
  <script>
  function loadonce () {
    /* LOAD MORE BOX SCRIPTS */
	$('.moreinfo').click(function() {
		var ID = $(this).attr("id");
		if(ID) {
			 $("#more"+ID).html('<p style="text-align:center"><i class="fa fa-spinner fa fa-spin"></i></p>');
			$.ajax({
				type: "POST",
				url: "<?php echo $conf_path; ?>/request/welcome.php",
				data: "loadmore="+ ID, 
				cache: false,
				success: function(html) {
					$("#loadinfo").append(html);
					$("#more"+ID).remove();
					loadonce();
				}
			});
		}
		return false;
	});
  }
  $(document).ready(function () {
	loadonce();
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

  <script src="js/libs/raphael-2.1.2.min.js"></script>

  <script src="js/plugins/morris/morris.min.js"></script>

  <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

  <script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>

  <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>



  <!-- App JS -->

  <script src="js/target-admin.js"></script>

  

  <!-- Plugin JS -->

  <script src="js/demos/dashboard.js"></script>

  <script src="js/demos/calendar.js"></script>

  <script src="js/demos/charts/morris/area.js"></script>

  <script src="js/demos/charts/morris/donut.js"></script>

</body>

</html>

<?php

}

?>

