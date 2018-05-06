<div class="navbar">

  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <i class="fa fa-cogs"></i>
      </button>

      <a class="navbar-brand navbar-brand-image" href="<?php echo $conf_path;?>">
      <?php if(!empty($settings['logo']))  { $logo = $conf_path."/".$settings['logo']; } else {  $logo = $conf_path."/img/default.png";  }
      ?>
        <img src="<?php echo $logo; ?>" alt="Eoffice">
        <!-- <h2>Pacific Audit Solutions</h2> -->
      </a>

    </div> <!-- /.navbar-header -->

    <div class="navbar-collapse collapse">



      <ul class="nav navbar-nav navbar-right">   

          
          
          

        <li class="dropdown navbar-profile">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
          <?php if(!empty($users['image']))
			 {?>
                  <img class="navbar-profile-avatar" width="45px" src="<?php echo $conf_path;?>/<?php echo $users['image'];?>" alt="<?php echo $users['username'];?>" />
                  <?php
			 }
			 else
			 {
				 ?>
                 <img class="navbar-profile-avatar" width="45px" src="http://www.gravatar.com/avatar/<?php echo md5($users['email_id']);?>?s=250&d=mm" alt="<?php echo $users['username'];?>" />
                 <?php
			 }?>
            <span class="navbar-profile-label"><?php echo $users['username']; ?> &nbsp;</span>
            <i class="fa fa-caret-down"></i>
          </a>

          <ul class="dropdown-menu" role="menu">

            <li>
              <a href="<?php echo $conf_path;?>/my-profile.php">
                <i class="fa fa-user"></i> 
                &nbsp;&nbsp;My Profile
              </a>
            </li>

            <li>
              <a href="<?php echo $conf_path;?>/change-password.php" title="Change Password">
                <i class="fa fa-lock"></i> 
                &nbsp;&nbsp;Change Password
              </a>
            </li>

            <li>
              <a href="<?php echo $conf_path;?>/edit-profile.php">
                <i class="fa fa-cogs"></i> 
                &nbsp;&nbsp;Edit Profile
              </a>
            </li>

            <li class="divider"></li>

            <li>
              <a href="<?php echo $conf_path;?>/logout.php" title="Logout">
                <i class="fa fa-sign-out"></i> 
                &nbsp;&nbsp;Logout
              </a>
            </li>

          </ul>

        </li>

      </ul>

       



       

    </div> <!--/.navbar-collapse -->

  </div> <!-- /.container -->

</div> <!-- /.navbar -->