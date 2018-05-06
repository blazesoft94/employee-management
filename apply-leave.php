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

  <title><?php echo $settings['title']; ?> - My  Leave Apply</title>



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

        <h2 class="content-header-title">Apply leave</h2>

        <ol class="breadcrumb">

          <li><a href="<?php echo $conf_path;?>">Home</a></li>

          <li class="active">Apply leave</li>

        </ol>

      </div> <!-- /.content-header -->



      <div class="row">



        <div class="col-md-12">



          



    <div class="portlet">

	

<div class="portlet-header">



              <h3>

                <i class="fa fa-tasks"></i>

               Leave information

              </h3>
              
              <button class="btn btn-success" type="button" onClick="location.href='holidays-info.php'" style="float:right;margin-top:5px; margin-bottom:5px;"><i class="fa fa-calendar-o"></i> Holiday Info</button>



            </div>

            <div class="portlet-content">
      
<div class="col-sm-6">
            
             <div style="margin:15px;">
            
              <div class="portlet">

                	<div class="portlet-header">
                   	  <h3><i class="fa fa-compass"></i> Techware Holiday List – 2015</h3>
            		</div> <!-- /.portlet-header -->

                	<div class="portlet-content">
                    
                    
                    <div class="table-responsive">
                      <table cellspacing="0" cellpadding="0" class="table table-striped table-bordered table-checkable">
                        <tr>
                          <td valign="bottom"><p align="center">Sl #</p></td>
                          <td colspan="5"><p align="center">National    Holidays - 2015</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">1</p></td>
                          <td colspan="2" valign="bottom"><p>26th January, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Republic Day </p></td>
                          <td valign="bottom"><p>Monday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">2</p></td>
                          <td colspan="2" valign="bottom"><p>01st May, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Labour Day</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">3</p></td>
                          <td colspan="2" valign="bottom"><p>15th August, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Independence Day</p></td>
                          <td valign="bottom"><p>Saturday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">4</p></td>
                          <td colspan="2" valign="bottom"><p>02nd October, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Gandhi Jayanthi</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">Sl #</p></td>
                          <td colspan="5"><p align="center">Festival    Holidays - 2015</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">1</p></td>
                          <td colspan="2" valign="bottom"><p>15th January ,2015</p></td>
                          <td colspan="2" valign="bottom"><p>Pongal</p></td>
                          <td valign="bottom"><p>Thursday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">2</p></td>
                          <td colspan="2" valign="bottom"><p>16th  January,2015</p></td>
                          <td colspan="2" valign="bottom"><p>Pongal</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">3</p></td>
                          <td colspan="2" valign="bottom"><p>17th February, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Shivrathri</p></td>
                          <td valign="bottom"><p>Tuesday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">4</p></td>
                          <td colspan="2" valign="bottom"><p>15th April, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Vishu</p></td>
                          <td valign="bottom"><p>Wednesday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">5</p></td>
                          <td colspan="2" valign="bottom"><p>3rd April, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Good Friday</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">6</p></td>
                          <td colspan="2" valign="bottom"><p>18th July, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Ramzan</p></td>
                          <td valign="bottom"><p>Saturday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">7</p></td>
                          <td colspan="2" valign="bottom"><p>28th August, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Thiru Onam</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">8</p></td>
                          <td colspan="2" valign="bottom"><p>29th August, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Avittam(3rd Onam)</p></td>
                          <td valign="bottom"><p>Saturday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">9</p></td>
                          <td colspan="2" valign="bottom"><p>22nd October, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Mahanavami</p></td>
                          <td valign="bottom"><p>Thursday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">10</p></td>
                          <td colspan="2" valign="bottom"><p>10th November, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Diwali</p></td>
                          <td valign="bottom"><p>Tuesday</p></td>
                        </tr>
                        <tr>
                          <td valign="bottom"><p align="center">11</p></td>
                          <td colspan="2" valign="bottom"><p>25th December, 2015</p></td>
                          <td colspan="2" valign="bottom"><p>Christmas</p></td>
                          <td valign="bottom"><p>Friday</p></td>
                        </tr>
                       
                      </table>
                      </div>
<p><strong class="red-col">Special Notes:</strong>
<hr/>
<em class="red-col"> *</em> December 24 - to be worked on 12th December (Before Christmas), who are needed.<br>
<br>

<em class="red-col"> *</em> For those who take PONGAL leaves (15th & 16th January) there won't be ONAM Leaves (28th & 29th August) and vice–versa.
</p>
                	</div> 
                	<!-- /.portlet-content -->

          		</div>
             </div>
             </div>
            

            <div class="col-sm-6">

            <div style="float:left; width:100%; padding:15px;">

            	<div class="portlet">

                	<div class="portlet-header" style="background:#562f32;">

                    	<h3 style=" color:#f2f2f2"><i class="fa fa-compass" style=" color:#f2f2f2"></i> Leave management</h3>

            		</div> <!-- /.portlet-header -->

                	<div class="portlet-content">

                    <?php

					$lc = '';

					if($users['leave_carry'] == 1) {

						$info = mysql_fetch_array(mysql_query("SELECT * FROM carry_info WHERE user_id='".$users['idu']."'"));

						$lc = $info['carry_left'];

					}

					/* carry option update */

					$mm = date("m");

					$y = date("Y");

					$tds = '';

					 $rowws = mysql_query("SELECT * FROM `leave_management` WHERE username='".$_SESSION['username']."' and 	leave_from like '$mm/%%/$y' and status='1'");

					if(mysql_num_rows($rowws) > 0 ) {

						while($row = mysql_fetch_array($rowws)) {

							$from = $row['leave_from'];

							$to = $row['leave_to'];

							$half_full = $row['half_full'];

							/* day calculation */

							$startTimeStamp = strtotime($from);

							$endTimeStamp = strtotime($to);

							$timeDiff = abs($endTimeStamp - $startTimeStamp);

							$numberDays = $timeDiff/86400;  // 86400 seconds in one day

							// and you might want to convert to integer

							$numberDays = intval($numberDays);

							if($half_full == "half") {

								$tds += $numberDays + 0.5;

							} else {

								$tds += $numberDays+1;

							}

						}

					}

					

				   /* carry option update end */

					

					?>

                    <table class="table table-striped table-bordered table-checkable">

                        <tr><td>Leave Permission<br/> <small>(Per Month)</small></td><td> 2 </td></tr>

                        <tr><td>Carry Left <?php if($users['leave_carry'] == 0) { ?><strong>(Carry Not Alloted for you)</strong> <?php } ?> <br/> <small>(Last Month)</small></td><td> <?php if($lc != '') { echo $lc; } else { ?> 0 <?php } ?></td></tr>

                        <tr><td>Leave taken</td><td><?php echo $tds; ?> </td></tr>

                        <?php $el = (2+$lc);

						$linfo =  abs($el-$tds);

						if($el < $tds) { ?>

                        <tr class="pr-leave"><td >Extra Leave taken</td><td> <?php echo $linfo; ?> </td></tr>

                        <?php } else { ?>

                        <tr class="pg-leave"><td class="pg-leave">Remaining Leave</td><td class="pg-leave"> <?php echo $linfo; ?> </td></tr>

                        <?php } ?>

                    </table>

                	</div> <!-- /.portlet-content -->

          		</div>

            </div>

           </div>
             

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

