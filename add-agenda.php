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
	/* page permission */
	$pm = mysql_fetch_array(mysql_query("SELECT * FROM `pages` WHERE pagename='".basename($_SERVER['PHP_SELF'])."'"));
	if(in_array($pm['p_id'], $_SESSION['permission'])) {
		$permission = "access";
	} else {
		$permission = "failed";
		header("Location: $conf_path/");
	}
	/* page permission */
	if(($_SESSION['role'] == 'admin') || ($permission == "access")) {
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
        <h2 class="content-header-title">Add Agenda</h2>
        <ol class="breadcrumb">
          <li><a href="<?php echo $conf_path;?>">Home</a></li>
          <li class="active">Add Agenda</li>
        </ol>
      </div> <!-- /.content-header -->

      <div class="row">

        <div class="col-md-12">

          

    <div class="portlet">
	
		<div class="portlet-header"><h3><i class="fa fa-user"></i> Agenda Information</h3>
        <button class="btn btn-success" type="button" onClick="location.href='agendalist.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-arrow-circle-o-left"></i> Search Agenda</button>
        </div>
        <div class="portlet-content">
<?php if(isset($_GET['msg'])){
	  if($_GET['msg'] == "created") { ?>
 <div class="alert alert-success">
 <a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
       Agenda Added Successfully
      </div>
<?php } } ?>
	   
   
   
   
   		  <form id="validate-basic" method="post" data-validate="parsley" class="form parsley-form form-horizontal">
          
<?php
if(isset($_POST['add_agenda'])) {
	// subject
	 $subject = $_POST['subject'];
	 $others = $_POST['others'];
	 // date 
	 $posted_date = date('Y-m-d H:i:s',strtotime($_POST['posted_date']));
	  // description and other info
	 $description = $_POST['description'];
	 $venue = $_POST['venue'];
	 if(!empty($_POST['st_hr']) and !empty($_POST['st_min'])) {
	 	  $start_time = $_POST['st_hr'].":".$_POST['st_min'];
	 } else {
		  $start_time='';
	 }
	 
	 if(!empty($_POST['end_hr']) and !empty($_POST['end_min'])) {
	 	  $end_time = $_POST['end_hr'].":".$_POST['end_min'];
	 } else {
		  $end_time='';
	 }
	 //$end_time = $_POST['end_hr'].":".$_POST['end_min'];
	 $department = implode(',', $_POST['department']);
	 $users_list = implode(',', $_POST['to_select_list']);
	 
	 $guest = $_POST['guest'];
	 $mpb = $_POST['mpb'];
	
	 $date_info = date('Y-m-d H:i:s');
	 
	 
		$query = mysql_query("INSERT INTO agenda (`subject`, `o_subject`, `a_date`, `description`, `venue`,`time_from`, `time_to`,`department`,`guest`,`min_prepare`,`created_date`,`modified_date`,`decision`) VALUES ('".$subject."','".$others."','".$posted_date."','".$description."','".$venue."','".$start_time."','".$end_time."','".$department."','".$guest."','".$mpb."','".$date_info."','','')");
		if($query) {
			$ida = mysql_insert_id();
			$lst_user = explode(',',$users_list); 
			foreach($lst_user as $luser) {
				mysql_query("INSERT INTO agenda_users (`agenda_id`,`user_id`,`present`,`reason`,`proxy`) VALUES ('".$ida."','".$luser."','','','')");
			}
			header ("Location:add-agenda.php?msg=created");
		} else {
			echo mysql_error(); 
		}
}
?>          <div class="col-md-12">
          <div class="col-md-8">
           <!--<div class="form-group">
           <label for="name" class="col-md-3">Division: </label>
		   <div class="col-md-8">
          	 <select class="form-control project_name" data-required="true"  name="responsibility">
              	<option value="">[ Select ]</option>
              </select>
            </div>
            </div>-->
            
             
			
           <div class="form-group">
           <label for="name" class="col-md-3">Subject: <em class="red-col">*</em></label>
		   <div class="col-md-8">
           <select name="subject" data-required="true" class="form-control" >
           <option value="">[ Select ]</option>
           <option value="survey">survey</option>
           </select><br>
			<p>If others: </p><input type="text" name="others" placeholder="If other subject entyr here ..." class="form-control"/>
            </div>
            </div>
            
            
            
            
             <div class="form-group">
           <label for="name" class="col-md-3" >Date: <em class="red-col">*</em></label>
		   <div class="col-md-8">
          <div id="dp-ex-3" class="input-group date" data-auto-close="true"  data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                   <input data-required="true" class="form-control" type="text" name="posted_date">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
               </div>
            </div>
            </div>
            
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Description: <em class="red-col">*</em></label>
		   <div class="col-md-8">
           <textarea class="form-control" data-required="true" name="description" style="height:120px;" placeholder="Detail description of issues"></textarea>
            </div>
            </div>
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Venue: </label>
		   <div class="col-md-8">
           <input type="text" name="venue" class="form-control" placeholder="venue information"/>
            </div>
            </div>
            
            <div class="form-group">
           <label for="name" class="col-md-3">Time: </label>
		   <div class="col-md-8">
          
          
              <div class="col-md-6" style="padding-right:0;">
               <span style="float:left; padding-top:5px;">From</span> 
              <label style="float:left; padding-top:5px; margin-left:5px; margin-right:5px; font-weight:normal">Hr</label>
               <select class="form-control" name="st_hr" style="width:140px;">
               <option selected value="">[ Select Hour ]</option>
                <?php $j = '00';
				while($j < '24') {
					if(strlen($j) == 1) {
						$j = '0'.$j;
						 echo "<option value='$j'>$j</option>";
					} else {
                echo "<option value='$j'>$j</option>";
					}
                $j += '01';} ?>
                </select>
               </div>
               
                
              <div class="col-md-6" style="padding-left:0;">
              <label style="float:left; padding-top:5px; margin-left:10px; margin-right:5px; font-weight:normal">Min</label>
              <select class="form-control" name="st_min" style="width:160px;">
               <option selected value="">[ Select Minute ]</option>
                 <?php $i = '00';
				while($i < '61') {
					if(strlen($i) == 1) {
						$i = '0'.$i;
						 echo "<option value='$i'>$i</option>";
					} else {
                echo "<option value='$i'>$i</option>";
					}
                $i += '01';} ?>
                </select>
               
               </div>
               <div style="clear:both; height:15px; width:100%"></div>
               <div class="col-md-6" style="padding-right:0;">
               <span style="float:left; padding-top:5px;">To</span> 
              <label style="float:left; padding-top:5px; margin-left:20px; margin-right:5px; font-weight:normal">Hr</label>
               <select class="form-control" name="end_hr" style="width:140px;">
               <option selected value="">[ Select Hour ]</option>
                <?php $j = '00';
				while($j < '24') {
					if(strlen($j) == 1) {
						$j = '0'.$j;
						 echo "<option value='$j'>$j</option>";
					} else {
                echo "<option value='$j'>$j</option>";
					}
                $j += '01';} ?>
                </select>
               </div>
               
                
              <div class="col-md-6" style="padding-left:0;">
              <label style="float:left; padding-top:5px; margin-left:10px; margin-right:5px; font-weight:normal">Min</label>
              <select class="form-control" name="end_min" style="width:160px;">
               <option selected value="">[ Select Minute ]</option>
                 <?php $i = '00';
				while($i < '61') {
					if(strlen($i) == 1) {
						$i = '0'.$i;
						 echo "<option value='$i'>$i</option>";
					} else {
                echo "<option value='$i'>$i</option>";
					}
                $i += '01';} ?>
                </select>
               
               </div>
               
            </div>
            
          
              
               
            </div>
            
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Department: </label>
		   <div class="col-md-8">
           <select name="department[]" multiple class="form-control department_name" >
           <option value="all" selected>[ Any ]</option>
          <?php
		   $query = mysql_query("SELECT * FROM department");
		   while($dpt = mysql_fetch_array($query)) {
			   
			   echo '<option value="'.$dpt['department_name'].'">'.$dpt['department_name'].'</option>';
		   }
		   ?>
           </select>
           <button type="button" name="generate" id="generate" style="margin-top:15px;" class="btn btn-success">Generate</button>
            </div>
            </div>
            
            
            <!-- multiple users seslection -->
            <div class="form-group">
            <label for="name" class="col-md-3">users: <em class="red-col">*</em> </label>
            <div class="col-md-8">
            	<div class="col-md-5" style="padding-left:0; padding-right:0;">
                 <select class="form-control" id="from_select_list" style="height:150px" multiple="multiple" name="from_select_list[]"> 
        			<?php
		   $query1 = mysql_query("SELECT * FROM users WHERE role!='director' and (status!='disabled' and status!='resigned')");
		   while($ulist = mysql_fetch_array($query1)) {
			   
			   echo '<option value="'.$ulist['username'].'">'.$ulist['fname']." ( ".$ulist['username']." ) ".'</option>';
		   }
		   ?>
        		</select>
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-default" style=" width:40px; margin-bottom:5px;" id="moveright" onclick="move_list_items('from_select_list','to_select_list');"> &gt; </button>
                <button type="button" class="btn btn-default"  style=" width:40px; margin-bottom:5px;" id="moverightall" onclick="move_list_items_all('from_select_list','to_select_list');"> &gt;&gt; </button>
                <button type="button" class="btn btn-default"  style=" width:40px; margin-bottom:5px;" id="moveleft" onclick="move_list_items('to_select_list','from_select_list');" >  &lt; </button>
                <button type="button" class="btn btn-default"  style=" width:40px;" id="moveleftall" onclick="move_list_items_all('to_select_list','from_select_list');"> &lt;&lt; </button>
                </div>
                <div class="col-md-5" style="padding-left:0; padding-right:0;">
                <select class="form-control" data-required="true" id="to_select_list" style="height:150px" multiple="multiple" name="to_select_list[]"> 
        		</select>
                </div>
            </div>
            </div>
            <!-- multiple users seslection -->
            
            
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Add Guest: </label>
		   <div class="col-md-8">
           <input type="text" name="guest" class="form-control" placeholder="Guest information"/>
            </div>
            </div>
            
            
            <div class="form-group">
           <label for="name" class="col-md-3">Minutes <br>
Prepared By: <em class="red-col">*</em></label>
		   <div class="col-md-8">
         	<select name="mpb" data-required="true" id="mpb" class="form-control">
            <option selected value="">[ SELECT ]</option>
            </select>
            </div>
            </div>
           
           </div>
           
            <div class="col-md-4">
          </div>
         </div> 
         
         <div class="col-md-12">
         <div class="col-md-8">
                <div class="form-group">
                  <button type="submit"  name="add_agenda" class="btn btn-success"><i class="fa fa-plus-circle"></i> Submit </button>
                  <button type="reset"  name="Reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset </button>
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
				//alert(html);
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
