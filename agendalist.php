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
  <title><?php echo $settings['title']; ?> - Agenda List</title>

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
        <h2 class="content-header-title">Search Agenda</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">View Agenda</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> Search Agenda</h3></div>
        <div class="portlet-content">
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
          
<?php
// MESSAGE INFORMATION
if(isset($_GET['msg'])) {
	if($_GET['msg'] == "delete") {
		?>
         <div class="alert alert-info">
 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
       Issues Deleted Successfully
      </div>
        <?php
	}
}

// DELETE INFORMATION
if(isset($_GET['deleteid'])) {
	$delid = base64_decode(base64_decode($_GET['deleteid']));
	$quy = mysql_query("SELECT * FROM issues WHERE i_id='".$delid."' ");
	if(mysql_num_rows($quy) == 1 ) {
		$DEL = mysql_query("DELETE FROM issues WHERE i_id='".$delid."' ");
		if($DEL) {
			header("Location:view-issues.php?msg=delete"); 
		}
	}
	
}
?>          <div class="col-md-12">
          <div class="col-md-8">
           
            
            
            
            

            
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Subject: </label>
		   <div class="col-md-8">
           <select name="subject" class="form-control" >
           <option value="">[ SELECT ]</option>
           <option value="survey">survey</option>
           </select><br>
<p>If others: </p><input type="text" name="others" placeholder="If other subject enter here ..." class="form-control"/>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Posted Date: </label>
		   <div class="col-md-8">
          
           <span style="float:left; padding-top:5px;">From:</span> 
              <div class="col-md-5">
               <div id="dp-ex-3" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="posted_start">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
               </div>
               
                <span style="float:left; padding-top:5px;">To:</span> 
              <div class="col-md-5">
               <div id="dp-ex-4" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="posted_end">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
               </div>
               
            </div>
            </div>
            
            
            
            <!--<div class="form-group">
           <label for="name" class="col-md-3">Estimated Date: </label>
		   <div class="col-md-8">
          
           <span style="float:left; padding-top:5px;">From:</span> 
              <div class="col-md-5">
               <div id="dp-ex-5" class="input-group date" data-auto-close="true" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="estimated_start">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
               </div>
               
                <span style="float:left; padding-top:5px;">To:</span> 
              <div class="col-md-5">
               <div id="dp-ex-2" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input class="form-control" type="text" name="estimated_end">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
               </div>
               
            </div>
            </div>-->
            
            
            
            
            
               
            
           </div>
           
            <div class="col-md-4">
          </div>
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="search" class="btn btn-success"><i class="fa fa-search"></i> Search </button>
                  <button type="reset"  name="Reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset </button>
                </div>
          </div>
          </div>
              </form>
        </div>  <!--  /.portlet-content -->
     </div> <!-- /.portlet -->    
    

     <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> View Agenda List</h3>
        <button class="btn btn-success" type="button" onClick="location.href='add-agenda.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Add Agenda</button>
        </div>
        <div class="portlet-content">
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
                    <th data-sortable="true" data-direction="asc">#</th>
                      <th data-sortable="true">Subject</th>
                      <th data-sortable="true">Start Time</th>
                      <th data-sortable="true">End Time</th>
                      <th data-sortable="true">Minutes Prepared By</th>
                      <th data-sortable="true">Created Date</th>
                      <th data-sortable="true">Last Updated</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
 // SEARCH PRODUCTIVITY TARGET
 if(isset($_POST['search'])) {
	 $a = $b = $c = $d = '';
	 $subject = $_POST['subject'];
	 $others = $_POST['others'];
	 
	 // POSTED DATE BASED CHECK
	if(!empty($_POST['posted_start'])) {
		$posted_start = date('Y-m-d H:i:s', strtotime($_POST['posted_start']));
		$a = "and `a_date` >= '".$posted_start."'";
	} 
	if(!empty($_POST['posted_end'])) {
		$posted_end = date('Y-m-d H:i:s', strtotime($_POST['posted_end']));
		$b = "and `a_date` <= '".$posted_end."'";
	} 
	
	// ESTIMATED DATE BASED CHECK
	/*if(!empty($_POST['estimated_start'])) {
		$resigned_date_start = date('Y-m-d H:i:s', strtotime($_POST['estimated_start']));
		$c = "and `estimated_date` >= '".$estimated_start."'";
	} 
	if(!empty($_POST['estimated_end'])) {
		$resigned_date_end = date('Y-m-d H:i:s', strtotime($_POST['estimated_end']));
		$d = "and `estimated_date` <= '".$estimated_end."'";
	} */

	$sql = "SELECT * FROM agenda where subject like '%".$subject."%' and o_subject like '%".$others."%' $a $b $c $d";
	// echo $sql;
	$result = mysql_query($sql);
	if(mysql_num_rows($result)> 0 ){
				  $i =1;
				   while($info = mysql_fetch_array($result)) {
					   $user_i = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE idu='".$info['min_prepare']."'"));
					?>
					   
					   
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $info['subject']."<br/>".$info['o_subject']; ?></td>
                    <td><?php echo $info['time_from']; ?></td>
                    <td><?php echo $info['time_to']; ?></td>
                    <td><?php echo $user_i['username']; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($info['created_date'])); ?></td>
                    <td><?php if($info['modified_date'] != "0000-00-00 00:00:00") { echo date('d-M-Y', strtotime($info['modified_date'])); } ?></td>
                  </tr>
                  <?php
				  $i += 1; } 
} else {
		echo "<script> alert('No Results Found'); </script>";
	}
 } // SEARCH PRODUCTIVITY TARGET END
?>
                  </tbody>
                  </table>
                  </div></div>
	
   </div> <!-- /.col -->

      </div> <!-- /.row -->

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> 
</div>
<!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
 <script type="text/javascript">
$(document).ready(function() {
 $('.project_name').change(function() {
	 var q = $(this).val();
	 var dataString = 'sq='+ q;
		$.ajax({
			type: "POST",
			url: "request/project_task.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#task_name").html(html);
			}
		});
 });
});
 $('.confirmation').on('click', function () {
        return confirm('Are you sure to remove issue?');
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
