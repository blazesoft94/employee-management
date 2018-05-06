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

  <title><?php echo $settings['title']; ?> - Search Users</title>



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

        <h2 class="content-header-title">Search Users</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Search Users</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-user"></i> User Details</h3></div>

        <div class="portlet-content">

   

   		  <form id="validate-basic" method="post" enctype="multipart/form-data" data-validate="parsley" class="form parsley-form form-horizontal">

          

<?php

?>          <div class="col-md-12">

          <div class="col-md-8">

           <div class="form-group">

           <label for="name" class="col-md-2">User Type: </label>

		   <div class="col-md-8">

          	 <select class="form-control" name="user_type">

              	<option value="">[ Any ]</option>

                <?php $dr = mysql_query("SELECT * FROM `role`");

					if(mysql_num_rows($dr) > 0) {

					while($row = mysql_fetch_array($dr)) {

						?>

                        <option value="<?php echo $row['rolename']; ?>">[ <?php echo $row['rolename']; ?> ]</option>

                        <?php

					}

					}

				?>

              </select>

            </div>

            </div>

            

            <div class="form-group">

           <label for="name" class="col-md-2">User Status: </label>

		   <div class="col-md-8">

                <select class="form-control" name="user_status">

                <option value="">[ Any ]</option>

                <option value="newuser">New user</option>

                <option value="active">Active</option>

                <option value="inactive">Inactive</option>

                <option value="resigned">Resigned</option>

              </select>

            </div>

            </div>

            

            <!--<div class="form-group">

           <label for="name" class="col-md-2">Branch: </label>

		   <div class="col-md-8">

              <input type="text" class="form-control" placeholder="Full Width">

            </div>

            </div>-->

            

           <!-- <div class="form-group">

           <label for="name" class="col-md-2">Assigned Under: </label>

		   <div class="col-md-8">

           <select name="ass_under" class="form-control" >

           <option value="">[ Any ]</option>

           </select>

            </div>

            </div>-->

            

            

            <div class="form-group">

           <label for="name" class="col-md-2">Designation: </label>

		   <div class="col-md-8">

              <select name="designation" class="form-control">

                    <option value="">[ Any ]</option>

                    <?php $des = mysql_query("SELECT * FROM department Group By designation");

					while($designation = mysql_fetch_array($des)) {

						?>

                    <option value="<?php echo $designation['designation']; ?>"><?php echo $designation['designation']; ?></option>

                     <?php } ?>

                  </select>

            </div>

            </div>

            

            <div class="form-group">

           <label for="name" class="col-md-2">Name: </label>

		   <div class="col-md-8">

              <input type="text" name="name" class="form-control" placeholder="Search Name">

            </div>

            </div>

            

            <div class="form-group">

           <label for="name" class="col-md-2">Username: </label>

		   <div class="col-md-8">

              <input type="text" name="username" class="form-control" placeholder="Search Username">

            </div>

            </div>

            

             <div class="form-group">

           <label for="name" class="col-md-2">Shift: </label>

		   <div class="col-md-8">

               <select name="shift_id" class="form-control">

                    <option value="">[ Any ]</option>

                     <?php $shf = mysql_query("SELECT * FROM shift_time");

					while($st = mysql_fetch_array($shf)) {

						?>

                    <option value="<?php echo $st['shift_no']; ?>"><?php echo $st['shift_no']."- (".$st['shift_start_time']." - ".$st['shift_end_time'].")"; ?></option>

                     <?php } ?>

              </select>

            </div>

            </div>

            

            

            <div class="form-group">

           <label for="name" class="col-md-2">Join Date: </label>

		   <div class="col-md-8">

          

           <span style="float:left; padding-top:5px;">From:</span> 

              <div class="col-md-5">

               <div id="dp-ex-3" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">

                   <input class="form-control" type="text" name="join_date_start">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                </div>

               </div>

               

                <span style="float:left; padding-top:5px;">To:</span> 

              <div class="col-md-5">

               <div id="dp-ex-4" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">

                   <input class="form-control" type="text" name="join_date_end">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                </div>

               </div>

               

            </div>

            </div>

            

            

               <div class="form-group">

           <label for="name" class="col-md-2">Resigned Date: </label>

		   <div class="col-md-8">

          

           <span style="float:left; padding-top:5px;">From:</span> 

              <div class="col-md-5">

               <div id="dp-ex-5" class="input-group date" data-auto-close="true" data-date-format="dd-mm-yyyy" data-date-autoclose="true">

                   <input class="form-control" type="text" name="resigned_date_start">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                </div>

               </div>

               

                <span style="float:left; padding-top:5px;">To:</span> 

              <div class="col-md-5">

               <div id="dp-ex-2" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">

                   <input class="form-control" type="text" name="resigned_date_end">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                </div>

               </div>

               

            </div>

            </div>

            

           </div>

           

            <div class="col-md-4">

            <div style="float:right">

            <p style="text-align:right"><strong>Legend</strong><br>

            Active <em style="color:green; font-size:24px"> &#9632;</em> <br>

			Inactive <em style="color:#444; font-size:24px" > &#9632;</em> <br>

			New user <em style="color:#09c; font-size:24px"> &#9632;</em> <br>

			Resigned <em style="color:red; font-size:24px"> &#9632;</em> <br>



            </p>

            </div>



      

          </div>

         </div> 

         

         <div class="col-md-12">

         <div class="col-md-8">

                <div class="form-group">

                  <button type="submit"  name="search_user" class="btn btn-success"><i class="fa fa-search"></i> Search User </button>

                  <button type="reset"  name="Reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset </button>

                </div>

          </div>

          </div>

              </form>

        </div>  <!--  /.portlet-content -->

     </div> <!-- /.portlet -->    

    

