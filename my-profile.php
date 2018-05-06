<?php
ob_start();
session_start();
include_once("includes/config.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));
if(!(isset($_SESSION['username'])) and !(isset($_SESSION['password'])))
{
	header("Location: $conf_path/");
}
else
{
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Profile</title>

  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Plugin CSS -->
  <link rel="stylesheet" href="js/plugins/magnific/magnific-popup.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="css/target-admin.css">
  <link rel="stylesheet" href="css/custom.css">


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
        <h2 class="content-header-title">MY Profile</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>/index.php">Home</a></li>
          <li class="active">My Profile</li>
        </ol>
      </div> <!-- /.content-header -->

      

      <div class="row">

        <div class="col-md-12">

          <div class="row">

            <div class="col-md-3 col-sm-5">

              <div class="thumbnail">
             <?php if(!empty($users['image']))
			 {?>
                  <img src="<?php echo $conf_path;?>/<?php echo $users['image'];?>" alt="<?php echo $users['username'];?>" />
                  <?php
			 }
			 else
			 {
				 ?>
                 <img src="<?php echo $conf_path;?>/uploads/avatar.png" alt="<?php echo $users['username'];?>" />
                 <?php
			 }?>
              </div> <!-- /.thumbnail -->

              <br />

              <div class="list-group">  

                <a href="<?php echo $conf_path;?>/my-profile.php" class="list-group-item">
                  <i class="fa fa-user"></i> &nbsp;&nbsp;My Profile 

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                </a> 

                <a href="<?php echo $conf_path;?>/edit-profile.php" class="list-group-item">
                  <i class="fa fa-book"></i> &nbsp;&nbsp;Edit Profile

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                 
                </a> 

                <a href="<?php echo $conf_path;?>/change-password.php" class="list-group-item">
                  <i class="fa fa-cog"></i> &nbsp;&nbsp;Change Password

                  <i class="fa fa-chevron-right list-group-chevron"></i>
                </a> 

                <p class="list-group-item bg-success" style="background:#09c; border:1px solid #ccc; color:#f2f2f2">
                   &nbsp;&nbsp;<strong>Employee ID: <?php echo $users['employee_id'];?></strong>

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
							if($users['experience'] != "0000-00-00") {
								$date1 = $users['experience'];
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

              <h2><?php echo $users['fname'];?> ( <?php echo $users['username'];?> ) </h2>

              <h4><?php echo $users['designation'];?> / <?php echo $users['department'];?></h4>
            

              <hr />

              <!-- <p>
               <a href="javascript:;" class="btn btn-primary">Follow Rod</a>
                &nbsp;&nbsp;
                <a href="javascript:;" class="btn btn-secondary">Send Message</a>
              </p>

              <hr />-->


              <ul class="icons-list">
                <li><i class="icon-li fa fa-envelope"></i><a href="mailto:<?php echo $users['email_id'];?>" title="<?php echo $users['email_id'];?>"><?php echo $users['email_id'];?></a></li>
                <li><i class="icon-li fa fa-phone"></i> <a href="tel:<?php echo $users['phone_num'];?>" title="<?php echo $users['phone_num'];?>"><?php echo $users['phone_num'];?></a></li>
                <li><i class="icon-li fa fa-map-marker"></i><?php echo $users['address'];?></li>
              </ul>

              <br />
             <!-- <h3 class="heading-hide"><a style="cursor:pointer">Show More Details</a></h3>-->
             
              <p><strong>Name:</strong> <?php echo $users['fname'];?></p>
              <p><strong>Department:</strong> <?php echo $users['department'];?></p>
              <p><strong>Qualification:</strong> <?php echo $users['qualification'];?></p>
             
              <p><strong>DOB(Date of Birth):</strong> <?php echo $users['dob'];?></p>
              <p><strong>Blood Group:</strong> <?php $bgl = explode(" ",$users['blood_group']);
			  if($bgl[1] == "negative") { $bgp = "-";} else { $bgp = "+";} echo $bgl[0]." ".$bgp; ?></p>
              <p><strong>Gender:</strong> <?php echo $users['sex']; ?></p>
				
              <hr />
              <h3 class="heading-hide"><a style="cursor:pointer">Bank Information</a></h3>
               <div class="alert-messagess" style="display:block;">
               	<p><strong>Bank Name: </strong> <?php if($users['bank_name'] != '') { echo $users['bank_name']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Branch:</strong> <?php if($users['branch'] != '') { echo $users['branch']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Beneficiary Name:</strong> <?php if($users['beneficiary_name'] != '') { echo $users['beneficiary_name']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>Account Number:</strong> <?php if($users['acc_num'] != '') { echo $users['acc_num']; } else { echo "[ NULL ]"; } ?> </p>
                <p><strong>IFSC Code:</strong> <?php if($users['ifsc_code'] != '') { echo $users['ifsc_code']; } else { echo "[ NULL ]"; } ?> </p>
               </div>

             

            <button data-icon="fa fa-check-square-o" style="width:100%; height:45px; cursor:default" data-type="success" class="btn btn-success howler"><strong>Join Date:</strong> <?php echo date('Y-m-d',strtotime($users['join_date']));?></button>


            

            </div> <!-- /.col -->

          </div> <!-- /.row -->

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
  //  $(this).next(".hidecontent").slideToggle(1000);
 // });
});
</script>
  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
  
  <!-- Plugin JS -->
  <script src="js/plugins/magnific/jquery.magnific-popup.min.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  


  
</body>
</html>
<?php
}
?>
