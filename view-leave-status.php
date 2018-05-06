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
	if(($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'Supervisor') || ($_SESSION['role'] == 'manager')  || ($permission == "access")) {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Full Leave Status</title>

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
        <h2 class="content-header-title">Full Leave status</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Leave status</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
<div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
              All users leave summary list
              </h3>

            </div>
            <div class="portlet-content">
<?php
// leave status
/* 0 - pending
   1 - success
   2 - reject
   3 - usercancel */
   ?>
   
  
   
   
   
   <?php
      $leave =  mysql_query("SELECT * FROM leave_management ORDER BY leave_from DESC");

   if(mysql_num_rows($leave) > 0 ) {
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
                     <th data-filterable="true" data-direction="asc" data-sortable="true" >#</th>
                      <th data-filterable="true" data-sortable="true">Username</th>
                      <th data-filterable="true" data-sortable="true">From date</th>
                      <th data-filterable="true" data-sortable="true">To date</th>
                      <th data-filterable="true" data-sortable="true">Day Mention(Half/Full))</th>
                      <th data-filterable="true" data-sortable="true">Leave Reason</th>
                      <th data-filterable="true" data-sortable="true">Apply Date</th>
                      <th data-filterable="true" data-sortable="true">Approved/Cancel</th>
                      <th data-filterable="true" data-sortable="true" >Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  $count = 1;
				   while($row = mysql_fetch_array($leave)) { 
				  		$ls = $row['status'];?>
                  	<tr>
                    	<td><?php echo $count; ?> </td>
                    	<td><?php echo $row['username']; ?></td>
                    	<td><?php echo date('d-M-Y', strtotime($row['leave_from'])); ?></td>
                    	<td><?php echo date('d-M-Y', strtotime($row['leave_to'])); ?></td>
                    	<td><?php echo $row['half_full']; ?></td>
                    	<td><?php echo $row['leave_reason']; ?></td>
                    	<td><?php echo date('d-M-Y', strtotime($row['apply_date'])); ?></td>
                        <?php if($ls == 0) { ?>
                        <td> - </td>
                        <td class="p-leave">Pending</td>
                        <?php } else if($ls == 1) { ?>
                        <td><?php echo date('d-M-Y', strtotime($row['approve_date'])); ?></td>
                        <td class="pg-leave">Permission granted</td>
                        <?php } else if($ls == 2) { ?>
                        <td><?php echo date('d-M-Y', strtotime($row['cancel_date'])); ?></td>
                        <td class="pr-leave">Permission rejected</td>
                        <?php } else { ?>
                        <td><?php echo date('d-M-Y', strtotime($row['cancel_date'])); ?></td>
                        <td class="cu-leave">Cancelled by user</td>
                        <?php } ?>
                    </tr>
                    <?php 
					$count +=1;} ?>
                  </tbody>
              </table>
              </div>
              
<?php
   } else { 
   ?>
   <div class="alert alert-success">
            <strong>No Records Found</strong>
          </div>
  <?php }
   ?>
              
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    
             

        
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
