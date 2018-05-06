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



if(isset($_POST['submit_announcement'])) {
	 $title = addslashes($_POST['title']);
	 $display_from = date('Y-m-d', strtotime($_POST['display_from']));
	 $display_to = date('Y-m-d', strtotime($_POST['display_to']));
	 $details = addslashes($_POST['content']);
	 $created_date = date('Y-m-d');
	 
	 if(empty($title) || empty($display_from) || empty($details) || empty($display_to)) {
		 $msg = '<div class="alert alert-warning">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Please fill all fields
					</div>';
	 } else {
		 
		$insert_details = mysql_query("INSERT INTO announcement (`display_from`,`display_to`,`title`,`content`,`created_date`,`modify_date`) VALUES ('".$display_from."','".$display_to."','".$title."','".$details."','".$created_date."','')");
		if($insert_details) {
			$msg = '<div class="alert alert-success">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Announcement added successfully
					</div>';
		} else {
			$msg = '<div class="alert alert-warning">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Error occure... please try again
					</div>';
		}
	 }
	 
}
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Add Announcement</title>

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
        <h2 class="content-header-title">Announcement</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Announcement of the day</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		 
            <div class="portlet">
                <div class="portlet-header">
	              <h3><i class="fa fa-tasks"></i>    Add Announcement</h3>
	            </div>
            <div class="portlet-content">
            
     	<?php if(isset($msg)): 
		echo $msg; 
		 endif ?>
            
            	 <form method="post" class="form parsley-form col-sm-12" enctype="multipart/form-data" data-validate="parsley">
           
            <div class="col-sm-4">
              <div class="form-group">
                   <label for="t_title">Name of the Announcement: <em class="red-col"> *</em></label>
                 	<input type="text" name="title" id="title" class="form-control" data-required="true">
                </div>
             </div>
             <div class="col-sm-4">
              <div class="form-group">
                  <label for="display_date">Display Start Date: <em class="red-col"> *</em></label>
                  <div class="input-group date ui-datepicker">
                      <input id="display_from" name="display_from" class="form-control" type="text" data-required="true">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
             </div>
           <div class="col-sm-4">
              <div class="form-group">
                  <label for="display_date">Display End Date: <em class="red-col"> *</em></label>
                  <div class="input-group date ui-datepicker">
                      <input id="display_to" name="display_to" class="form-control" type="text" data-required="true">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
             </div>
            
               
                
            
             
            <div class="col-sm-12">
             <div class="form-group">
                  <label for="textarea-input">Announcement Details: <em class="red-col"> *</em></label>
                  <textarea class="form-control parsley-validated" data-required="true"  rows="6" cols="10" id="content" name="content"></textarea>
                  </div>
                </div>
             
                 <div class="col-sm-6">
                 <input class="btn  btn-secondary"  type="submit" name="submit_announcement" id="submit_appreciation" value="Submit"/>
                </div>
               
            </form>
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    

<!-- view inserted thoughts list -->
		
<!-- // view inserted thoughts list -->








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
	<!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="js/plugins/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>

<!-- Place this in the body of the page content -->

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