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
  <title><?php echo $settings['title']; ?> - Issues Information</title>

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
        <h2 class="content-header-title">Issues Information</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">View Issues</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">
<?php
// CHECKING BASED ON ID
if(isset($_GET['id'])) { 
$id = base64_decode(base64_decode($_GET['id']));        
$query = mysql_query("SELECT * FROM issues WHERE i_id='".$id."'"); 
if(mysql_num_rows($query) == 1 ) {
	$info = mysql_fetch_array($query);
?>
        <div class="portlet">
		<div class="portlet-header"><h3><i class="fa fa-user"></i> View Issues</h3>
        <button class="btn btn-success" type="button" onClick="location.href='view-issues.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Search Issues</button></div>
        <div class="portlet-content">
        	<div class="col-md-12">
            <div class="col-md-8">
            <p><strong>Ticket No : </strong> <?php echo $info['ticket_no']; ?> </p>
            <p><strong>Priority : </strong> <?php if($info['priority'] == 'L') { echo "LOW";}if($info['priority'] == 'M') { echo "MEDIUM";}if($info['priority'] == 'H') { echo "HIGH";} ?> </p>
            <p><strong>Subject : </strong> <?php echo $info['subject']; ?> </p>
            <?php if($info['o_subject'] != '') { ?><p><strong>Other Subject : </strong> <?php echo $info['o_subject']; ?> </p> <?php } ?>
            <p><strong>Department: </strong> <?php echo $info['department']; ?></p>
            <p><strong>Primary Responsibility: </strong> <?php echo $info['primary_responsibility']; ?></p>
            <p><strong>Issue post_by: </strong> <?php echo $info['post_by']; ?> ( Assigned )  </p>
            <p><strong>Issue posted_date: </strong> <?php echo  date('d-M-Y', strtotime($info['posted_date'])); ?> </p>
            <p><strong>Issue details: </strong> <?php echo $info['details']; ?> </p>
            </div>
            
            </div>
       
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
           
         <div class="col-md-12">
 <hr/>
          <div class="col-md-8">
          
           <div class="form-group">
           <label for="name" class="col-md-3">Next Action: </label>
		   <div class="col-md-8">
           <textarea class="form-control" name="na" style="height:120px;" placeholder="Enter the action details"></textarea>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Department: </label>
		   <div class="col-md-8">
           <select name="department" class="form-control department" >
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
           <label for="name" class="col-md-3">Next action by: </label>
		   <div class="col-md-8">
           <select name="na" id="nextaction" class="form-control" >
           <option value="">[ Select User ]</option>
           </select>
            </div>
            </div>
            
           <div class="form-group">
           <label for="name" class="col-md-3">Change Status To: </label>
		   <div class="col-md-8">
           <select name="status" class="form-control" >
           <option value="">[ Any ]</option>
           <option value="open">Assign</option>
           <option value="unassign">Unassign</option>
           <option value="resolved">Resolved</option>
           <option value="closed">Closed</option>
           </select>
            </div>
            </div>
            
            
           
            
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Estimated  Date: </label>
		   <div class="col-md-8">
          
               <div id="dp-ex-3" class="input-group date" style="width:200px;" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="posted_start">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
               
               
              
            </div>
            </div>
            
            
            
               
            
           </div>
           
            <div class="col-md-4">
          </div>
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="submit" class="btn btn-success"> Submit </button>
                  <button type="reset"  name="Reset" class="btn btn-danger"> Reset </button>
                </div>
          </div>
          </div>
              </form>
        </div>  <!--  /.portlet-content -->
     </div> <!-- /.portlet -->    
    
<?php } }?>
     
	
   </div> <!-- /.col -->

      </div> <!-- /.row -->

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
 <script type="text/javascript">
$(document).ready(function() {
 $('.department').change(function() {
	 var q = $(this).val();
	 var dataString = 'q='+ q;
		$.ajax({
			type: "POST",
			url: "request/department.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#nextaction").html(html);
			}
		});
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
} else {
	header("Location: welcome.php"); 
}
}
?>
