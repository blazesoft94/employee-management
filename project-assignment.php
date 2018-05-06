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
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Project Assignment</title>

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
        <h2 class="content-header-title">Project Assignment</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-sm-12">
       
			 <div class="col-sm-4">
              <form id="validate-enhanced" method="post"class="form parsley-form">
             <?php
// ADD PROJECT ASSIGN PART
if(isset($_POST['assign_project'])) {
	$project_name_id = mysql_real_escape_string($_POST['project_name']);
	$username = mysql_real_escape_string($_POST['username']);
	$date_of_add = date("d-M-Y");
	$select_project_user = mysql_query("select * from project_assignment where 	project_name_id='".$project_name_id."' and username='".$username."'");
	if(mysql_num_rows($select_project_user) == 0 ) {
		$insert_project_user = mysql_query("INSERT into project_assignment (`username`,`project_name_id`,`assigned_date`) values ('$username','$project_name_id','$date_of_add')");
		if($insert_project_user) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Project </strong>assigned user successfully.
				  </div>';
		}
	} else {
		echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Project </strong> already assigned selected users.
				  </div>';
	}
}

?>
             
             
             
<?php 
// DIPLAYING SELECT BOX PROJECT DATA
$slectpro = mysql_query("SELECT * from project_list");            
$select_project = mysql_query("SELECT * from users WHERE  role!='admin'");
if(mysql_num_rows($slectpro) != 0) {
?>
             
                <div class="form-group">
					<label for="validateSelect">Username</label>
                  <select name="username" class="form-control select2-input" data-required="true">
                    <option value="">Select Username</option>
                    <?php  while($row = mysql_fetch_array($select_project)) {
					?>
                    
                    <option value="<?php echo $row['username'] ?>"><?php echo $row['username'];?></option>
                    <?php } ?>
                    
                  </select>
				</div>
                 <div class="form-group">
                <label for="validateSelect">Project Name</label>
                  <select name="project_name" class="form-control select2-input" data-required="true">
                    <option value="">Select Project Name</option>
                    <?php  while($row1 = mysql_fetch_array($slectpro)) {
					?>
                    
                    <option value="<?php echo $row1['p_id'] ?>"><?php echo $row1['project_name'];?></option>
                    <?php } ?>
                    
                  </select>
                 </div>

			
                <div class="form-group">
                  <button type="submit" name="assign_project" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Task </button>
                </div>
                
                
<?php } else { 
				echo '<div class="alert alert-success"><strong>No Project</strong> in this list</div>'; 
				?>
                 <div class="form-group">
                  <button type="button" onclick="location.href='add-project.php'" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Project </button>
                </div>
                <?php

 } ?>             </form>
			</div>
             

          

      
        <div class="col-sm-8">

<?php
if(isset($_GET['removeass'])) {
	$removeass = $_GET['removeass'];
	$delete = mysql_query("DELETE from project_assignment where p_aid='".$removeass."'");
	if($delete) {
		header("location: project-assignment.php?msg=success");
	}
}

?>
  
 <!-- PROJECT ASSIGNMENT DISPLAY PART -->      
        
         <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
                Project Assignment List
              </h3>

            </div> <!--  /.portlet-header -->

           <div class="portlet-content">
           
 <?php
 if(isset($_GET['msg']))
 {
	 if($_GET['msg'] == "success") {
		 
		 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				   <strong>Project </strong>assigned user successfully.
				  </div>';
		 
	 }
 }
 
 
 ?>          
           
           
           
           
<?php

$selectprojectass = mysql_query("SELECT * from project_assignment");
if(mysql_num_rows($selectprojectass) !=0) {
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
                      <th data-filterable="true" data-sortable="true">#</th>
                      <th data-filterable="true" data-sortable="true" data-direction="asc">Username</th>
                      <th   data-filterable="true" data-sortable="true">Project Name</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
  <?php
  $cnt = 1;
while($pro_ass = mysql_fetch_array($selectprojectass))
{
	// display project name 
	$select_p_l = mysql_fetch_array(mysql_query("SELECT * FROM project_list WHERE p_id='".$pro_ass['project_name_id']."'"));
	 ?>                 
                    <tr class="<?php echo $pro_ass['p_aid']; ?>">
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo $pro_ass['username']; ?></td>
                      <td><?php echo $select_p_l['project_name']; ?></td>
                      <td><button class="btn btn-primary taskremove" onClick="location.href='project-assignment.php?removeass=<?php echo $pro_ass['p_aid']; ?>'" type="button"><i class="fa fa-trash-o"></i></button></td>
                    </tr>
<?php $cnt +=1; } ?>                    
                  </tbody>
                </table>
              </div>

<?php }  else {?>


<div class="alert alert-danger">
        		 This <strong>Project Assignment</strong>  are empty (or) not created.
			</div>


<?php } ?>


            </div>  <!-- /.portlet-content -->
            
            
            
            

          </div><!-- /.portlet -->

<!-- END - PROJECT ASSIGNMENT DISPLAY PART -->   


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
