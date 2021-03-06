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
  <title><?php echo $settings['title']; ?> - Edit Productivity List</title>

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
        <h2 class="content-header-title">Edit Productivity Target</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Edit Productivity</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> Edit Productivity Target</h3>
        <button class="btn btn-success" type="button" onClick="location.href='productivity-target.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Search Productivity</button>
        </div>
        <div class="portlet-content">
<?php if(isset($_GET['msg'])){
	  if($_GET['msg'] == "updated") { ?>
 <div class="alert alert-success">
 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
       Productivity Target Updated Successfully
      </div>
<?php } } ?>
	   
   
   
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
<?php

// EDIT ID LIST
if(isset($_GET['editid'])) {
	$id = base64_decode(base64_decode($_GET['editid']));
	
	$sct = mysql_query("SELECT * FROM productivity_target WHERE t_id='".$id."'");
	if (mysql_num_rows($sct) == 1 ) {
		$info = mysql_fetch_array($sct);
	
	
// INFORMATION UPDATION	
if(isset($_POST['update'])) {
	 $project_name = $_POST['project_name'];
	 $tow = $_POST['tow'];
	 $ass_by = $_POST['ass_by'];
	 $rph = $_POST['rph'];
	 $ty = $_POST['ty'];
	 $tm = $_POST['tm'];
	
	$query = mysql_query("UPDATE productivity_target  SET `project_id`='".$project_name."',`type_of_work`='".$tow."',`target_month`='".$tm."',`target_year`='".$ty."',`rph`='".$rph."',`assign`='".$ass_by."' WHERE t_id='".$id."'");
		if($query) {
			header ("Location:edit-productivity-target.php?editid=".$_GET['editid']."&msg=updated");
		} 
}
?>          <div class="col-md-12">
          <div class="col-md-8">
           <div class="form-group">
           <label for="name" class="col-md-3">Project Name: </label>
		   <div class="col-md-8">
          	 <select class="form-control project_name" data-required="true"  name="project_name">
              	<option value="">[ Select ]</option>
                <?php
					$project_list = mysql_query("SELECT * from project_list");
					if(mysql_num_rows($project_list) > 0 ) {
 					 while($row = mysql_fetch_array($project_list))
						  {
							 if($info['project_id'] == $row['p_id']) { $pj = "selected"; } else { $pj = ''; }
							 echo '<option '.$pj.' value="'.$row['p_id'].'">'.$row['project_name'].'</option>';
						  }
					}
						   ?>
              </select>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Type Of work: </label>
		   <div class="col-md-8">
                <select class="form-control" id="task_name" name="tow">
                <option value="">[ Select ]</option>
               <?php if($info['type_of_work'] != '') {
						  $result_info = mysql_query("SELECT * FROM project_task_list WHERE project_name_id='".$info['project_id']."'"); 
						  if(mysql_num_rows($result_info) > 0 ) { 
						  while ($task = mysql_fetch_array($result_info)) {
							 if($info['type_of_work'] == $task['pt_id']) { $pi = "selected"; } else { $pi = ''; }
							  echo '<option '.$pi.' value="'.$task['pt_id'].'">' . $task['task_name'] . "</option>";
						  } } } ?>
              </select>
            </div>
            </div>

            
            <div class="form-group">
           <label for="name" class="col-md-3">Assigned By: </label>
		   <div class="col-md-8">
           <select name="ass_by" data-required="true" class="form-control" >
           <option value="">[ Select ]</option>
           <?php
			$list_user = mysql_query("SELECT * FROM users WHERE role!='admin' and role!='director' and status!='disabled'");
			if(mysql_num_rows($list_user) > 0 ) {
 				while($row1 = mysql_fetch_array($list_user))
				{
					 if($info['assign'] == $row1['idu']) { $pk = "selected"; } else { $pk = ''; }
					echo '<option '.$pk.' value="'.$row1['idu'].'">'.$row1['username'].'</option>';
				}
			}
			?>
           </select>
            </div>
            </div>
            
            
           
            
            <div class="form-group">
           <label for="name" class="col-md-3">Records Per Hours: </label>
		   <div class="col-md-8">
              <input type="text" name="rph" data-required="true" value="<?php echo $info['rph']; ?>" class="form-control" placeholder="Enter RPH Info">
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Target Year: </label>
		   <div class="col-md-8">
                <select class="form-control" data-required="true" style="width:100px;" name="ty">
                <option value="">[ Select ]</option>
                <?php
				$sy = '2013';
				echo $cy = date("Y");
				for($i=$sy; $i<=$cy; $i++) {
					if($info['target_year'] == $i) { $pl = "selected"; } else { $pl = ''; }
					echo ' <option '.$pl.' value="'.$i.'">'.$i.'</option>';
				}
				?>
              </select>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Target Month: </label>
		   <div class="col-md-8">
                <select class="form-control" data-required="true" style="width:120px;" name="tm">
                <option value="">[ Select ]</option>
                <?php
				
				for($i=1;$i<13;$i++) {
					$pm='';
					if(strlen($i) < 2 ) { $i = '0'.$i; }
					if($info['target_month'] == $i) { $pm = "selected"; }
				echo "<option ".$pm."	value=".$i.">".date('F',strtotime('01.'.$i.'.2014'))."</option>";
				}
				?>
              </select>
            </div>
            </div>
            
           </div>
           
            <div class="col-md-4">
          </div>
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="update" class="btn btn-success"> Update </button>
                  <button type="reset"  name="Reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset </button>
                </div>
          </div>
          </div>
          
<?php
	} else { // counting number end
	echo "NO Records Found"; }
} // EDIT ID LIST END
?>          
          
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
<script type="text/javascript">
$(document).ready(function() {
 $('.project_name').change(function() {
	 var q = $(this).val();
	 var dataString = 'q='+ q;
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
