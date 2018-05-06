<?php $pn = basename($_SERVER['SCRIPT_FILENAME']); ?>
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

        <li class="dropdown <?php if ($pn == "attendance.php" || $pn == "custom-attendance.php") { ?> active <?php } ?> ">
          <a href="#about" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
           
            Attendance
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">   
            <li><a href="<?php echo $conf_path;?>/attendance.php">Daily Attendance</a></li>
            <li><a href="<?php echo $conf_path;?>/custom-attendance.php">Custom Attendance</a></li>
            <!--<li><a href="emergency-attendance.php">Emergency Attendance</a></li>-->
          </ul>
        </li>

        <li class="dropdown <?php if ($pn == "my-work-status.php" || $pn == "tempwork-report.php") { ?> active <?php } ?> ">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
         
         Work
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo $conf_path;?>/my-work-status.php">
            
              Work Status
              </a>
            </li>
            <li>
              <a href="<?php echo $conf_path;?>/tempwork-report.php">
          
              Temporary Work Status
              </a>
            </li>
          </ul>
        </li>

        <li class="dropdown <?php if ($pn == "apply-leave.php" || $pn == "leave-status.php" || $pn == "leave-summary.php" || $pn == "leave-request-info.php" || $pn == "view-leave-status.php") { ?> active <?php } ?>  ">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
           
            Leave
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
            <li><a href="apply-leave.php">
 Apply leave</a></li>
            <li><a href="leave-status.php">leave status</a></li>
            <li><a href="leave-summary.php">leave summary</a></li>
            
            <!-- Admin Leave Info details -->
             <?php if($_SESSION['role']== 'admin') { ?> 
             <li class="divider"></li>
			<li class="dropdown-header">Admin Leave Info</li>  
              <li>
              <a href="leave-request-info.php">
            
              &nbsp;&nbsp;All Leave Request
              </a>
            </li> 
            <li>
              <a href="view-leave-status.php">
             
              &nbsp;&nbsp;View All leave  status
              </a>
            </li> 
             <?php } ?>
            <!-- // End Admin Leave Info details -->
          </ul>
        </li>  

<!-- view part -->

<li class="dropdown <?php if ($pn == "thought-of-the-day.php" || $pn == "appreciation.php" || $pn == "birthdays.php" || $pn == "announcement.php"  || $pn == "view-issues.php"  || $pn == "agendalist.php") { ?> active <?php } ?>  ">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
           
            View
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
            <li><a href="thought-of-the-day.php">Thought of the day</a></li>
 			<li><a href="appreciation.php"> Appreciation</a></li>
            <li><a href="birthdays.php">Birthdays</a></li>
            <li><a href="announcement.php">Announcement</a></li>
            <li><a href="view-issues.php">View issues</a></li>
            <li><a href="agendalist.php">View Agenda</a></li>
           
          </ul>
        </li>  

<!-- View Part End -->






        
        
        <li class="dropdown <?php if ($pn == "attendance-report.php" || $pn == "work-report.php" || $pn == "all-attendance-report.php" || $pn == "all-work-report.php" || $pn == "overall-work-report.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
         
            Reports
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
            <li><a href="<?php echo $conf_path;?>/attendance-report.php"> My Attendance</a></li>
            <li><a href="<?php echo $conf_path;?>/work-report.php"> My Work Report</a></li>
