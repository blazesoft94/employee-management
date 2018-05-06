<?php $pn = basename($_SERVER['PHP_SELF']); ?>



<?php

/* permission menu */

$pnn = mysql_query("SELECT * FROM `pages` WHERE pagename='".$pn."'");

/* permission menu end */

?>

<div class="mainbar">



  <div class="container">



    <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">

      <i class="fa fa-bars"></i>

    </button>



    <div class="mainbar-collapse collapse">



      <ul class="nav navbar-nav mainbar-nav">



        <li <?php if ($pn == "welcome.php") { ?> class="active" <?php } ?>>

          <a href="<?php echo $conf_path;?>/welcome.php">

            

            Welcome

          </a>

        </li>

<?php  //admin not accessing this page
//suggestion from joby jose
if($_SESSION['role'] != 'admin') { ?>

        <?php } ?>



        <li class="dropdown <?php if ($pn == "apply-leave.php" || $pn == "leave-status.php" || $pn == "leave-summary.php" || $pn == "leave-request-info.php" || $pn == "view-leave-status.php" || $pn == "hr-apply-leave.php") { ?> active <?php } ?>  ">

          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">

           

            Absent and Discipline

            <span class="caret"></span>

          </a>



          <ul class="dropdown-menu">
<?php
//extra feature from joby jose
 if(($_SESSION['role'] != 'admin') && ($_SESSION['role'] != 'manager')) { ?>          

            <li><a href="hr-apply-leave.php">&nbsp;&nbsp;Add Absent</a></li>

            <li><a href="view-leave-status.php">&nbsp;&nbsp;View All Absent status</a></li> 

            <li><a href="add-discipline.php">&nbsp;&nbsp;Add Discipline</a></li>             

            
<?php } ?>
            <!-- Admin Leave Info details -->

             <?php if($_SESSION['role']== 'admin' || $_SESSION['role']== 'manager' ||  in_array("22", $_SESSION['permission']) || in_array("23", $_SESSION['permission']) || in_array("57", $_SESSION['permission'])) { ?> 

            <?php  if(($_SESSION['role'] != 'admin') && ($_SESSION['role'] != 'manager'))  { ?>  <li class="divider"></li> <?php } ?>

			<li class="dropdown-header">Absent and Discipline</li>  
			  <?php if($_SESSION['role']== 'admin' || in_array("56", $_SESSION['permission'])) { ?>

              	<li><a href="hr-apply-leave.php">&nbsp;&nbsp;Apply Absent</a></li> 

                <?php } if($_SESSION['role']== 'admin' || in_array("22", $_SESSION['permission'])) { ?>

              	<li><a href="leave-request-info.php">&nbsp;&nbsp;All Absent Request</a></li> 

                <?php } if($_SESSION['role']== 'admin' || in_array("23", $_SESSION['permission'])) { ?>

            	<li><a href="view-leave-status.php">&nbsp;&nbsp;View All Absent status</a></li> 

                <?php } if($_SESSION['role']== 'admin' || in_array("57", $_SESSION['permission'])) { ?>

            	<li><a href="add-discipline.php">&nbsp;&nbsp;Add Discipline</a></li> 
            	<li><a href="view-discipline-status.php">&nbsp;&nbsp;View and Appoint Discipline</a></li> 

                <?php } ?>

             <?php } ?>

            <!-- // End Admin Leave Info details -->

          </ul>

        </li>  



<!-- view part -->
<!-- View Part End -->
    <?php  if($_SESSION['role']== 'admin' || $_SESSION['role']=='manager'){?>
        <li class="dropdown <?php if ($pn == "attendance-report.php" || $pn == "work-report.php" || $pn == "all-attendance-report.php" || $pn == "all-work-report.php" || $pn == "overall-work-report.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
            Reports
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
<?php  if($_SESSION['role'] == 'user') { ?>
            <li><a href="<?php echo $conf_path;?>/attendance-report.php"> My Attendance</a></li>
            <li><a href="<?php echo $conf_path;?>/work-report.php"> My Work Report</a></li>
            <?php } ?>
            
<?php if($_SESSION['role']== 'admin' || in_array("24", $_SESSION['permission']) || in_array("25", $_SESSION['permission']) || in_array("26", $_SESSION['permission'])) { ?>              

             <?php  if($_SESSION['role'] != 'admin') { ?>   <li class="divider"></li> <?php } ?>

			<li class="dropdown-header">Report Info</li>

            <?php if($_SESSION['role']== 'admin' || in_array("24", $_SESSION['permission'])) { ?>

             <li><a href="<?php echo $conf_path;?>/all-attendance-report.php"> All Attendance Report</a></li>

             <?php } if($_SESSION['role']== 'admin' || in_array("25", $_SESSION['permission'])) { ?>

            <!-- <li><a href="<?php echo $conf_path;?>/all-work-report.php"> All Discipline Report</a></li> -->

            <?php } if($_SESSION['role']== 'admin' || in_array("26", $_SESSION['permission'])) { ?>

            <!-- <li><a href="<?php echo $conf_path;?>/overall-work-report.php">Over All Work Report</a></li> -->

            <?php } } ?>

          </ul>

        </li> 
            <?php }?>




