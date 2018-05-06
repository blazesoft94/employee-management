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
  <title><?php echo $settings['title']; ?> - Bank Slip Part</title>

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
        <h2 class="content-header-title">Bank Slip</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Slip</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">
<?php
// DELETE BANK SLIP
if(isset($_GET['removeid'])) {
	
	$rm = base64_decode(base64_decode($_GET['removeid']));
	$delete = mysql_query("DELETE FROM bank_slip_info where bsi='".$rm."'");
	if($delete) {
		?>
			<div class="alert alert-danger">
            <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
           Bank Slip Remove Successfully
          </div>
          <?php
	}
}
?>  

    <div class="portlet">
	
<div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
              Bank Slip List
              </h3>
<button style="float:right;margin-top:5px; margin-bottom:5px;" onclick="location.href='bank-slip-genetate.php'" type="button" class="btn btn-success"><i class="fa fa-arrow-circle-o-left"></i> Add Bank Slip</button>
            </div>
            <div class="portlet-content">

   
   
   <?php
      $bank_info =  mysql_query("SELECT * FROM bank_slip_info ORDER BY bsi DESC");

   if(mysql_num_rows($bank_info) > 0 ) {
?>
<form method="post" data-validate="parsley" >
           
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
                      <th data-direction="asc" data-sortable="true">#</th>
                      <th data-sortable="true">MONTH_YEAR</th>
                      <th data-sortable="true">TOTAL AMT</th>
                      <th data-sortable="true">PDF</th>
                      <th data-sortable="true">CSV</th>
                      <th data-sortable="true">CREATED DATE</th>
                      <th> X </th>
                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php  $sl = 1;
				  while($row = mysql_fetch_array($bank_info)) { ?>
                  	<tr class="info_slip">
                    
                        <td><?php echo $sl; ?></td>
                        <td><?php echo $row['month_year']; ?></td>
                        <td><?php echo $row['total_amt']; ?></td>
                        <td><a href="<?php echo $row['pdf_path']; ?>" target="_blank"><img src="img/file_pdf.png" width="36" alt="pdf"/></a></td>
                        <td><a href="<?php echo $row['csv_path']; ?>" target="_blank"><img src="img/csv_text.png" width="36" alt="csv"/></a></td>
                        <td><?php echo $row['created_date']; ?></td>
                        <td><button type="button" onclick="location.href='bank-slip.php?removeid=<?php echo base64_encode(base64_encode($row['bsi'])); ?>'" class="btn btn-primary proremove"><i class="fa fa-trash-o"></i></button></td
                    	
                    </tr>
                    <?php $sl += 1; } ?>
                  </tbody>
              </table>
              </div>

</form>              
<?php
   } else { 
   ?>
   <div class="alert alert-success">
            <strong>There is no Bank Slip in this list</strong>
          </div>
  <?php }
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
}
?>
