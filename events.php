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
  <title><?php echo $settings['title']; ?> - Events Photography</title>

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
        <h2 class="content-header-title">Events</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Events List</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		
<?php
if(isset($_GET['eid'])) {
	$eid = base64_decode(base64_decode($_GET['eid']));
	$select_evt = mysql_query("SELECT * FROM events WHERE event_id='".$eid."'");
	if(mysql_num_rows($select_evt) == 1) {
		$info = mysql_fetch_array($select_evt);
		?>
       
        <h4 class="heading"><?php echo $info['event_name']; ?></h4>
        <p><?php echo $info['event_description']; ?></p>
        <p><strong>Event Date: </strong><?php echo $info['event_date']; ?></p>


	
      <div class="row">

<?php $select_photo = mysql_query("SELECT * FROM events_photos WHERE event_id='".$eid."'");
if(mysql_num_rows($select_photo) == 0) {
	?>
    <div class="alert alert-info">
        There is No <strong>Photos</strong> in this event...
      </div>
    <?php
} else {
	while ($photos = mysql_fetch_array($select_photo)) {
?>

        <div class="col-md-3 col-sm-6">
          <div class="thumbnail">
            <div class="thumbnail-view">
              <a href="<?php echo"uploads/events/".$eid."/".$photos['photos_url']; ?>" class="thumbnail-view-hover ui-lightbox"></a>
              <img src="<?php echo"uploads/events/".$eid."/".$photos['photos_url']; ?>" style="width: 100%" alt="Gallery Image" />
            </div>
          </div> <!-- /.thumbnail -->       

        </div> <!-- /.col -->

<?php }} ?>
       

      </div> <!-- /.row -->

        <?php
		
	} else {
		?>
        <div class="alert alert-info">
        There is No <strong>Events</strong> in this list... You are entered wrong info
      </div>
        <?php
	}
} else {

$select_tts = mysql_query("SELECT * FROM events");
if(mysql_num_rows($select_tts) > 0 ) {
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
                      <th data-sortable="true">Title</th>
                      <th data-sortable="true">Description</th>
                      <th data-sortable="true">Event Date</th>
                      <th data-sortable="true">View</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
				  $num = 1;
				  while($row = mysql_fetch_array($select_tts)) { ?>
                  	<tr>
                    <td><?php echo $num; ?></td>
                    <td><?php echo $row['event_name']; ?></td>
                    <td><?php echo $row['event_description']; ?></td>
                     <td><?php echo $row['event_date']; ?></td>
                    <td><button class="btn btn-success ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="View <?php echo $row['event_name']; ?>." onClick="location.href='events.php?eid=<?php echo base64_encode(base64_encode($row['event_id'])); ?>'" type="button"><i class="fa fa-edit"></i></button>
                    </td>
                    </tr>
                    <?php $num += 1;} ?>
                  </tbody>
              </table>
              </div>
	 
       
<?php  } else {?>    
<div class="alert alert-info">
        There is No <strong>Events</strong> in this list
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
  <script src="js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->

  <!-- Plugin JS -->
  <script src="js/plugins/magnific/jquery.magnific-popup.min.js"></script>

  
   <!-- Plugin JS -->
  <script src="./js/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./js/plugins/datatables/DT_bootstrap.js"></script>


  <!-- App JS -->
  <script src="js/target-admin.js"></script>

</body>
</html>
<?php
}
?>
