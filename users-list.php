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

	if(($_SESSION['role'] == 'manager') || ($_SESSION['role'] == 'admin') ||  ($permission == "access")) {

	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));

?>

<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

  <title><?php echo $settings['title']; ?> - Users List</title>



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

        <h2 class="content-header-title">Users List</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Users List</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

<div class="portlet-header">



  <?php    if(isset($_GET['userid'])) { ?>

              <h3>

                <i class="fa fa-user"></i>

              User Details

              </h3>

         

              <button class="btn btn-success" type="button" onClick="location.href='users-list.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Go Back</button>

			  <?php } else {?>

              <h3>

                <i class="fa fa-group"></i>

              Users List and Details

              </h3>

              <?php } ?>



            </div>

            <div class="portlet-content">

   <?php if(isset($_GET['msg'])) { 

   if($_GET['msg'] == 'rsuccess') { ?>

   			<div class="alert alert-success">

        	<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>

        	<strong>User Removed succesfully</strong>

			</div>

            <?php } } ?>

   

   <?php

$users_list =  mysql_query("SELECT * FROM users WHERE status!='disabled' ORDER BY emp_id ASC");



// remove user details

if(isset($_GET['ruserid'])) {

	$ruserid = base64_decode(base64_decode($_GET['ruserid']));

	$users_check =  mysql_query("SELECT * FROM users where idu='".$ruserid."'");

	if(mysql_num_rows($users_check) == 1) {

		$infom = mysql_fetch_array($users_check);

		$today = date('d-M-Y');

		$history_manage = mysql_query("INSERT INTO users_history (`user_id`,`status_from`,`status_to`,`created_info`) VALUES ('".$ruserid."','".$infom['status']."','disabled','".$today."')");

		if($history_manage) {

		$delete_query =mysql_query("UPDATE users SET status='disabled' WHERE idu='".$ruserid."'");

		if($delete_query) {

			header("Location: users-list.php?msg=rsuccess");

		}

		}

	}

}





// view particular users

