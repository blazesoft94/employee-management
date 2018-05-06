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

if(isset($_GET['eid'])) {
	$eid = base64_decode(base64_decode($_GET['eid']));
	$select_l = mysql_query("SELECT * FROM 	appreciation WHERE app_id='".$eid."'");

if(isset($_POST['edit_appreciation'])) {
	 $title = addslashes($_POST['title']);
	 $designation = addslashes($_POST['designation']);
	 $details = addslashes($_POST['details']);
	 $display_date = date('Y-m-d', strtotime($_POST['display_date']));
	 $mod_date = date('Y-m-d');
	 
	 if(empty($title) || empty($details) || empty($_POST['display_date']) || !isset($_FILES['image'])) {
		// please fill all fields
		$msg = '<div class="alert alert-warning">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Please fill all fields
					</div>';
	} else {
			// success date functions
			if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
				//$insert_details = mysql_query("UPDATE appreciation SET `app_name`='".$title."',`app_designation`='".$designation."',`app_details`='".$details."',`display_date`='".$display_date."', `modify_date`='".$mod_date."' WHERE app_id='".$eid."'");
				if($insert_details) {
								// success added
								$msg = '<div class="alert alert-success">
							<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
							<i class="fa fa-envelope"></i>&nbsp; Appreciation added successfully
						</div>';
							} else {
								// error added
								$msg = '<div class="alert alert-warning">
							<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
							<i class="fa fa-envelope"></i>&nbsp; Error Uploading... please try again
						</div>';
							}
				
			} else {
			/* IMAGE UPLOAD SCRIPT AND IT'S FUNCTION */
			$max_file_size = 1024*1024; // 1024kb
			$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
			// thumbnail sizes
			$sizes = array(500 => 500);
			if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_FILES['image'])) {
				if( $_FILES['image']['size'] < $max_file_size ){
					// get file extension
					$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
					if (in_array($ext, $valid_exts)) {
						/* resize image */
						/*foreach ($sizes as $w => $h) {
							$files = resize_thoughts($w, $h);
						}*/
						list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
						$path = resize_app($w,$h);
						/*$path = resize_thoughts(500,500);*/
						$insert_details = mysql_query("UPDATE appreciation SET `app_img`='".$path."',`app_name`='".$title."',`app_designation`='".$designation."',`app_details`='".$details."',`display_date`='".$display_date."', `modify_date`='".$mod_date."' WHERE app_id='".$eid."'");
						if($insert_details) {
							// success added
							$msg = '<div class="alert alert-success">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Appreciation added successfully
					</div>';
						} else {
							// error added
							$msg = '<div class="alert alert-warning">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Error Uploading... please try again
					</div>';
						}
					} else {
						$msg = '<div class="alert alert-warning">
						<a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
						<i class="fa fa-envelope"></i>&nbsp; Unsupported image file (or) Image file empty
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
			}
		
	}

	
}
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Edit Appreciation</title>

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
        <h2 class="content-header-title">Edit Appreciation</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Edit Appreciation</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          
		 
            <div class="portlet">
                <div class="portlet-header">
	              <h3><i class="fa fa-tasks"></i>    Edit Appreciation</h3>
	            </div>
            <div class="portlet-content">
            
     	<?php if(isset($msg)): 
		echo $msg; 
		 endif ?>
<?php
$select_list = mysql_query("SELECT * FROM 	appreciation WHERE app_id='".$eid."'");

 if( mysql_num_rows($select_list) == 1 ) { 

$row = mysql_fetch_array($select_list);?>        
            	 <form method="post" class="form parsley-form col-sm-12" enctype="multipart/form-data" data-validate="parsley">
           
            <div class="col-sm-8">
              <div class="form-group">
                   <label for="t_title">Name of the Appreciant: <em class="red-col"> *</em></label>
                 	<input type="text" name="title" id="title" value="<?php echo $row['app_name']; ?>" class="form-control" data-required="true">
                </div>
                 <div class="form-group">
                   <label for="t_title">Designation:</label>
                 	<input type="text" name="designation" value="<?php echo $row['app_designation']; ?>" id="designation" class="form-control">
                </div>
              <div class="form-group">
                  <label for="display_date">Display Date: <em class="red-col"> *</em></label>
                  <div class="input-group date ui-datepicker">
                      <input id="display_date" name="display_date" value="<?php echo date('m/d/Y', strtotime($row['display_date'])); ?>" class="form-control" type="text" data-required="true">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
             </div>
           
            <div class="col-sm-4">
                  
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $row['app_img']; ?>" alt="Placeholder" /></div>
                  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                  <div>
                    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="image" /></span>
                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                  </div>
              </div> <!-- /.col -->
             </div>
            <div class="col-sm-12">
             <div class="form-group">
                  <label for="textarea-input">Appreciation Details: <em class="red-col"> *</em></label>
                  <textarea class="form-control parsley-validated"  rows="6" cols="10" id="details" name="details"><?php echo $row['app_details']; ?></textarea>
                  </div>
                </div>
             
                 <div class="col-sm-6">
                 <input class="btn  btn-secondary"  type="submit" name="edit_appreciation" id="edit_appreciation" value="Submit"/>
                </div>
               
            </form>
<?php } else { ?>
<!-- selcted id wrong -->
 <div class="alert alert-info">
        There is No <strong>thoughts</strong> to be editable list
      </div>
<?php } ?>           
            
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    

<!-- view inserted thoughts list -->
		
<!-- // view inserted thoughts list -->








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
	<!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="js/plugins/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>

<!-- Place this in the body of the page content -->

  <!-- App JS -->
  <script src="js/target-admin.js"></script>
  
  <!-- Plugin JS -->
  <script src="js/demos/form-extended.js"></script>
    <script src="js/demos/form-validation.js"></script>

</body>
</html>
<?php
} else {
	header("Location:".$_SERVER['HTTP_REFERER']);
}
} else {
	header("Location: welcome.php"); 
}
} ?>