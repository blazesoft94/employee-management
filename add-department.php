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
  <title><?php echo $settings['title']; ?> - Add Department and Designation</title>

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
        <h2 class="content-header-title">Add Department and Designation</h2>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-sm-12">
       
			 <div class="col-sm-4">
              <form id="validate-enhanced" method="post"class="form parsley-form">
             <?php
			 

if(isset($_GET['editdep'])) {
	// edit project based on id
	$editdep = base64_decode(base64_decode($_GET['editdep']));
	$check_update_id = mysql_query("SELECT * FROM department where d_id='".$editdep."'");
	if(mysql_num_rows($check_update_id) == 1) {
		// update option
		$fetch_dep = mysql_fetch_array($check_update_id);
		$dept_name = $fetch_dep['department_name'];
		$desig_name = $fetch_dep['designation'];
	} 
} else {
	// add new project info
	$dept_name = '';
	$desig_name = '';
}
			 
// ADD TASK PART
if(isset($_POST['add-department'])) {
	$department = $_POST['department'];
	$designation = $_POST['designation'];
	$date_of_add = date("d-M-Y");

	
	$add_department = mysql_query("select * from department where department_name='".$department."' and designation='".$designation."'");
	if(mysql_num_rows($add_department) == 0 ) {
		$insert_dept = mysql_query("INSERT into department (`department_name`,`designation`,`date_of_add`) values ('".$department."','".$designation."','".$date_of_add."')");
		if($insert_dept) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation</strong> Added Successfully.
				  </div>';
		}
	} else {
		echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation</strong> are already added.
				  </div>';
	}
}

// Update department
if(isset($_POST['update-department'])) {
	$department = $_POST['department'];
	$designation = $_POST['designation'];
	$date_of_add = date("d-M-Y");
	$add_department = mysql_query("select * from department where department_name='".$department."' and designation='".$designation."' and d_id!='".$editdep."'");
	if(mysql_num_rows($add_department) == 0 ) {
		// update query
		$update_info = mysql_query("UPDATE department SET department_name='".$department."', designation='".$designation."', date_of_add='".$date_of_add."' WHERE d_id='".$editdep."'");
		if($update_info) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation</strong> Updated Successfully.
				  </div>';
		}
	} else {
		echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation</strong> are already added.
				  </div>';
	}

	
}


?>
             
              <div class="form-group">
					<label for="designation">Department Name</label>
                	<input id="designation" class="form-control parsley-validated" type="text" value="<?php echo $dept_name;?>" data-required="true" name="department">
				</div>
                 <div class="form-group">
                 <label for="designation">Designation Name</label>
				 <input id="designation" class="form-control parsley-validated" type="text" value="<?php echo $desig_name;?>" data-required="true" name="designation">
                 </div>

			
                <div class="form-group">
               <?php if(isset($_GET['editdep'])) { ?> <button type="submit" name="update-department" class="btn btn-success"><i class="fa fa-plus-circle"></i> Update Department </button> <?php } else { ?>
               <button type="submit" name="add-department" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Department </button> 
               <?php }  ?>
                </div>
             
                
           </form>
			</div>
             
<?PHP // END - DISPLAY PROJECT LIST AND CREATE TASK PART  ?>
          

      
        <div class="col-sm-8">

<?php
// REMOVE TASK PART
if(isset($_GET['dpt'])) {
	$removedpt = base64_decode(base64_decode($_GET['dpt']));
	$dept = mysql_query("SELECT * FROM department WHERE d_id='".$removedpt."'");
	if(mysql_num_rows($dept) == 1) {
		$ft = mysql_fetch_array($dept);
		$select = mysql_query("SELECT * FROM  users where department='".$ft['department_name']."' and designation='".$ft['designation']."'");
		if(mysql_num_rows($select) == 0) {
			$delete = mysql_query("DELETE from department WHERE	d_id='".$removedpt."'");
			if($delete) {
				header("location: add-department.php?msg=success");
			}
		} else {
			header("location: add-department.php?msg=esuccess");
		}
	}
}
?>


        
        
         <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
               Department and Designation  List
              </h3>

            </div> <!--  /.portlet-header -->

           <div class="portlet-content">
           
 <?php
 if(isset($_GET['msg'])) {
	 if($_GET['msg'] == "success") {
		 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation </strong> removed successfully.
				  </div>';
	 }
	  if($_GET['msg'] == "esuccess") {
		 echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Department and Designation </strong> assigned users. Dependency error
				  </div>';
	 }
 }
 ?>          
           
           
           
           
<?php

$selectdept = mysql_query("SELECT * from department");
if(mysql_num_rows($selectdept) !=0) {
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
                      <th data-sortable="true" data-direction="asc"> # </th>
                      <th data-sortable="true">Department</th>
                      <th data-sortable="true">Designation</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
  <?php
  $tt = 1;
while($dept = mysql_fetch_array($selectdept))
{
	 ?>               

  
                    <tr class="<?php echo $dept['d_id']; ?>">
                      <td><?php echo $tt; ?></td>
                      <td><?php echo $dept['department_name']; ?></td>
                      <td><?php echo $dept['designation']; ?></td>
                      <td><button class="btn btn-primary taskremove" onClick="location.href='add-department.php?dpt=<?php echo base64_encode(base64_encode($dept['d_id'])); ?>'" type="button"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-success" onClick="location.href='add-department.php?editdep=<?php echo base64_encode(base64_encode($dept['d_id'])); ?>'" type="button"><i class="fa fa-edit"></i></button> </td>
                    </tr>
<?php  $tt +=1;
} ?>                    
                  </tbody>
                </table>
              </div>

<?php }  else {?>
			<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 There is no <strong>Department</strong> List..
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