<?php if($_SESSION['role']== 'admin') { ?>              
            <li class="divider"></li>
			<li class="dropdown-header">Admin Report Info</li>
             <li><a href="<?php echo $conf_path;?>/all-attendance-report.php"> All Attendance Report</a></li>
            <li><a href="<?php echo $conf_path;?>/all-work-report.php"> All Work Report</a></li>
            <li><a href="<?php echo $conf_path;?>/overall-work-report.php">
Over All Work Report</a></li>
            <?php } ?>
          </ul>
        </li> 

        <li class="dropdown <?php if ($pn == "my-project.php" || $pn == "add-project.php" || $pn == "productivity-target.php" || $pn == "edit-productivity-target.php" || $pn == "add-productivity-target.php" || $pn == "add-project-task.php" || $pn == "project-assignment.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
           

            Project
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
            <li><a href="my-project.php">&nbsp;&nbsp;My Project</a></li> 
           <?php if($_SESSION['role']== 'admin' || $_SESSION['role']== 'manager') { ?>   
             <li><a href="add-project.php">&nbsp;&nbsp;Add Project</a></li>  
             <li><a href="add-project-task.php">&nbsp;&nbsp;Add Project Task</a></li>          
             <li><a href="project-assignment.php">&nbsp;&nbsp;Project Assignment</a></li>
             <li><a href="productivity-target.php">&nbsp;&nbsp;Productivity Target</a></li> 
             
            <?php } ?>     
          </ul>
        </li>
        
       

<?php if($_SESSION['role']== 'admin') { ?>        
         <li class="dropdown <?php if ($pn == "users-list.php" || $pn == "add-users.php" || $pn == "search-users.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
         
            Users
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
           <li>
              <a href="users-list.php">
            
              &nbsp;&nbsp;Users List
              </a>
            </li> 
            <li>
              <a href="add-users.php">
             
              &nbsp;&nbsp;Add Users
              </a>
            </li> 
            <li>
            <a href="search-users.php">
            
              &nbsp;&nbsp;Search User
              </a>
            </li> 
             
                   
          </ul>
        </li>
        
        
    
        
        
        <li class="dropdown <?php if ($pn == "add-department.php" || $pn == "holiday.php" || $pn == "ip-white-list.php") { ?> active <?php } ?>">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
          
            Others
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
           <li>
              <a href="add-department.php">
              
              &nbsp;&nbsp; Add Department
              </a>
            </li> 
            <li>
              <a href="holiday.php">
            
              &nbsp;&nbsp;Holiday
              </a>
            </li> 
            
             <li>
              <a href="ip-white-list.php">
            
              &nbsp;&nbsp;White List IP
              </a>
            </li> 
            
             <li  class="dropdown-submenu">
              <a href="javascript:;">
            
              &nbsp;&nbsp;Thoughts
              </a>
              	<ul class="dropdown-menu">
                	<li><a href="add-thought-of-the-day.php">&nbsp;&nbsp;Add Thought of the day</a></li>
                    <li><a href="view-thought-of-the-day.php">&nbsp;&nbsp;View Thoughts</a></li>	
                    
                </ul>
            </li> 
            
            
             <li class="dropdown-submenu">
              <a href="javascript:;">
          
              &nbsp;&nbsp;Appreciation
              </a>
              	<ul class="dropdown-menu">
                	<li><a href="add-appreciation.php">&nbsp;&nbsp;Add Appreciation</a></li>
                    <li><a href="view-appreciation.php">&nbsp;&nbsp;View Appreciation</a></li>	
                    
                </ul>
              </li>
              
               <li class="dropdown-submenu">
              <a href="javascript:;">
    
              &nbsp;&nbsp;Announcement
              </a>
              	<ul class="dropdown-menu">
                	<li><a href="add-announcement.php">&nbsp;&nbsp;Add Announcement</a></li>
                    <li><a href="view-announcement.php">&nbsp;&nbsp;View Announcement</a></li>	
                    
                </ul>
              </li>
              <li class="dropdown-submenu">
              <a href="javascript:;">
            
              &nbsp;&nbsp;Events
              </a>
              	<ul class="dropdown-menu">
                	<li><a href="add-events.php">&nbsp;&nbsp;Add Events</a></li>
                    <li><a href="view-events.php">&nbsp;&nbsp;View Events</a></li>	
                    
                </ul>
              </li>
              
            
          </ul>
        </li>
        
<?php } ?>        
        

      </ul>

    </div> <!-- /.navbar-collapse -->   

  </div> <!-- /.container --> 

</div> <!-- /.mainbar -->