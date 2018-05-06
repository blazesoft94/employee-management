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

	/* page access granted part */

	/* method 1 */

	/*$ffm = mysql_fetch_array(mysql_query("SELECT * FROM role WHERE rolename='".$_SESSION['role']."'"));

	$mm = mysql_query("SELECT * FROM role_permission WHERE role_id='".$ffm['r_id']."'");	

	if(mysql_num_rows($mm) == 1) {

		$page_id = mysql_fetch_array($mm);

		$pname = basename($_SERVER['PHP_SELF']);

		$ps = mysql_fetch_array(mysql_query("SELECT * FROM `pages` WHERE pagename='".$pname."'"));

		if(in_array($ps['p_id'], $page_id)) {

			$permission = "access";

		} else {

			$permission = "failed";

		}

		

	} else {

		$permission = "failed";

	}*/

	/* method 2 */

	/*$pm = mysql_fetch_array(mysql_query("SELECT * FROM `pages` WHERE pagename='".basename($_SERVER['PHP_SELF'])."'"));

	if(in_array($pm['p_id'], $_SESSION['permission'])) {

		$permission = "access";

	} else {

		$permission = "failed";

		header("Location: $conf_path/");

	}*/

	/* method 3 */

	include_once("includes/permission.php"); 

	/* page access granted part end */

	if(($_SESSION['role'] == 'admin') || ($permission == "access")) {

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Role Management</title>



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



  <?php include_once("includes/users-top.php"); ?>

  <?php include_once("includes/users-menu.php"); ?>

  

  



<div class="container">



  <div class="content">



    <div class="content-container">



      



      <div class="content-header">

        <h2 class="content-header-title">Role Management</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Role Management</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

<div class="portlet-header">



              <h3>

                <i class="fa fa-tasks"></i>

               Role Management details info

              </h3>

 

            </div>

            <div class="portlet-content">

<?php

if(isset($_GET['role'])) {

if(isset($_POST['role'])) {

	$role = $_GET['role'];

	$date_check = date('Y-m-d H:i:s');

	$role_permission = $_POST['role_permission'];

	$selects = mysql_query("SELECT * FROM role_permission WHERE role_id='".$role."'");

	

	if(mysql_num_rows($selects) == 0) {

		$up = mysql_query("INSERT INTO role_permission (`role_id`,`page_id`,`created_date`) values ('".$role."','".$role_permission."','".$date_check."')");

	} else {

		$selects1 = mysql_fetch_array($selects);

		$up = mysql_query("UPDATE role_permission SET `role_id`='".$role."',`page_id`='".$role_permission."',`created_date`='".$date_check."' WHERE r_id='".$selects1['r_id']."'");

	}

	if($up) {

		?>

         <div class="alert alert-success">

            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

            <strong>Role Permission Changes successfully</strong>

          </div>

        <?php

	}

}

}







?>            

            

            

            <form method="post" class="form parsley-form col-sm-12" data-validate="parsley">



<div style="width:100%; float:left; clear:both; margin-bottom:25px">

<div class="pull-left">

<div class="btn-group" style="clear:both">

<?php

$roles = mysql_query("SELECT * FROM role");

while($role = mysql_fetch_array($roles)) {?>

    <button class="btn btn-sm btn-default <?php if(isset($_GET['role'])) { if($_GET['role']== $role['r_id']) { echo "active";}} ?>" type="button" style="text-transform:capitalize" onClick="location.href='role-management.php?role=<?php echo  $role['r_id'];?>'"><?php echo  $role['rolename'];?></button>

<?php

}?> 

</div>



</div>

<div style="float:left; margin:10px; margin-bottom:0; clear:both;">

<a href="#"  data-toggle="modal" data-target="#myModal">Add Role</a> 

<a href="#"  data-toggle="modal" data-target="#myModal1" style="margin-left:25px;">Delete Role</a> 

</div>

</div>





<?php

// role based displayed

if(!isset($_GET['role']) || ($_GET['role']== "1") ) {

/*if(isset($_GET['role'])) {

	if($_GET['role'] == "1") {*/

		?>

        <div class="col-sm-12">

        <div class="jumbotron">

        <p> All page are accessible </p>

        </div>

        </div>

        

        <?php

	} else {

		$check_role = mysql_query("SELECT * FROM role WHERE r_id='".$_GET['role']."'");

		if(mysql_num_rows($check_role) == 0) {

			header("Location: role-management.php");

		}

		$role_id = mysql_query("SELECT * FROM role_permission WHERE role_id='".$_GET['role']."'");

		if(mysql_num_rows($role_id) == 1) {

			$result = mysql_fetch_array($role_id);

			$str = rtrim($result['page_id'],',');

			$p = explode(',', $str);

			?>

            <div class="col-sm-8">

        <label>Default</label>

        <div class="checkbox"><label><input  class="role_checkbox" type="checkbox" checked disabled value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21">Basic User Needs</label></div>

        <label>Leave Management</label>
         <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("56", $p)) { echo "checked";} ?> type="checkbox" value="56">Apply Leave Info </label></div>
        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("22", $p)) { echo "checked";} ?> type="checkbox" value="22">All Leave Request </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("23", $p)) { echo "checked";} ?> type="checkbox" value="23">View All leave  status </label></div>

        <label>Admin Report Info</label>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("24", $p)) { echo "checked";} ?> type="checkbox" value="24"> All Attendance Report </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("25", $p)) { echo "checked";} ?> type="checkbox" value="25"> All Work Report </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("26", $p)) { echo "checked";} ?> type="checkbox" value="26"> Over All Work Report</label></div>

        <label>Project Details</label>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("27", $p)) { echo "checked";} ?> type="checkbox" value="27">   Add Project </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("28", $p)) { echo "checked";} ?> type="checkbox" value="28">   Add Project Task </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("29", $p)) { echo "checked";} ?> type="checkbox" value="29">   Project Assignment</label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("30", $p)) { echo "checked";} ?> type="checkbox" value="30,51,52">   Productivity Target</label></div>

        <label>Users</label>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("31", $p)) { echo "checked";} ?> type="checkbox" value="31">   Users List  </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("32", $p)) { echo "checked";} ?> type="checkbox" value="32,49">   Add Users</label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("33", $p)) { echo "checked";} ?> type="checkbox" value="33">   Search User </label></div>

        <label>Others</label>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("34", $p)) { echo "checked";} ?> type="checkbox" value="34">    Add Department   </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("50", $p)) { echo "checked";} ?> type="checkbox" value="34">    Role Management   </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("35", $p)) { echo "checked";} ?> type="checkbox" value="35">   Holiday    </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("36", $p)) { echo "checked";} ?> type="checkbox" value="36">   White List IP </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("37", $p)) { echo "checked";} ?> type="checkbox" value="37,38,39">     Thoughts  </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("40", $p)) { echo "checked";} ?> type="checkbox" value="40,41,42">     Appreciation    </label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("43", $p)) { echo "checked";} ?> type="checkbox" value="43,44,45">     Announcement</label></div>

        <div class="checkbox"><label><input class="role_checkbox" <?php if(in_array("46", $p)) { echo "checked";} ?> type="checkbox" value="46,47,48">     Events  </label></div>
        <div class="checkbox"><label><input class="role_checkbox"  <?php if(in_array("53", $p)) { echo "checked";} ?> type="checkbox" value="53">     User Login Issue  </label></div>
        
         <label>Accounts</label>
        <div class="checkbox"><label><input class="role_checkbox"  <?php if(in_array("54", $p)) { echo "checked";} ?> type="checkbox" value="54,55">    Bank Slip  </label></div>



        <input type="hidden" name="role_permission" id="role_permission" value="<?php echo $result['page_id']; ?>"/>

         <input class="btn  btn-secondary"  type="submit" name="role" id="submit" value="Submit"/>

        </div>

            <?php

		} else {

		?>

         <div class="col-sm-8">

        <label>Default</label>

        <div class="checkbox"><label><input  class="role_checkbox" type="checkbox" checked disabled value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21">Basic User Needs</label></div>

        <label>Leave Management</label>
        
         <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="56">Apply Leave Info </label></div>

        <div class="checkbox"><label><input class="role_checkbox" type="checkbox" value="22">All Leave Request </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="23">View All leave  status </label></div>

        <label>Admin Report Info</label>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="24"> All Attendance Report </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="25"> All Work Report </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="26"> Over All Work Report</label></div>

        <label>Project Details</label>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="27">   Add Project </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="28">   Add Project Task </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="29">   Project Assignment</label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="30,51,52">   Productivity Target</label></div>

        <label>Users</label>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="31">   Users List  </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="32,49">   Add Users</label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="33">   Search User </label></div>

        <label>Others</label>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="34">    Add Department   </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="50">    Role Management   </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="35">   Holiday    </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="36">   White List IP </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="37,38,39">     Thoughts  </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="40,41,42">     Appreciation    </label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="43,44,45">     Announcement</label></div>

        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="46,47,48">     Events  </label></div>
        
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="53">     User Login Issue  </label></div>
        
        <label>Accounts</label>
        <div class="checkbox"><label><input class="role_checkbox"  type="checkbox" value="54,55">     Bank Slip  </label></div>         
        <input type="hidden" name="role_permission" id="role_permission" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,"/>

         <input class="btn  btn-secondary"  type="submit" name="role" id="submit" value="Submit"/>

        </div>

        <?php }

		?>

       

        <div class="col-sm-4">

        

        </div>

        <?php

}

