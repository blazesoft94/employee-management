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
	if($_SESSION['role'] == 'admin') {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Add Issues</title>

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
        <h2 class="content-header-title">Add Issues</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Add Issues</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> Issues Information</h3>
        <button class="btn btn-success" type="button" onClick="location.href='view-issues.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Search Issues</button>
        </div>
        <div class="portlet-content">
<?php if(isset($_GET['msg'])){
	  if($_GET['msg'] == "created") { ?>
 <div class="alert alert-success">
 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
       Issues Added Successfully
      </div>
<?php } } ?>
	   
   
   
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
          
<?php
if(isset($_POST['add'])) {
	 $responsibility = $_POST['responsibility'];
	 $priority = $_POST['priority'];
	 $subject = $_POST['subject'];
	 $others = $_POST['others'];
	 $department = $_POST['department'];
	 $status = $_POST['status'];
	 $issue_details = $_POST['issue_details'];
	 $posted_date = date('Y-m-d H:i:s',strtotime($_POST['posted_date']));
	 $c = rand(mt_rand( 10000000, 99999999),mt_rand( 10000000, 99999999));
	 $d = "IT-".$c;
	 $date_info = date('Y-m-d H:i:s');
		$query = mysql_query("INSERT INTO issues (`primary_responsibility`, `subject`, `o_subject`, `department`, `priority`,`status`, `details`,`posted_date`,`post_by`,`create_date`,`ticket_no`) VALUES ('".$responsibility."','".$subject."','".$others."','".$department."','".$priority."','".$status."','".$issue_details."','".$posted_date."','".$_SESSION['username']."','".$date_info."','".$d."')");
		if($query) {
			header ("Location:add-issues.php?msg=created");
		} else {
			echo mysql_error(); 
		}
}
?>          <div class="col-md-12">
          <div class="col-md-8">
           <div class="form-group">
           <label for="name" class="col-md-3">Primary Responsibility: </label>
		   <div class="col-md-8">
          	 <select class="form-control project_name" data-required="true"  name="responsibility">
              	<option value="">[ Select ]</option>
                <?php
		   $query1 = mysql_query("SELECT * FROM users WHERE (role!='user' and  role!='director') and (status!='disabled' and status!='resigned')");
		   while($ulist = mysql_fetch_array($query1)) {
			   
			   echo '<option value="'.$ulist['username'].'">'.$ulist['fname']." ( ".$ulist['username']." ) ".'</option>';
		   }
		   ?>
              </select>
            </div>
            </div>
            
             <div class="form-group">
           <label for="name" class="col-md-3">Priority: </label>
		   <div class="col-md-8">
                <select class="form-control" name="priority">
                <option value="">[ Select ]</option>
                <option value="L" >Low</option>
                <option value="M">Medium</option>
                <option value="H">High</option>
              </select>
            </div>
            </div>
			
           <div class="form-group">
           <label for="name" class="col-md-3">Subject: </label>
		   <div class="col-md-8">
           <select name="subject" class="form-control" >
           <option value="">[ Select ]</option>
           <option value="survey">survey</option>
           </select><br>
			<p>If others: </p><input type="text" name="others" placeholder="If other subject entyr here ..." class="form-control"/>
            </div>
            </div>
            
            
            
            
             <div class="form-group">
           <label for="name" class="col-md-3">Department: </label>
		   <div class="col-md-8">
           <select name="department" class="form-control" >
           <option value="">[ Select ]</option>
           <?php
		   $query = mysql_query("SELECT * FROM department");
		   while($dpt = mysql_fetch_array($query)) {
			   
			   echo '<option value="'.$dpt['department_name'].'">'.$dpt['department_name'].'</option>';
		   }
		   ?>
           </select>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Status: </label>
		   <div class="col-md-8">
           <select name="status" class="form-control" >
           <option value="">[ Select ]</option>
           <option value="open">Assign</option>
           <option value="unassign">Unassign</option>
           </select>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Posted Date: </label>
		   <div class="col-md-8">
          
           
               <div id="dp-ex-4" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="posted_date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
               </div>
               
            </div>
            </div>
           
            
            <div class="form-group">
           <label for="name" class="col-md-3">Issue Details: </label>
		   <div class="col-md-8">
           <textarea class="form-control" name="issue_details" style="height:120px;" placeholder="Detail description of issues"></textarea>
            </div>
            </div>
            
             
            
            
            
           </div>
           
            <div class="col-md-4">
          </div>
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Issue </button>
                  <button type="reset"  name="Reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset </button>
                </div>
          </div>
          </div>
              </form>
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
