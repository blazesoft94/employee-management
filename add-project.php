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
  <title><?php echo $settings['title']; ?> - Project Adding part</title>

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
        <h2 class="content-header-title">Create Project</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-sm-6">

          <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
                Create Project
              </h3>

            </div> <!-- /.portlet-header -->

            <div class="portlet-content">

<?php
// ADD PROJECT PART
if(isset($_POST['add_project'])) {
	if(empty($_POST['project_name'])) {
		// error
		echo '<div class="alert alert-warning">
              <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
              Please Enter The <strong>Project</strong> Name.
              </div>';
	} else {
		$project_name = mysql_real_escape_string($_POST['project_name']);
		$date_of_add = date("d-M-Y");
		$project_add_person = mysql_real_escape_string($_SESSION['username']);
		
		$check_project = mysql_query("SELECT * from project_list where project_name='".$project_name."'");
		if( mysql_num_rows($check_project) == 0) {
			// insert query
			$project_insert = mysql_query("INSERT into project_list (`project_name`,`project_add_person`,`date_of_add`,`status`,`dat_of_mod`) values ('$project_name','$project_add_person','$date_of_add','1','')");
			if($project_insert) {
				// Successfully added messge
				echo '<div class="alert alert-success">
        			  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        			  <strong>New Project!</strong> added successfully.
      			      </div>';
			}
		} else{
			// already inserted error message
			echo '<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 This <strong>Project</strong> already inserted in the project List.
			     </div>';
		}
		
	}
}

?>


<?PHP
// EDIT PROJECT PART

if(isset($_POST['edit_project'])) {
	
	$edit_project_name = mysql_real_escape_string($_POST['edit_project_name']);
	$id = base64_decode(base64_decode($_GET['editpro']));
	$date_of_mod = date("d-M-Y");
	$update_change = mysql_query("UPDATE project_list SET project_name='".$edit_project_name."',dat_of_mod='".$date_of_mod."' WHERE p_id='".$id."'");
	if($update_change) {
		header("Location: add-project.php?msg=esuccess");
	}
	
}
if(isset($_GET['msg'])) {
	if($_GET['msg'] == "esuccess") {
		echo '<div class="alert alert-success">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 This <strong>Project</strong> altered successfully in the project List.
			     </div>';
	}
	if($_GET['msg'] == "proremoved") {
		echo '<div class="alert alert-success">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 The Selected <strong>Project</strong> was removed successfully from the project List.
			     </div>';
	}
}

?>


<?php   
// REMOVE PROJECT AND ALSO CHECK DEPENDENCY

if(isset($_GET['removepro'])) {
	
	$remove_id = base64_decode(base64_decode($_GET['removepro']));
	
	$check_remove_id = mysql_query("SELECT * FROM project_list where p_id='".$remove_id."'");
	if(mysql_num_rows($check_remove_id) == 1) {
		// entered id was correct
		// dependency check 
		$select_pro_list = mysql_query("SELECT * FROM project_task_list WHERE project_name_id='".$remove_id."'");
		$select_upro_list = mysql_query("SELECT * FROM project_assignment WHERE project_name_id='".$remove_id."'");
		if((mysql_num_rows($select_pro_list) > 0) || (mysql_num_rows($select_upro_list) > 0)) {
			echo '<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 Some <strong>Task / Users</strong> are depend on your selected <strong>Project</strong>.<br/> please <strong>remove task and users</strong> then <strong>remove project</strong>.
			     </div>';
		} else {
			// REMOVE PROJECT BECAUSE THIS PROJECT NOT DEPENDS ON OTHERS
			$delete_pro = mysql_query("DELETE FROM project_list where p_id='".$remove_id."'");
			if($delete_pro) {
				header("Location: add-project.php?msg=proremoved");
				
			}
			
		}
		
	} else {
		// entered id was wrong
		echo '<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 Your selected <strong>Project</strong> was wrong. please choose correct way
			     </div>';
	}
}

?>





              <form id="validate-enhanced" method="post"class="form parsley-form">
<?php if(isset($_GET['editpro'])) { 
$get_edit = base64_decode(base64_decode($_GET['editpro']));
$edit_id = mysql_query("SELECT * FROM  project_list where p_id='".$get_edit."'");
$edit_update = mysql_fetch_array($edit_id);
if(mysql_num_rows($edit_id) == 0) {
	?>
<div class="alert alert-danger">
        			  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        			  <strong>Your Project id</strong> was wrong.
      			      </div>
<?php } else {
?>
                <div class="form-group">
					<label for="name">Edit Project Name</label>
					<input id="name" class="form-control parsley-validated" type="text" data-required="true" name="edit_project_name" value="<?php echo $edit_update['project_name']; ?>">
				</div>



                <div class="form-group">
                  <button type="submit" name="edit_project" class="btn btn-success">Edit Project</button>
                </div>
<?php } } else {?>
<div class="form-group">
					<label for="name">Project Name</label>
					<input id="name" class="form-control parsley-validated" type="text" data-required="true" name="project_name">
				</div>



                <div class="form-group">
                  <button type="submit" name="add_project" class="btn btn-success">Add Project</button>
                </div>
                <?php } ?>

              </form>

