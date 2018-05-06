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
	if(($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')  || ($permission == "access")) {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>

<?php 
    if(isset($_GET["update_appointed"])){
        $emp_id = htmlspecialchars(mysql_escape_string($_GET["di_appointed_to"]));
        $di_id = htmlspecialchars(mysql_escape_string($_GET["di_id"]));
        $sql = "UPDATE `disciplines` SET `di_appointed_to` = '$emp_id' WHERE `disciplines`.`di_id` = $di_id";
        mysql_query($sql);
    }
    else if(isset($_GET["delete"])){
        $di_id = htmlspecialchars(mysql_escape_string($_GET["di_id"]));
        $sql = "DELETE FROM `disciplines`WHERE `disciplines`.`di_id` = $di_id";
        mysql_query($sql);
        header("Location : view-discipline-status.php");
    }


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Full Discipline Status</title>

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
<script>
    window.alert = function() {
    debugger;
}
</script>

  <?php include_once("includes/users-top.php"); ?>
  <?php include_once("includes/users-menu.php"); ?>
  
  

<div class="container">

  <div class="content">

    <div class="content-container">
      <div class="content-header">
        <h2 class="content-header-title">Full Discipline Status</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Discipline status</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
<div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
              All users discipline summary list
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
      $leave =  mysql_query("SELECT di_id, u.username as empUsername, di_date,di_location,di_violation,di_hour,di_minute,di_meridian,a.fname as appointedFname, di_status FROM disciplines inner join users u on di_emp_idu = u.idu left join users a on di_appointed_to = a.idu ORDER BY di_date DESC");

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
                      <th data-filterable="true" data-sortable="true">Added date</th>
                      <!-- <th data-filterable="true" data-sortable="true">To date</th> -->
                      <th data-filterable="true" data-sortable="true">Location</th>
                      <th data-filterable="true" data-sortable="true">Violation</th>
                      <th data-filterable="true" data-sortable="true">Time</th>
                      <th data-filterable="true" data-sortable="true">Appointed to</th>
                      <th data-filterable="true" data-sortable="true">Update Appointed</th>
                      <th data-filterable="true" data-sortable="true">Edit - Delete</th>
                      <th data-filterable="true" data-sortable="true" >Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  $count = 1;
				   while($row = mysql_fetch_array($leave)) { 
				  		$ls = $row['di_status'];?>
                  	<tr>
                    	<td><?php echo $count; ?> </td>
                    	<td><?php echo $row['empUsername']; ?></td>
                    	<td><?php echo date('d-M-Y', strtotime($row['di_date'])); ?></td>
                    	<td><?php echo $row['di_location']; ?></td>
                    	<td><?php echo $row['di_violation']; ?></td>
                    	<td><?php echo $row['di_hour'] . " : ".$row['di_minute']. $row['di_meridian']; ?></td>
                        <?php 
                        if($row['appointedFname']){
                        ?>
                        <td><?php echo $row['appointedFname']; ?></td>
                        <td style="text-align:center;">-</td>
                    	
                        <?php }else{ ?>
                            
                        <?php    
                            $user_statement = "SELECT * from users where role = 'Supervisor' or role = 'manager' ";
                            $user_appoint = mysql_query($user_statement);
                            if(mysql_num_rows($user_appoint)>0){?>
                            <td><form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input style="display:none;" name="di_id" value="<?php echo $row["di_id"]?>"><div class="input-group"><select class="form-control" name="di_appointed_to">
                            <?php 
                            while($user_row = mysql_fetch_array($user_appoint)){
                            ?>
                                <option class="" value="<?php echo $user_row["idu"]?>"><?php echo $user_row["fname"]?> </option>
                            
                        <?php }
                        //end while ?>
                        </select></div></td>
                        <td><button type="submit" name="update_appointed" class="btn btn-success update-discipline"  style="width:100%;" class="btn btn-success"><i class="fa fa-recycle"></i>Update</button></td>
                        </form>
                        <?php
                            } // end if num rows 0 
                            else {
                                echo "<td>CANNOT APPOINT</td>";
                            }
                        }
                        ?>
                        <td >
                        <button class="btn btn-facebook ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Edit Discipline Details." title="" onclick="location.href='edit-discipline.php?show_edit=TRUE&di_id=<?php echo $row["di_id"] ?>'" type="button" data-original-title="admin"><i class="fa fa-edit"></i></button>
                        <a class="btn btn-danger ui-popover" href="view-discipline-status.php?delete=TRUE&di_id=<?php echo $row["di_id"]?>" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Delete Discipline Entry." title="" onclick="return confirm('are you sure you want to delete discipline entry ?');" type="button" data-original-title="Discipline"><i class="fa fa-times"></i></a>

                        <?php if($ls == "Pending") { ?>
                        <td class="p-leave">Pending</td>
                        <?php } else if($ls == "Completed") { ?>
                        <td class="pg-leave">Completed</td>
                        <?php }?>
                        <?php ?>
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
<script>
    // $(".update-discipline").click(function(){
    //     var di_id = $(".update-discipline").data("id");

    //     location.href='view-discipline-status?update=TRUE+di_id='+di_id+'&uid='+uid;
    // });
</script>

</body>
</html>
<?php
} else {
	header("Location: welcome.php"); 
}

}
?>