?>

            

               

               

            </form>

          </div>  <!--  /.portlet-content -->

             </div> <!-- /.portlet -->    

             



        

   </div> <!-- /.col -->



      </div> <!-- /.row -->



    </div> <!-- /.content-container -->

      

  </div> <!-- /.content -->



</div> <!-- /.container -->





<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Add New Role</h4>

      </div>

      <form id="validate-basic" action="#" data-validate="parsley" class="form parsley-form">

      <div class="modal-body">

        

        <div class="form-group">

                  <label for="name">Rolename</label>

                  <input type="text" id="rolename" name="name" class="form-control" data-required="true" >

                  

         </div>

         <div class="alert alert-success" id="rolerply" style="display:none;"></div>

         <div id="emptyerr" class="alert alert-danger" style="display:none">Please enter rolename</div>

         

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default rload" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary" id="addrole">Add Role</button>

      </div>

      </form>

    </div>

  </div>

</div>



<!-- Modal -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Delete Role</h4>

      </div>

      <form id="validate-basic" action="#" data-validate="parsley" class="form parsley-form">

      <div class="modal-body">

      

        <div class="form-group">  

             <label for="name">Rolename</label>

                  <select data-required="true" class="form-control parsley-validated" name="validateSelect" id="deleterolename">

                    <option value="" selected>Please Select</option>

                    <?php $dr = mysql_query("SELECT * FROM `role`");

					if(mysql_num_rows($dr) > 0) {

					while($row = mysql_fetch_array($dr)) {

						?>

                        <option value="<?php echo $row['rolename']; ?>"><?php echo $row['rolename']; ?></option>

                        <?php

					}

					}

					?>

                  </select>

         </div>

         <div class="alert alert-success" id="drolerply" style="display:none;"></div>

         <div id="emptyerr1" class="alert alert-danger" style="display:none">Please select rolename</div>

         

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default rload" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary" id="deleterole">Delete Role</button>

      </div>

      </form>

    </div>

  </div>

