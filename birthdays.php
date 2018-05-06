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
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Birthdays of the day</title>

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
        <h2 class="content-header-title">Birthdays</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Today Birthdays List</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		
<?php

$todaym = date('m');
$todayd = date('d');
$select_tts = mysql_query("SELECT * FROM users WHERE dob like '%%%%-$todaym-$todayd'");
if(mysql_num_rows($select_tts) > 0 ) {
	while($row = mysql_fetch_array($select_tts)) {
?>         
	 	<div class="col-md-3 col-sm-6">

          <div class="thumbnail">
            <div class="thumbnail-view">
            <?php if(!empty($row['image'])) { ?>
              <a href="<?php echo $row['image'];?>" class="thumbnail-view-hover ui-lightbox"></a>
              <img src="<?php echo $row['image'];?>" style="width: 100%" alt="<?php echo $row['username'];?>" />
              <?php } else { ?>
               <a href="<?php echo $conf_path;?>/uploads/avatar.png" class="thumbnail-view-hover ui-lightbox"></a>
              <img src="<?php echo $conf_path;?>/uploads/avatar.png" style="width: 100%" alt="<?php echo $row['username'];?>" />
              <?php } ?>
            </div>

            <div class="caption">
              <h3 style="text-transform:capitalize"><?php echo $row['fname'];?></h3>
              <hr/>
              <p><strong>Department</strong>:
				<em><?php echo $row['department'];?></em></p>
                <p><strong>Designation</strong>:
				<em><?php echo $row['designation'];?></em></p>
                <p><strong>Employee Id</strong>:
				<em><?php echo $row['employee_id'];?></em></p>	
            </div>
            <div class="thumbnail-footer">
              <div class="btn btn-success btn-sm btn-sm" style="width:100%;"><em><strong>DOB:</strong> <?php echo $row['dob']; ?></em></div>
            </div>
          </div>  <!-- /.thumbnail -->         

        </div> <!-- /.col -->
       
<?php  }} ?>       
       
        

             

        
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
  <script src="js/plugins/magnific/jquery.magnific-popup.min.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>

</body>
</html>
<?php
}
?>
