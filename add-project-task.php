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
	if(($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager') ||  ($permission == "access")) {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Project Task Adding part</title>

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
        <h2 class="content-header-title">Apooint Discipline</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-sm-12">
       
			 <div class="col-sm-4">
              <form id="validate-enhanced" method="post"class="form parsley-form">
             <?php
// ADD TASK PART
if(isset($_POST['add_task'])) {
	$project_name_id = $_POST['project_name'];
	$task_name = mysql_real_escape_string($_POST['task_name']);
	$date_of_add = date("d-M-Y");
	$select_task = mysql_query("select * from project_task_list where project_name_id='".$project_name_id."' and task_name='".$task_name."'");
	if(mysql_num_rows($select_task) == 0 ) {
		$insert_task = mysql_query("INSERT into project_task_list (`project_name_id`,`task_name`,`create_date`) values ('$project_name_id','$task_name','$date_of_add')");
		if($insert_task) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Project Task</strong> Added Successfully.
				  </div>';
		}
	} else {
		echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Project and Task</strong> are already Linking.
				  </div>';
	}
}

// EDIT TASK
if(isset($_POST['edit_task'])) {
	$edittaskid = base64_decode(base64_decode($_GET['edittask']));
	$update_task = mysql_query("UPDATE project_task_list SET task_name='".$_POST['edit_task_name']."' WHERE pt_id='".$edittaskid."'");
	if($update_task) {
		// success update task
		header("Location: add-project-task.php?msg=esuccess");
		
	}
}
if(isset($_GET['msg'])) {
 if($_GET['msg'] == "esuccess") {
	 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>The Project Task</strong> was updated successfully
				  </div>';
	  }
}
?>
             
             
             
<?php   
// DISPLAY PROJECT LIST AND CREATE TASK PART         
$select_project = mysql_query("SELECT di_id, di_location, u.fname as emp_fname  FROM disciplines inner join users u on di_emp_idu = u.idu left join users a on di_appointed_to = a.idu  where di_appointed_to IS NULL ORDER BY di_date DESC");
if(mysql_num_rows($select_project) != 0) {

// EDIT TASK PART
if(isset($_GET['edittask'])) {
	$edittaskid = base64_decode(base64_decode($_GET['edittask']));
	$select_task_list = mysql_query("select * from project_task_list where 	pt_id='".$edittaskid."'");
	
	$e_task = mysql_fetch_array($select_task_list);
	if(mysql_num_rows($select_task_list) == 0) {
?>
					<div class="alert alert-danger">
        			  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        			  <strong>Your Task detail</strong> was wrong.
                      </div>
  <?php    			      

	} else {
		$select_task_list1 = mysql_query("select * from disciplines where di_appointed_to = ''");
		$e_row = mysql_fetch_array($select_task_list1);
	?>
    			<div class="form-group">
					<label for="validateSelect">Project Name</label>
                 	<select name="project_name" disabled class="form-control" data-required="true">
                   	 <option value="<?php echo $e_task['di_id'] ?>" selected><?php echo $e_row['di_id'];?></option>
                  	</select>
				</div>
                <div class="form-group">
                 <label for="name">Task Name</label>
				 <input id="name" class="form-control parsley-validated" value="<?php echo $e_task['task_name'] ?>" type="text" data-required="true" name="edit_task_name">
                 </div>
                 <div class="form-group">
                  <button type="submit" name="edit_task" class="btn btn-success"><i class="fa fa-edit"></i> edit Task </button>
                </div>
    <?php

} 
}else { ?>

             
                <div class="form-group">
					<label for="validateSelect">Project Name</label>
                  <select name="project_name" class="form-control select2-input" data-required="true">
                    <option value="">Select Project</option>
                    <?php  while($row = mysql_fetch_array($select_project)) {
					?>
                    
                    <option value="<?php echo $row['di_id'] ?>"><?php echo $row['di_id'];?></option>
                    <?php } ?>
                    
                  </select>
				</div>
                 <div class="form-group">
                 <label for="name">Employee Name</label>
				 <input id="name" class="form-control parsley-validated" type="text" data-required="true" name="task_name">
                 </div>

			
                <div class="form-group">
                  <button type="submit" name="add_task" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Task </button>
                </div>
                
                
<?php } } else { 
				echo '<div class="alert alert-success"><strong>No Project</strong> in this list</div>'; 
				?>
                 <div class="form-group">
                  <button type="button" onclick="location.href='add-project.php'" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Project </button>
                </div>
                <?php

 } ?>             </form>
			</div>
             
<?PHP // END - DISPLAY PROJECT LIST AND CREATE TASK PART  ?>
          

      
        <div class="col-md-12">

<?php
// REMOVE TASK PART
if(isset($_GET['removetask'])) {
	$removetaskid = base64_decode(base64_decode($_GET['removetask']));
	$check_remove_id = mysql_query("SELECT * FROM project_task_list where pt_id='".$removetaskid."'");
	if(mysql_num_rows($check_remove_id) == 1) {
		
	$select_task_list = mysql_query("SELECT * FROM work_report WHERE type_of_work='".$removetaskid."'");
	if((mysql_num_rows($select_task_list) > 0)){
		header("location: add-project-task.php?msg=esuccess");
	} else {
		$delete = mysql_query("DELETE from project_task_list where 	pt_id='".$removetaskid."'");
		if($delete) {
			header("location: add-project-task.php?msg=success");
		}
	}
	}
}
?>


        
        
         <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
                Project and Task List
              </h3>

            </div> <!--  /.portlet-header -->

           <div class="portlet-content">
           
 <?php
 if(isset($_GET['msg']))
 {
	 if($_GET['msg'] == "success") {
		 
		 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Project and Task </strong> removed successfully.
				  </div>';
		 
	 }
	 if($_GET['msg'] == "esuccess") {
	 
	 echo '<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 Some <strong>Task </strong> are depend on your <strong>work Report</strong>. 
			     </div>';
	 }
	 
 }
 
 
 ?>          
           
           
           
           
<?php

$selectprojectlist = mysql_query("SELECT * from project_task_list");
if(mysql_num_rows($selectprojectlist) !=0) {
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
                      <th data-sortable="true" data-direction="asc">#</th>
                      <th data-filterable="true" data-sortable="true">Project Name</th>
                      <th   data-filterable="true" data-sortable="true">Task Name</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
  <?php
   $cnt = 1;
while($task = mysql_fetch_array($selectprojectlist))
{
	// display project name 
	$select_p_l = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$task['project_name_id']."'"));
	 ?>               

  
                    <tr class="<?php echo $task['pt_id']; ?>">
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo $select_p_l['project_name']; ?></td>
                      <td><?php echo $task['task_name']; ?></td>
                      <td><button class="btn btn-primary taskremove" onClick="location.href='add-project-task.php?removetask=<?php echo base64_encode(base64_encode($task['pt_id'])); ?>'" type="button"><i class="fa fa-trash-o"></i></button> <button class="btn btn-success taskedit" onClick="location.href='add-project-task.php?edittask=<?php echo base64_encode(base64_encode($task['pt_id'])); ?>'" type="button"><i class="fa fa-edit"></i></button></td>
                    </tr>
<?php $cnt += 1; } ?>                    
                  </tbody>
                </table>
              </div>

<?php }  else {?>
			<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 The <strong>Project</strong> has no task..
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
}
}
?>

