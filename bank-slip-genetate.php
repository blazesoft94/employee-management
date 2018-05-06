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
	
	// generate pdf and send a mail to hr department
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Add Bank Slip Part</title>

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

          

    <div class="portlet">
	
<div class="portlet-header">

              <h3>
                <i class="fa fa-tasks"></i>
              Bank Slip Generete Part
              </h3>
<button style="float:right;margin-top:5px; margin-bottom:5px;" onclick="location.href='bank-slip.php'" type="button" class="btn btn-success"><i class="fa fa-arrow-circle-o-left"></i> Go Back</button>
            </div>
            <div class="portlet-content">
<form method="post" data-validate="parsley" >
   
  <?php
if(isset($_POST['view'])) {
	// multi dimention used to fill the information
	//$month_info = date("m-Y");
	$information = $_POST['info'];
	$amount = '0';
	$month = $_POST['month'];
	$year = $_POST['year'];
	$_SESSION['information'] = $information;
	$_SESSION['information1'] = $_POST['month']." | ".$year;
	
	
	// design the print preview part
	?>
    
<h1>Techware Solution</h1>
<strong>Date :</strong> <?php echo $month; ?> | <?php echo $year; ?> <br/>
<strong>Phone:</strong> + 91 484 319 8381<br/>
<strong>Place:</strong> Heavenly Plaza,ES&FS 7th Floor,Civil Line Road, Vazhakkala, Ernakulam,Kakkanad, Cochin, Kerala 682021, India
<br/><br/>

<table border="1" cellspacing="1" cellpadding="6"  class="pfd_printer">
	<tr bgcolor="#444"  style="color:#f2f2f2;">
		<th style="padding:10px 10px;" width="50px;"><strong>SL.No</strong></th>
		<th style="padding:10px 10px;"><strong>Name</strong></th>
		<th style="padding:10px 10px;"><strong>Bank</strong></th>
		<th style="padding:10px 10px;"><strong>Branch</strong></th>
        <th style="padding:10px 10px;"><strong>Account NO</strong></th>
        <th style="padding:10px 10px;"><strong>IFSC</strong></th>
        <th style="padding:10px 10px;" width="100px;"><strong>Amount</strong></th>
	</tr>
    <?php 
	$list =1 ;
    foreach ($information as $info) {
		// all information about person
		 $username = mysql_real_escape_string($info['username']);
		 $fname = mysql_real_escape_string($info['fname']);
		 $bank_name = mysql_real_escape_string($info['bank_name']);
		 $branch = mysql_real_escape_string($info['branch']);
		 $acc_num = mysql_real_escape_string($info['acc_num']);
		 $ifsc_code = mysql_real_escape_string($info['ifsc_code']);
		 $salary = mysql_real_escape_string($info['amount']);
		 ?>
         <tr>
    		<td><?php echo $list; ?></td>
        	<td><?php echo $fname; ?></td>
        	<td><?php echo $bank_name; ?></td>
        	<td><?php echo $branch; ?></td>
        	<td><?php echo $acc_num; ?></td>
        	<td><?php echo $ifsc_code; ?></td>
        	<td><?php echo $salary; ?></td>
		</tr>
		 <?php
		 // date info for modification find
			 $amount += $salary;
			 $list +=1;
	}
	;
	?>
    <td colspan="6" align="right"><strong>Total</strong></td>
    <td class="amount"><?php echo $amount; ?></td>
    </tr>
    </table>
    <input type="hidden" id="month_info" name="month_info" value="<?php echo $_SESSION['information1']; ?>">
    <input type="hidden" id="amount" name="amount" value="<?php echo $amount; ?>">
    <p style="text-align:center"><button type="button" class="btn btn-success" id="generate" style="float:none; margin-top:15px;" name="generate"><i class="fa fa-arrow-circle-o-right"></i> Generate </button></p>
    <?php
	
} else {
?>
  <?php
      $user_list =  mysql_query("SELECT * FROM users WHERE role!='admin' and (status='active' or status='newuser') ORDER BY emp_id ASC");
$sl = 1;
   if(mysql_num_rows($user_list) > 0 ) {
?>
<!-- selection of data and year part -->
<div class="col-sm-12" style=" background:#f2f2f2; padding-top:15px; padding-bottom:10px; margin-bottom:15px;">
			<div class="col-sm-4" style="padding-left:0">
             <div class="form-group">  
                  <label for="validateSelect">Select Month: </label>
                  <select name="month" class="form-control select2-input" data-required="true">
                    <option value="">Please Select</option>
                    <option value="Jan" <?php if (date('M') == "Jan") { ?> selected <?php } ?>>January</option>
                    <option value="Feb" <?php if (date('M') == "Feb") { ?> selected <?php } ?>>February</option>
                    <option value="Mar" <?php if (date('M') == "Mar") { ?> selected <?php } ?>>March</option>
                    <option value="Apr" <?php if (date('M') == "Apr") { ?> selected <?php } ?>>April</option>
                    <option value="May" <?php if (date('M') == "May") { ?> selected <?php } ?>>May</option>
                    <option value="Jun" <?php if (date('M') == "Jun") { ?> selected <?php } ?>>June</option>
                    <option value="Jul" <?php if (date('M') == "Jul") { ?> selected <?php } ?>>July</option>
                    <option value="Aug" <?php if (date('M') == "Aug") { ?> selected <?php } ?>>August</option>
                    <option value="Sep" <?php if (date('M') == "Sep") { ?> selected <?php } ?>>September</option>
                    <option value="Oct" <?php if (date('M') == "Oct") { ?> selected <?php } ?>>October</option>
                    <option value="Nov" <?php if (date('M') == "Nov") { ?> selected <?php } ?>>November</option>
                    <option value="Dec" <?php if (date('M') == "Dec") { ?> selected <?php } ?>>December</option>
                  </select>
                </div>
                </div>
                <div class="col-sm-4">
                 <div class="form-group">  
                 <label for="validateSelect">Select Year: </label>
                  <select name="year" class="form-control select2-input" data-required="true">
                    <option value="">Please Select</option>
                    <?php
					$yr = date('Y');
					$sy = 2014;
					for($i=$sy;$i<=$yr;$i++) {
					?>
                    <option value="<?php echo $i; ?>" <?php if (date('Y') == $i) { ?> selected <?php } ?>><?php echo $i; ?></option>
                   <?php } ?>
                  </select>
                  </div>
                </div>
                
              <div class="col-sm-4">
                 <div class="form-group"> 
                 <button type="submit" class="btn btn-success" id="view" style="float:right; margin-top:15px;" name="view"><i class="fa fa-arrow-circle-o-right"></i> VIEW </button>
                 </div>
              </div>
</div>
<!-- selection of data and year part -->

           
             <div class="table-responsive">

              <table 
                class="table table-striped table-bordered table-hover table-highlight table-checkable" 
                data-provide="datatable" 
                data-display-rows="25"
                data-info="true"
                data-search="true"
                data-length-change="true"
                data-paginate="true"
              >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Bank</th>
                      <th>Branch</th>
                      <th>Account NO</th>
                      <th>IFSC</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php  
				  while($row = mysql_fetch_array($user_list)) { ?>
                  	<tr class="info_slip">
                        <td><?php echo $sl; ?><input type="hidden" name="info[<?=$sl?>][username]" value="<?php echo $row['username']; ?>"><input type="hidden" name="info[<?=$sl?>][number]" value="<?php echo $sl; ?>"></td>
                    	<td><input type="text" class="form-control slip" name="info[<?=$sl?>][fname]" value="<?php echo $row['fname']; ?>" readonly></td>
                    	<td><input type="text" class="form-control slip" name="info[<?=$sl?>][bank_name]" value="<?php echo $row['bank_name'];?>" readonly></td>
                    	<td><input type="text" class="form-control slip" name="info[<?=$sl?>][branch]" value="<?php echo $row['branch']; ?>" readonly></td>
                    	<td><input type="text" class="form-control slip" name="info[<?=$sl?>][acc_num]" value="<?php echo $row['acc_num']; ?>" readonly></td>
                    	<td><input type="text" class="form-control slip" name="info[<?=$sl?>][ifsc_code]" value="<?php echo $row['ifsc_code']; ?>" readonly></td>
                        <td><input type="text" width="100px" class="form-control" name="info[<?=$sl?>][amount]" tabindex="<?php echo $sl; ?>"></td>
                    </tr>
                    <?php $sl += 1; } ?>
                  </tbody>
              </table>
              
              </div>

        
<?php
   } else { 
   ?>
   <div class="alert alert-success">
            <strong>There is no users in this list</strong>
          </div>
  <?php }
} ?>
     </form>               
          </div>  <!--  /.portlet-content -->
             </div> <!-- /.portlet -->    
             

        
   </div> <!-- /.col -->

      </div> <!-- /.row -->

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->


<?php include_once("includes/footer.php"); ?>

  <script src="js/libs/jquery-1.10.1.min.js"></script>
   <script>

 $(document).ready(function() {

	// task selection

	$("#generate").click(function() {

		var html = $('.pfd_printer').html();
		var amount = $('#amount').val();
		var month_info = $('#month_info').val();
		$.ajax({

			type: "POST",

			url: "bank_slip/path/index.php",

			data: { q:html, amount:amount, info:month_info },

			cache: false,

			success: function(html)

			{
				if(html = "success") {
					alert("SUCCESSFULLY BANK SLIP CREATION");
					location.href='bank-slip.php';
				} else {
					alert (html);
				}

			}

		});

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