<?php  if($_SESSION['role'] != 'admin') { ?>    
        <li class="dropdown <?php if ($pn == "my-project.php" || $pn == "add-project.php" || $pn == "productivity-target.php" || $pn == "edit-productivity-target.php" || $pn == "add-productivity-target.php" || $pn == "add-project-task.php" || $pn == "project-assignment.php") { ?> active <?php } ?>">

        

          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">My Discipline Assignment

            <span class="caret"></span>

          </a>



          <ul class="dropdown-menu" role="menu">

        <li><a href="my-project.php">&nbsp;&nbsp;View Dicipline Assignment</a></li>  

          </ul>

        </li>
        <?php } ?>

        

       



<?php if($_SESSION['role']== 'admin' || in_array("31", $_SESSION['permission']) || in_array("32", $_SESSION['permission']) || in_array("33", $_SESSION['permission']) || in_array("49", $_SESSION['permission'])  ) { ?>        

         <li class="dropdown <?php if ($pn == "users-list.php" || $pn == "edit-users.php" || $pn == "add-users.php" || $pn == "search-users.php") { ?> active <?php } ?>">

          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Users

            <span class="caret"></span>

          </a>



          <ul class="dropdown-menu" role="menu">

          <?php if($_SESSION['role']== 'admin' || in_array("31", $_SESSION['permission'])) { ?>  

           	<li><a href="users-list.php">&nbsp;&nbsp;Users List</a></li> 

            <?php } if($_SESSION['role']== 'admin' || in_array("32", $_SESSION['permission'])) { ?>  

            <li><a href="add-users.php">&nbsp;&nbsp;Add Users</a></li> 

            <?php } if($_SESSION['role']== 'admin' || in_array("33", $_SESSION['permission'])) { ?>  

            <li><a href="search-users.php">&nbsp;&nbsp;Search User</a></li> 

            <?php } ?>

          </ul>

        </li>

<?php } ?>        

        

        

<!-- OTHER MENU DISPLY -->    

 <?php if(($_SESSION['role']== 'admin') 

 || in_array("37", $_SESSION['permission']) || in_array("38", $_SESSION['permission']) || in_array("39", $_SESSION['permission']) 

 || in_array("40", $_SESSION['permission']) || in_array("41", $_SESSION['permission']) || in_array("42", $_SESSION['permission']) 

 || in_array("43", $_SESSION['permission']) || in_array("44", $_SESSION['permission']) || in_array("45", $_SESSION['permission'])

 || in_array("46", $_SESSION['permission']) || in_array("47", $_SESSION['permission']) || in_array("48", $_SESSION['permission'])) { ?>        

        

        
<?php } ?> 

<?php if($_SESSION['role']== 'admin' || in_array("34", $_SESSION['permission']) || in_array("50", $_SESSION['permission']) || in_array("53", $_SESSION['permission']) || in_array("35", $_SESSION['permission']) || in_array("36", $_SESSION['permission'])) { ?>        
         <li class="dropdown  <?php if ($pn == "add-department.php" || $pn == "holiday.php" || $pn == "ip-white-list.php" || $pn == "role-management.php" || $pn == "user-login-issue.php" ) { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Settings
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
           <?php if($_SESSION['role']== 'admin' || in_array("34", $_SESSION['permission'])) { ?>  

           	<li><a href="add-department.php">&nbsp;&nbsp;Add Department</a></li> 

            <?php } if($_SESSION['role']== 'admin' || in_array("50", $_SESSION['permission'])) { ?> 

            <!-- <li><a href="role-management.php">&nbsp;&nbsp;Role Management</a></li>  -->
            
             <?php } if($_SESSION['role']== 'admin' || in_array("53", $_SESSION['permission'])) { ?>  
             
            <!-- <li><a href="user-login-issue.php">&nbsp;&nbsp;User Login Issue</a></li>  -->

            <?php } if($_SESSION['role']== 'admin' || in_array("35", $_SESSION['permission'])) { ?>  

            <!-- <li><a href="holiday.php">&nbsp;&nbsp;Holiday</a></li>  -->

            <?php } if($_SESSION['role']== 'admin' || in_array("36", $_SESSION['permission'])) { ?>  

            <li><a href="ip-white-list.php">&nbsp;&nbsp;White List IP</a></li> 

            <?php } ?>
          </ul>
        </li>
<?php } ?>      
  

<?php  // if($_SESSION['role']== 'admin' || in_array("54", $_SESSION['permission']) || in_array("55", $_SESSION['permission'])) { ?>        
         <!-- <li class="dropdown <?php if ($pn == "bank-slip.php" || $pn == "bank-slip-genetate.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Accounts
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
          <?php// if($_SESSION['role']== 'admin' || in_array("54", $_SESSION['permission'])) { ?>  
           	<li><a href="bank-slip.php">&nbsp;&nbsp;Bank Slip</a></li> 
            <?php// } ?>
          </ul>
        </li> -->
<?php// } ?>      
     

        



      </ul>



    </div> <!-- /.navbar-collapse -->   



  </div> <!-- /.container --> 



</div> <!-- /.mainbar -->