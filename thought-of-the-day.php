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
  <title><?php echo $settings['title']; ?> - Thought of the day</title>

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
        <h2 class="content-header-title">Thought of the day</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Today Thought</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		 <div class="row">
<?php
if(isset($_GET['view'])) {
	$id = base64_decode(base64_decode($_GET['view']));
	$select_tts = mysql_query("SELECT * FROM thoughts WHERE tid='".$id."'");
if(mysql_num_rows($select_tts) == 1 ) {
	$row = mysql_fetch_array($select_tts);
?>         
        <div class="col-md-3 col-sm-6">
          <div class="thumbnail">
            <div class="thumbnail-view">
              <a href="<?php echo $row['t_img']; ?>" class="thumbnail-view-hover ui-lightbox"></a>
              <img src="<?php echo $row['t_img']; ?>" style="width: 100%" alt="<?php echo $row['t_title']; ?>" />
            </div>
          </div> <!-- /.thumbnail -->       
        </div> <!-- /.col -->
        <div class="col-md-9 col-sm-6">
        <div class="caption">
              <h3 style="text-transform:capitalize"><?php echo $row['t_title']; ?></h3>
              <em><?php echo $row['display_date']; ?></em>
              <hr/>
              <p><?php echo $row['t_details']; ?></p>
            </div>
        </div>
       </div>
       
<?php } 
} else {

$today = date('Y-m-d');
$select_tts = mysql_query("SELECT * FROM thoughts WHERE display_date='".$today."'");
if(mysql_num_rows($select_tts) == 1 ) {
	$row = mysql_fetch_array($select_tts);
?>         
         
         
        <div class="col-md-3 col-sm-6">
          <div class="thumbnail">
            <div class="thumbnail-view">
              <a href="<?php echo $row['t_img']; ?>" class="thumbnail-view-hover ui-lightbox"></a>
              <img src="<?php echo $row['t_img']; ?>" style="width: 100%" alt="<?php echo $row['t_title']; ?>" />
            </div>
          </div> <!-- /.thumbnail -->       
        </div> <!-- /.col -->
        <div class="col-md-9 col-sm-6">
        <div class="caption">
              <h3 style="text-transform:capitalize"><?php echo $row['t_title']; ?></h3>
              <em><?php echo $row['display_date']; ?></em>
              <hr/>
              <p><?php echo $row['t_details']; ?></p>
            </div>
        </div>
       </div>
       
<?php } }?>       
       
        

             

        
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
