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
  <title><?php echo $settings['title']; ?> - View Announcement</title>

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
        <h2 class="content-header-title">View Announcement</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Announcement List</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		 
            <div class="portlet">
                <div class="portlet-header">
	              <h3><i class="fa fa-tasks"></i>    View All Announcement</h3>
	            </div>
            <div class="portlet-content">
       
  <?php
  if(isset($_GET['rid'])){
	  
	  $rid = base64_decode(base64_decode($_GET['rid']));
	  $dT = mysql_query("DELETE FROM announcement WHERE ann_id='". $rid."'");
	  if($dT){
		  header("Location: view-announcement.php?msg=success");
	  }
  }
  
  ?>     
       
      <?php if(isset($_GET['msg'])) {
			  if($_GET['msg'] == "success") { ?>
				   <div class="alert alert-success">
        our selected <strong>Announcement</strong> deleted successfully
      </div>
	<?php	  }
		  }
	  ?>
       
       
<?php

$select_list = mysql_query("SELECT * FROM announcement ORDER BY `display_from` DESC ");

if(mysql_num_rows($select_list) > 0 ) {
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
                      <th data-sortable="true">Details</th>
                      <th data-sortable="true">From</th>
                      <th data-sortable="true">To</th>
                      <th data-sortable="true">Created</th>
                      <th class="width105">Edit/Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $count = 1;
                   while($row = mysql_fetch_array($select_list)) { ?>
                  	<tr>
                  	<td><?php echo $count; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                     <td><?php echo $row['display_from']; ?></td>
                    <td><?php echo $row['display_to']; ?></td>
                    <td><?php echo $row['created_date']; ?></td>

                    <td><button class="btn btn-success ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Edit <?php echo $row['title']; ?>." onClick="location.href='edit-announcement.php?eid=<?php echo base64_encode(base64_encode($row['ann_id'])); ?>'" type="button"><i class="fa fa-edit"></i></button>
                    
                    <button class="btn btn-primary ui-popover" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-content="Delete <?php echo $row['title']; ?> ." onClick="location.href='view-announcement.php?rid=<?php echo base64_encode(base64_encode($row['ann_id'])); ?>'" type="button"><i class="fa fa-times-circle"></i></button>
                    </td>
                    </tr>
                    <?php $count += 1;} ?>
                  </tbody>
              </table>
              </div>
  <?php } else {?>
  <div class="alert alert-info">
        There is No <strong>announcement</strong> in this list
      </div>
  <!-- NO display items -->
  <?php } ?>          
            
            
            	
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
  <script src="js/plugins/magnific/jquery.magnific-popup.min.js"></script>

  
   <!-- Plugin JS -->
  <script src="./js/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./js/plugins/datatables/DT_bootstrap.js"></script>

  <!-- App JS -->
  <script src="js/target-admin.js"></script>

</body>
</html>
<?php
} else {
	header("Location: welcome.php"); 
}
}
?>