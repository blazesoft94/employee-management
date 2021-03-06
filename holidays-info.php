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
  <title><?php echo $settings['title']; ?> - Holiday</title>

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
  <link rel="stylesheet" href="js/plugins/datepicker/datepicker.css">
  <link rel="stylesheet" href="js/plugins/select2/select2.css">
  <link rel="stylesheet" href="js/plugins/fullcalendar/fullcalendar.css">
  <link rel="stylesheet" href="js/plugins/timepicker/bootstrap-timepicker.css">
  <link rel="stylesheet" href="js/plugins/fileupload/bootstrap-fileupload.css">
  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.css">
  <link rel="stylesheet" href="js/plugins/magnific/magnific-popup.css">

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
        <h2 class="content-header-title">Holiday List</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">
        <div class="col-sm-12">
        <div class="col-sm-12">
         <div class="portlet">
            <div class="portlet-header">
              <h3><i class="fa fa-tasks"></i>Holiday List calender</h3>
               <button class="btn btn-success" type="button" onClick="location.href='apply-leave.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-left"></i> Go Back</button>
            </div> <!--  /.portlet-header -->
           <div class="portlet-content">
             <div id="calendar"></div>
            </div>  <!-- /.portlet-content -->
          </div><!-- /.portlet -->
  </div> <!-- /.col -->




        

      </div> <!-- /.row -->

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
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
  <script>
Date.prototype.yyyymmdd = function() {
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
		var dd  = this.getDate().toString();
	   return yyyy +"-"+ (mm[1]?mm:"0"+mm[0]) +"-"+ (dd[1]?dd:"0"+dd[0]); // padding
    };
 $(document).ready(function() {
 var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var calendar = $('#calendar').fullCalendar({
   editable: true,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month'
   },
    
   events: "resources/holiday_list.php",
   
   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
	/* Today Date style */
	var date = new Date();
	
	d = new Date();
	date = d.yyyymmdd()
	$('.fc-day[data-date="' + date + '"]').addClass('todaystyle');
	$('.fc-day[data-date="' + date + '"]').html('<i class="fa fa-cog fa-2x fa-spin"></i><br/>Today');
	
	/* Today Date style */
	/* event based color */
	 if (event.className == "fc-red") {
		 var s = new Date(event.start);
		date = s.yyyymmdd()
		$('.fc-day[data-date="' + date + '"]').addClass('sunday_cal');
	 }
	  if (event.className == "fc-grey") {
		 var s = new Date(event.start);
		date = s.yyyymmdd()
		$('.fc-day[data-date="' + date + '"]').addClass('fc_grey_cal');
	 }
	  if (event.className == "fc-charcoal") {
		 var s = new Date(event.start);
		date = s.yyyymmdd()
		$('.fc-day[data-date="' + date + '"]').addClass('fc-charcoal_cal');
	 }
	 /* event based color */
	
	/* Today Date style */
   },
   selectable: true,
   selectHelper: true,
   
   editable: false
    
  });
 });

</script>
  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  

</body>
</html>
<?php
}

?>