<?php
// project list

$select_project = mysql_query("SELECT * from project_list");
if(mysql_num_rows($select_project) != 0) {

?>


			<h4><span class="text-primary">PROJECT LIST</span></h4>
            <hr/>
            <div class="alert alert-success" id="remove_project_success" style="display:none"><strong>Project</strong> Removed successfully</div>
            
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
                      <th data-sortable="true">Project Name</th>
                      <th data-sortable="true">Edit / Delete</th>
                    </tr>
                  </thead>
                  <tbody>
            
            
            
            <!--<ul class="icons-list project_list_style">-->
            <?php
			 $cnt = 1;
			 while($row = mysql_fetch_array($select_project)) { ?>
            
             <tr class="<?php echo  $row['p_id']; ?>">
             		  <td><?php echo $cnt; ?></td>
                      <td><?php echo $row['project_name']; ?></td>
                      <td><button class="btn btn-primary proremove" onClick="location.href='add-project.php?removepro=<?php echo base64_encode(base64_encode($row['p_id'])); ?>'" type="button"><i class="fa fa-trash-o"></i></button>  <button class="btn btn-success editpro" onClick="location.href='add-project.php?editpro=<?php echo base64_encode(base64_encode($row['p_id'])); ?>'" type="button"><i class="fa fa-edit"></i></button></td>
                    </tr>
               
                <?php $cnt += 1; } ?>
                
                </tbody>
                </table>
              </div>
              <!--</ul>-->
              
<?php
}
?>
              
 
            </div> <!-- /.portlet-content -->
            
            
            
            

          </div> <!-- /.portlet -->

        </div> <!-- /.col -->







        <div class="col-sm-6">

          <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
                project and task
              </h3>

            </div> <!-- /.portlet-header -->

            <div class="portlet-content">

              <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form">

              
               <?php
			   $select_project_list = mysql_query("SELECT * from project_list");
			   if(mysql_num_rows($select_project_list) != 0) { ?> 
                <div class="form-group"> 
                  <label for="validateSelect">Filter Project Task</label>
                  <select name="project_name_list" class="form-control select2-input" data-required="true">
                    <option value="">Select Project</option>
                    <?php  while($row = mysql_fetch_array($select_project_list)) {
					?>
                    
                    <option value="<?php echo $row['project_name'] ?>"><?php echo $row['project_name'];?></option>
                    <?php } ?>
                    
                  </select>
                   </div>
                   
                  <div class="form-group">
                  <button type="submit" name="select_project" class="btn btn-primary">Select Project</button>
                  </div>
                  <?php } else { ?>
                  <div class="form-group">
                  	<div class="alert alert-success"><strong>No Project</strong> in this list</div>
                  </div>
                  
                  <?php } ?>
               

                

              </form>

            </div> <!-- /.portlet-content -->

          </div> <!-- /.portlet -->
          
<?php if(isset($_POST['select_project'])) { 

$project_name = $_POST['project_name_list'];

// select project id 
$selectp_id = mysql_query("SELECT * FROM project_list WHERE project_name='".$project_name."'");
$selectproject_id = mysql_fetch_array($selectp_id);

if(mysql_num_rows($selectp_id) != 0) {
	?>
    	 <div class="portlet">
          
            <div class="portlet-header">
          
              <h3>
                <i class="fa fa-reorder"></i>
                Project name: <?php echo $selectproject_id['project_name']; ?>
              </h3>
          
            </div> <!-- /.portlet-header -->
          
            <div class="portlet-content">
    
    <?php

$select_task_list = mysql_query("SELECT * FROM project_task_list where 	project_name_id='".$selectproject_id['p_id']."'");
if(mysql_num_rows($select_task_list) != 0) {
 ?>        
         
         
              <ol>
               <?php while ($rowss = mysql_fetch_array($select_task_list)) { ?>
                <li>
                 
                  <?php echo $rowss['task_name']; ?>
                </li>
                <?php } ?>
              </ol>
<?php } else { ?>   
			<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 This <strong>Project task</strong>  are empty (or) not created.
			</div>
            <div class="form-group">
                  <button class="btn btn-success" onClick="location.href='add-project-task.php'" type="submit">Create Task</button>
            </div>

<?php } ?>       
            </div> <!-- /.portlet-content -->
          
          </div>
          
<?php }
}?>          
          
        </div> <!-- /.col -->

      </div> <!-- /.row -->


        

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
	   
	  $('.delete_project').click(function(){
		  
		  var rp_id = $(this).attr("id");
		  $.ajax({
			  type:"post",
			  url:"request/delete_project.php",
               data: {rp_id:rp_id},
               cache : false,
              crossDomain: false,
             
                  success: function(msg){
					  if(msg != '')
					  {
						 alert(msg);
						 //doubt
						//$('.'+msg).parent().remove();
						$('#remove_project_success').slideDown(300);
					    $('#remove_project_success').fadeOut(4000);
					  }
					 
					  },
              error: function(msg,et){ alert('error');}
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
