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
		
	/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */
$max_file_size = 1024*400; // 200kb
$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
// thumbnail sizes
$sizes = array(193 => 60);

if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {
	if( $_FILES['image']['size'] < $max_file_size ){
		// get file extension
		$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		if (in_array($ext, $valid_exts)) {
			/* resize image */
			foreach ($sizes as $w => $h) {
				$files[] = resize_logo($w, $h);
			}
			$msg = '<div class="alert alert-success">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Upload image successfully
		</div>';

		} else {
			$msg = '<div class="alert alert-warning">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Unsupported file
		</div>';
		}
	} else{
		$msg = '<div class="alert alert-warning">
			<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
			<i class="fa fa-envelope"></i>&nbsp; Please upload image smaller than 400KB
		</div>';
	}
}
/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */	
		
		
		
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - IP White List</title>

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
        <h2 class="content-header-title">Settings</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Settings</li>
        </ol>
      </div> <!-- /.content-header -->

      

      <div class="row">
      <div class="col-sm-12">
      <div class="col-sm-12">
       <form id="validate-enhanced" method="post" class="form parsley-form">
       
<?php
if(isset($_POST['settings'])) {
	$title = $_POST['title'];
	$update = mysql_query("UPDATE settings SET title='".$title."' WHERE id='1'");
	if($update) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Title</strong> Updated Successfully.
				  </div>';
		}
}
 if(isset($msg)): ?>
<?php echo $msg ?>
		<?php endif ?>
<?php
$settings1 = mysql_fetch_array(mysql_query("SELECT * from settings"));
?>       
       			<div class="form-group">
					<label for="Title">Title: <em class="red-col">*</em></label>
                     
                	<input id="Title" value="<?php echo $settings1['title']; ?> " class="form-control parsley-validated" type="text" data-required="true" name="title">
				</div>
                <div class="form-group">
                  <button type="submit" name="settings" class="btn btn-info"><i class="fa fa-plus-circle"></i> Update Title</button>
                </div>
       </form>
        
      </div>
      
      <div class="col-sm-12">
      <!-- logo upload -->
	  <?php if(!empty($settings1['logo']))  {
                  $logo = $conf_path."/".$settings1['logo'];
			 } else {
				 $logo = $conf_path."/img/default.png";
			 }?>
      <div class="form-group">
		<label for="logo">Logo Upload: (prefereable size 193 x 60 px) <em class="red-col">*</em></label>
        <p>Click below to upload image</p>
        <input id="logo" value="<?php echo $logo; ?> " class="form-control parsley-validated" disabled type="text"  name="logo" >
          <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top:25px">
             <form action="" method="post" enctype="multipart/form-data">
             <input type="submit" value="Upload" class="btn btn-success" />
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="image" accept="image/*" />
                    </span>
                    <br/>
                    <span class="fileupload-preview"></span>
      <button type="button" class="close fileupload-exists" data-dismiss="fileupload" style="float:none">&times;</button>
      
            </form>
          </div>
      </div>
      <hr/>
      </div>
     

        <div class="col-sm-12">
       
			 <div class="col-sm-4">
              <form id="validate-enhanced" method="post" class="form parsley-form">
             <?php
// ADD TASK PART
if(isset($_POST['submit'])) {
	$ip_address = $_POST['ip_address'];
	$date_of_add = date("d-M-Y");

	
	$add_ip = mysql_query("select * from whitelist where ip='".$ip_address."'");
	if(mysql_num_rows($add_ip) == 0 ) {
		$insert_ip = mysql_query("INSERT into whitelist (`ip`,`added_date`) values ('".$ip_address."','".$date_of_add."')");
		if($insert_ip) {
			echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>IP List</strong> Added Successfully.
				  </div>';
		}
	} else {
		echo '<div class="alert alert-danger">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>IP List</strong> are already added.
				  </div>';
	}
}
?>
             
             
             


                <div class="form-group">
					<label for="ip_address">IP Address: <em class="red-col">*</em></label>
                      <div class="alert alert-success">
        		<strong>Information</strong>...<br/>
                Eg ip: 122.174.224.168
			     </div>
                	<input id="ip_address" class="form-control parsley-validated" type="text" data-required="true" name="ip_address">
				</div>
                <div class="form-group">
                  <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add IP List </button>
                </div>
                
                
           </form>
			</div>
             
      
        <div class="col-sm-8">

<?php
// REMOVE TASK PART
if(isset($_GET['rid'])) {
	$removeip = base64_decode(base64_decode($_GET['rid']));
	$delete = mysql_query("DELETE from whitelist where 	wid='".$removeip."'");
	if($delete) {
		header("location: ip-white-list.php?msg=success");
	}
}
?>


        
        
         <div class="portlet">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
               IP whitelist 
              </h3>

            </div> <!--  /.portlet-header -->

           <div class="portlet-content">
           
 <?php
 if(isset($_GET['msg'])) {
	 if($_GET['msg'] == "success") {
		 echo '<div class="alert alert-success">
				  <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
				  <strong>Ip List </strong> removed successfully.
				  </div>';
	 }
 }
 ?>          
           
           
           
           
<?php

$whitelist = mysql_query("SELECT * from whitelist");
if(mysql_num_rows($whitelist) !=0) {
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
                    
                      <th data-filterable="true" data-sortable="true" data-direction="asc">ID</th>
                      <th  data-filterable="true" data-sortable="true">Whitelist IP</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
  <?php
while($iplist = mysql_fetch_array($whitelist))
{
	 ?>               

  
                    <tr class="<?php echo $iplist['wid']; ?>">
                      <td><?php echo $iplist['wid']; ?></td>
                      <td><?php echo $iplist['ip']; ?></td>
                      <td><button class="btn btn-primary taskremove" onClick="location.href='ip-white-list.php?rid=<?php echo base64_encode(base64_encode($iplist['wid'])); ?>'" type="button"><i class="fa fa-trash-o"></i></button> </td>
                    </tr>
<?php } ?>                    
                  </tbody>
                </table>
              </div>

<?php }  else {?>
			<div class="alert alert-danger">
			     <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
        		 There is no <strong>IP Address whitelist</strong>..
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
}

}
?>