if(isset($_GET['userid'])) {

	

	$user_id = base64_decode(base64_decode($_GET['userid']));

	$users_check =  mysql_query("SELECT * FROM users where idu='".$user_id."'");

	if(mysql_num_rows($users_check) == 1) {

		// correct users list

		$row = mysql_fetch_array($users_check);

		?>

        

          <div class="row">



            <div class="col-md-3 col-sm-5">



              <div class="thumbnail">

             <?php if(!empty($row['image']))

			 {?>

                  <img src="<?php echo $conf_path;?>/<?php echo $row['image'];?>" alt="<?php echo $row['username'];?>" />

                  <?php

			 }

			 else

			 {

				 ?>

                 <img src="<?php echo $conf_path;?>/uploads/avatar.png" alt="<?php echo $row['username'];?>" />

                 <?php

			 }?>

              </div> <!-- /.thumbnail -->



              <br />



              <div class="list-group">  



               

               



                <a class="list-group-item">

                  <i class="fa fa-user"></i> &nbsp;&nbsp;<strong>Username: <?php echo $row['username'];?></strong> 



                </a> 



                <p class="list-group-item bg-success" style="background:#09c; border:1px solid #ccc; color:#f2f2f2">

                   &nbsp;&nbsp;<strong>Employee ID:  <?php echo $row['employee_id'];?></strong>



                </p> 

                 <p class="list-group-item bg-success" style=" background:#5cb85c; border:1px solid #ccc; color:#f2f2f2">

                   &nbsp;&nbsp;<strong>Role: <?php echo $row['role'];?></strong>



                </p>



               

              </div> <!-- /.list-group -->



            </div> <!-- /.col -->





            <div class="col-md-9 col-sm-7">

 <!-- EXPERIENCE CALCULATOR -->
                     <div class="col-md-4 col-sm-6" style="float:right">
                        <div class="row-stat" style="background:#ffe9e9">
                            <p class="row-stat-label" style="font-size:14px; color:#444444">EXPERIENCE:</p>
                            <div class="preloader loading">
                              <span class="slice"></span>
                              <span class="slice"></span>
                              <span class="slice"></span>
                              <span class="slice"></span>
                              <span class="slice"></span>
                              <span class="slice"></span>
                            </div>
                            <span class="label label-success row-stat-badge">
                            <?php
							if($row['experience'] != "0000-00-00") {
								$date1 = $row['experience'];
								$date2 = date('Y-m-d');
								$diff = abs(strtotime($date2) - strtotime($date1));

								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
								
								printf("%d years, %d months, %d days\n", $years, $months, $days);
							} else { echo "[ NULL ]"; }
							?>
                            </span>
                        </div>
                      </div>
                  <!-- EXPERIENCE CALCULATOR -->

              <h2><?php echo $row['fname'];?> ( <?php echo $row['username'];?> )</h2>



              <h4><?php echo $row['designation'];?> / <?php echo $row['department'];?></h4>

            



              <hr />



              <ul class="icons-list">

                <li><i class="icon-li fa fa-envelope"></i><a href="mailto:<?php echo $row['email_id'];?>" title="<?php echo $row['email_id'];?>"><?php echo $row['email_id'];?></a></li>

                <li><i class="icon-li fa fa-phone"></i> <a href="tel:<?php echo $row['phone_num'];?>" title="<?php echo $row['phone_num'];?>"><?php echo $row['phone_num'];?></a></li>

                <li><i class="icon-li fa fa-map-marker"></i><?php echo $row['address'];?></li>

              </ul>



              <br />

             

             <!-- <h3 class="heading-hide"><a style="cursor:pointer">Show More Details</a></h3>-->


              <p><strong>Name:</strong> <?php echo $row['fname'];?></p>

              <p><strong>Department:</strong> <?php echo $row['department'];?></p>

              <p><strong>Qualification:</strong> <?php echo $row['qualification'];?></p>

             

              <p><strong>DOB(Date of Birth):</strong> <?php echo $row['dob'];?></p>

              <p><strong>Blood Group:</strong> <?php $bgl = explode(" ",$row['blood_group']);

			  if($bgl[1] == "negative") { $bgp = "-";} else { $bgp = "+";} echo $bgl[0]." ".$bgp; ?></p>

              <p><strong>Gender:</strong> <?php echo $row['sex']; ?></p>


              <hr />
              
               <h3 class="heading-hide"><a style="cursor:pointer">Bank Information</a></h3>
               <div class="alert-messagess" style="display:block">
               	<p><strong>Bank Name: </strong> <?php if($row['bank_name'] != '') { echo $row['bank_name']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Branch:</strong> <?php if($row['branch'] != '') { echo $row['branch']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Beneficiary Name:</strong> <?php if($row['beneficiary_name'] != '') { echo $row['beneficiary_name']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Account Number:</strong> <?php if($row['acc_num'] != '') { echo $row['acc_num']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>IFSC Code:</strong> <?php if($row['ifsc_code'] != '') { echo $row['ifsc_code']; } else { echo "[ NULL ]"; } ?> </p>
               </div>




             



            <button data-icon="fa fa-check-square-o" style="width:100%; height:45px; cursor:default" data-type="success" class="btn btn-success howler"><strong>Join Date:</strong> <?php echo date('Y-m-d',strtotime($row['join_date']));?></button>





            



            </div> <!-- /.col -->



          </div>

        <?php

	} else {

		// error users list

		?>

		<div class="pricing-plan">

        

                    <div class="pricing-plan-header">



                     



                      <span class="pricing-plan-price">Wrong users info</span>



                      <a class="btn pricing-plan-signup-btn" href="users-list.php">Go back</a>

                      

                    </div> <!-- /.pricing-header -->

                  </div>

                  <?php

	}



} else {



$cnt =1 ;

   if(mysql_num_rows($users_list) > 0 ) {

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

                      <th data-sortable="true">Name</th>

                      <th data-sortable="true">Employee id</th>

                      <th data-sortable="true" >Username</th>

                      <th data-sortable="true">Email ID</th>

                      <th data-sortable="true">Contact Info</th>

                      <th data-sortable="true">User Role</th>

                      <th >More info</th>

                    </tr>

                  </thead>

                  <tbody>

                  <?php while($row = mysql_fetch_array($users_list)) {  ?>

				  		

                  	<tr>

                    	<td><?php echo $cnt; ?></td>

                        <td><?php echo $row['fname']; ?></td>

                    	<td><?php echo $row['employee_id']; ?></td>

                    	<td><?php echo $row['username']; ?></td>

                    	<td><?php echo $row['email_id']; ?></td>

                        <td><?php echo $row['phone_num']; ?></td>

                        <td><?php echo $row['role']; ?></td>

                        <td><button class="btn btn-success moreinfo ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="More Details about <?php echo $row['username']; ?> ." title="<?php echo $row['username']; ?>" onClick="window.open('users-list.php?userid=<?php echo base64_encode(base64_encode($row['idu'])); ?>', '_blank');" type="button"><i class="fa fa-info-circle"></i></button>
                      

                        

                        <?php

						if($_SESSION['role'] != 'admin' )

						{

							if($row['role'] != "admin" && $row['role'] != "manager")

							{

								?>

                                 <button class="btn btn-facebook ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Edit <?php echo $row['username']; ?>  Details." title="<?php echo $row['username']; ?>" onClick="location.href='edit-users.php?editinfo=<?php echo base64_encode(base64_encode($row['idu'])); ?>'" type="button"><i class="fa fa-edit"></i></button> 
                                <?php
							}
            }
            
						else
						{
							?>
                                 <button class="btn btn-facebook ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Edit <?php echo $row['username']; ?>  Details." title="<?php echo $row['username']; ?>" onClick="location.href='edit-users.php?editinfo=<?php echo base64_encode(base64_encode($row['idu'])); ?>'" type="button"><i class="fa fa-edit"></i></button> 

                            <?php

						}

						

                        if($_SESSION['role'] == 'admin') { ?>

                         <a class="btn btn-danger ui-popover" href="users-list.php?ruserid=<?php echo base64_encode(base64_encode($row['idu'])); ?>" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Delete <?php echo $row['username']; ?>  Details." title="<?php echo $row['username']; ?>" onClick="return confirm('are you sure you want to delete <?php echo $row['username']; ?> user ?');" type="button"><i class="fa fa-times"></i></a>

                         <?php } ?> 

                        

                        </td>

                    </tr>

                    <?php 

					$cnt += 1; } ?>

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

}

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

  <script type="text/javascript">

$(document).ready(function() {
 // $(".hidecontent").hide();
 //toggle the componenet with class msg_body
 // $(".heading-hide").click(function()
 //{
 // $(this).next(".hidecontent").slideToggle(1000);
 //});
});

</script>

  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>

  <script src="js/libs/bootstrap.min.js"></script>



  <!--[if lt IE 9]>

  <script src="./js/libs/excanvas.compiled.js"></script>

  <![endif]-->

  <!-- Plugin JS -->

  

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