<?php if(isset($_POST['search_user'])) {

	$a = $b = $c = $d = '';

	$user_type = $_POST['user_type'];

	$user_status = $_POST['user_status'];

	/*$ass_under = $_POST['ass_under'];*/

	$designation = $_POST['designation'];

	$name = $_POST['name'];

	$username = $_POST['username'];

	// JOIN DATE BASED CHECK

	if(!empty($_POST['join_date_start'])) {

		$join_date_start = date('Y-m-d H:i:s', strtotime($_POST['join_date_start']));

		$a = "and `join_date` >= '".$join_date_start."'";

	} 

	if(!empty($_POST['join_date_end'])) {

		$join_date_end = date('Y-m-d H:i:s', strtotime($_POST['join_date_end']));

		$b = "and `join_date` <= '".$join_date_end."'";

	} 

	

	// RESIGNED DATE BASED CHECK

	if(!empty($_POST['resigned_date_start'])) {

		$resigned_date_start = date('Y-m-d H:i:s', strtotime($_POST['resigned_date_start']));

		$c = "and `resigned_date` >= '".$resigned_date_start."'";

	} 

	if(!empty($_POST['resigned_date_end'])) {

		$resigned_date_end = date('Y-m-d H:i:s', strtotime($_POST['resigned_date_end']));

		$d = "and `resigned_date` <= '".$resigned_date_end."'";

	} 



	/*$result = mysql_query("SELECT * FROM users where role like '%".$user_type."%' and status like '%".$user_status."%' and  designation like '%".$designation."%' and username like '%".$username."%' and fname like '%".$name."%' and  (`join_date` >= '".$join_date_start."' or  'join_date' <= '".$join_date_end."') and (`resigned_date` >= '".$resigned_date_start."' or `resigned_date` <= '".$resigned_date_end."') and status !='disabled'");*/

	$sql = "SELECT * FROM users where role like '%".$user_type."%' and status like '%".$user_status."%' and  designation like '%".$designation."%' and username like '%".$username."%' and fname like '%".$name."%' $a $b $c $d and status !='disabled'  ORDER BY emp_id ASC";

	// echo $sql;

	$result = mysql_query($sql);

	if(mysql_num_rows($result)> 0 ){

		/*echo "<script>alert('".mysql_num_rows($result)."'); </script>";*/

		

	?>

     <div class="portlet">

	

		<div class="portlet-header"><h3><i class="fa fa-user"></i> User Information List</h3></div>

        <div class="portlet-content">

 <div class="table-responsive">



              <table 

                class="table table-striped table-bordered table-hover table-highlight table-checkable" 

                data-provide="datatable" 

                data-display-rows="25"

                data-info="true"

                data-search="true"

                data-length-change="true"

                data-paginate="true"

              >

                  <thead>

                    <tr>

                    <th data-sortable="true" data-direction="asc">#</th>

                      <th data-sortable="true">Name</th>
                      
                      <th data-sortable="true">Emp ID</th>

                      <th data-sortable="true">Username</th>

                      <th data-sortable="true">Email ID</th>

                      <th data-sortable="true">User Type</th>

                      <th data-sortable="true">Designation</th>

                      <th data-sortable="true">Joined Date</th>

                      <th data-sortable="true">User Status</th>

                    </tr>

                  </thead>

                  <tbody>

                  <?php

				  $i =1;

				   while($info = mysql_fetch_array($result)) { ?>

                  <tr>

                    <td><?php echo $i; ?></td>

                    <td><?php echo $info['fname']; ?></td>
                    
                     <td><?php echo $info['employee_id']; ?></td>

                    <td><a href="<?php echo $conf_path;?>/users-list.php?userid=<?php echo base64_encode(base64_encode($info['idu'])); ?>"><?php echo $info['username']; ?></a></td>

                    <td><?php echo $info['email_id']; ?></td>

                    <td><?php echo $info['role']; ?></td>

                    <td><?php echo $info['designation']; ?></td>

                    <td><?php echo date('d-M-Y', strtotime($info['join_date'])); ?></td>

                    <td><?php echo $info['status']; ?></td>

                  </tr>

                  <?php

				  $i += 1; } ?>

                  </tbody>

                  </table>

                  </div></div>

	

	

<?php

} else {

		echo "<script> alert('No Results Found'); </script>";

	}





 } // SEARCH USER END

?>



        

   </div> <!-- /.col -->



      </div> <!-- /.row -->



    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<?php include_once("includes/footer.php"); ?>



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <!--<script type="text/javascript">

$(document).ready(function() {

  $(".hidecontent").hide();

  //toggle the componenet with class msg_body

  $(".heading-hide").click(function()

  {

    $(this).next(".hidecontent").slideToggle(1000);

  });

});

</script>-->

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