</div>



<?php include_once("includes/footer.php"); ?>



  <script src="js/libs/jquery-1.10.1.min.js"></script>

  <script type="text/javascript">

  

  $(document).ready(function () {

	  var t='';

	/* Get the checkboxes values based on the class attached to each check box */

	$(".role_checkbox").click(function() {

		$(".role_checkbox:checked").each(function() {

			t+=$(this).val()+',';

			//$('.role_permission').val($(this).val());

		});	

		var input = $('#role_permission');

		input.val(t);

		//alert(t);

		t='';

	});

	

	$('#addrole').click(function(){

		if ($('#rolename').val().length == 0){

			$('#emptyerr').slideToggle(500);

			$('#emptyerr').fadeOut(5000);

		} else {

			var dataString = 'q='+ $('#rolename').val();

			$.ajax({

				type: "POST",

				url: "request/role.php",

				data: dataString,

				cache: false,

				success: function(html)

				{

					$("#rolerply").html(html);

					$('#rolerply').slideToggle(500);

					$('#rolerply').fadeOut(5000);

				}

			});

		}

	});

	

	

	$('#deleterole').click(function(){

		if ($('#deleterolename').val().length == 0){

			$('#emptyerr1').slideToggle(500);

			$('#emptyerr1').fadeOut(5000);

		} else {

			var dataString = 'q='+ $('#deleterolename').val();

			$.ajax({

				type: "POST",

				url: "request/drole.php",

				data: dataString,

				cache: false,

				success: function(html)

				{

					$("#drolerply").html(html);

					$('#drolerply').slideToggle(500);

					$('#drolerply').fadeOut(5000);

				}

			});

		}

	});

	$('.rload').click(function(){

		window.location.reload();

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



