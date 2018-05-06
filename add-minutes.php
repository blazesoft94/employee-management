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
	if($_SESSION['role'] == 'admin') {
	$users = mysql_fetch_array(mysql_query(sprintf("select * from users where username ='%s'",mysql_real_escape_string($_SESSION['username']))));
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title><?php echo $settings['title']; ?> - Add Agenda</title>

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
        <h2 class="content-header-title">Add Minutes</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Add Minutes</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> Minutes Information</h3>
        
        </div>
        <div class="portlet-content">
<?php if(isset($_GET['msg'])){
	  if($_GET['msg'] == "created") { ?>
 <div class="alert alert-success">
 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
       Issues Added Successfully
      </div>
<?php } } ?>
	   
   
   
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
          
        <div class="col-md-12">
          <div class="col-md-12">
          <!-- table start -->
           <div class="table-responsive">

              <table align="center" 
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
                      <th data-sortable="true">Attendees</th>
                      <th data-sortable="true">Present</th>
                      <th data-sortable="true">Proxy Member</th>
                      <th data-sortable="true">Reason For Absense</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  </table>
                  </div>
           <!-- table end -->
           
           </div>
           
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="next" class="btn btn-success"><i class="fa fa-plus-circle"></i> Next </button>
                </div>
          </div>
          </div>
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
  //this will move selected items from source list to destination list			
	function move_list_items(sourceid, destinationid)
	{
		//$('#mpb option').remove();
		$("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
		//alert($('select[name=to_select_list]').val());
		//$('#to_select_list option').appendTo("#mpb");
		$("select#to_select_list option").each(function() {
		$("select#to_select_list option").prop("selected", "selected");
		}); 
		clientlist();
	}

	//this will move all selected items from source list to destination list
	function move_list_items_all(sourceid, destinationid)
	{
		//$('#mpb option').remove();
		$("#"+sourceid+" option").appendTo("#"+destinationid);
		$("select#to_select_list option").each(function() {
		$("select#to_select_list option").prop("selected", "selected");
		});
		//$('#to_select_list option').appendTo("#mpb");
		//alert($('select[name=to_select_list]').val());
		clientlist();
	}
	function clientlist() {
		$('#mpb option').remove();
		$("#to_select_list option").each(function() {
    		// add $(this).val() to your list
			$a = $(this).val();
			$b = $(this).text();
			$("#mpb").append(new Option($b, $a));
		});
	}
	
	$(document).ready(function() {
	// task selection
	$('#generate').click(function() {
		/* remove information */
		$('select#from_select_list option').remove();
		$('select#to_select_list option').remove();
		/* remove information */
		var id = $(".department_name").val();
		var dataString = 'q='+ id;
		$.ajax({
			type: "POST",
			url: "request/dept_user.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				alert(html);
			$("#from_select_list").html(html);
			}
		});
		
	});
	$(".department_name").change(function() {
		/* remove information */
		$('select#from_select_list option').remove();
		$('select#to_select_list option').remove();
		$('select#mpb option').remove();
		$('#mpb').append($("<option></option>").attr("value","").text("[ SELECT ]")); 
		
		/* remove information */
	});
	/*$(".department_name").change(function() {
		var id=$(this).val();
		var dataString = 'q='+ id;
		$.ajax({
			type: "POST",
			url: "request/dept_user.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#from_select_list").html(html);
			}
		});
	});*/
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
