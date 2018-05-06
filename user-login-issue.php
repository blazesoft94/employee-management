<?php
ob_start();
session_start();
include_once("includes/config.php");
include_once("includes/function.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));
if(!(isset($_SESSION['username'])) and !(isset($_SESSION['password']))){
	header("Location: $conf_path/");
} else {
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
  <title><?php echo $settings['title']; ?> - User Login Issue</title>

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
        <h2 class="content-header-title">User Login Issue</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-sm-12">
       
			
             
<?PHP // END - DISPLAY PROJECT LIST AND CREATE TASK PART  ?>
          

      
        <div class="col-sm-12">

<?php
// REMOVE TASK PART
if(isset($_GET['list'])) {
	$removeatt = base64_decode(base64_decode($_GET['list']));
	$delete = mysql_query("DELETE from attendance where aid='".$removeatt."'");
	if($delete) {
		header("location: user-login-issue.php?msg=success");
	}
}
?>


        
        
         <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
              User Attendance Issue
              </h3>

            </div> <!--  /.portlet-header -->

           <div class="portlet-content">
           
 <?php
 if(isset($_GET['msg'])) {
	 if($_GET['msg'] == "success") {
		 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>User Attendance </strong> removed successfully.
				  </div>';
	 }
 }
 ?>          
           
           
           
           
<?php
$date_now = date("d-M-Y");
$selectlist = mysql_query("SELECT * FROM attendance WHERE signin_date= '$date_now' and signout_time = '0'");
if(mysql_num_rows($selectlist) !=0) {
?>        
        
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
                     <th data-filterable="true" data-sortable="true" data-direction="asc"> # </th>
                      <th data-filterable="true" data-sortable="true">Username</th>
                      <th  data-filterable="true" data-sortable="true">Markin Time</th>
                      <th  data-filterable="true" data-sortable="true">Markin Note</th>
                      <th  data-filterable="true" data-sortable="true">Markin Type</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
  <?php
  $ii = 1;
while($list = mysql_fetch_array($selectlist))
{
	 ?>               

  
                    <tr class="<?php echo $list['aid']; ?>">
                      <td><?php echo $ii; ?> </td>
                      <td><?php echo $list['username']; ?></td>
                      <td><?php echo $list['signin_time']; ?></td>
                      <td><?php echo $list['signin_late_note']; ?></td>
                      <td><?php echo $list['punchin_type']; ?></td>
                      <td><button class="btn btn-primary taskremove" onClick="location.href='user-login-issue.php?list=<?php echo base64_encode(base64_encode($list['aid'])); ?>'" type="button"><i class="fa fa-trash-o"></i></button> </td>
                    </tr>
<?php $ii +=1;} ?>                    
                  </tbody>
                </table>
              </div>

<?php }  else {?>
			<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 There is no <strong>User Login Today</strong> (or) All user logged out successfully
			     </div>

<?php } ?>


            </div>  <!-- /.portlet-content -->
            
            
            
            

          </div><!-- /.portlet -->


  </div> <!-- /.col -->




        

      </div> <!-- /.row -->


        

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
   <script>
  /*$(document).ready(function() {
  $('.taskremove').click(function() {
    if (confirm('Are you sure?')) {
      var url = $(this).attr('id');
      $('#content').load(url);
    }
  });
});*/
</script>
  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
  <!-- Plugin JS -->
  <script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="js/plugins/datatables/DT_bootstrap.js"></script>
  
  <!-- Plugin JS -->
  <script src="js/plugins/parsley/parsley.js"></script>
  <script src="js/plugins/icheck/jquery.icheck.js"></script>
  <script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="js/plugins/timepicker/bootstrap-timepicker.js"></script>
  <script src="js/plugins/simplecolorpicker/jquery.simplecolorpicker.js"></script>
  <script src="js/plugins/select2/select2.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  
  <!-- Plugin JS -->
  <script src="js/demos/form-validation.js"></script>
</body>
</html>
<?php
} else {
	header("Location: welcome.php"); 
}}
?>
