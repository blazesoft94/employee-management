<?php
ob_start();
include_once("../includes/config.php");
include_once("../includes/function.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));

$date_now = date('Y-m-d');
// anouncement cron job mail function
$select = mysql_query("SELECT * FROM announcement WHERE display_from='".$date_now."'");
if(mysql_num_rows($select) > 0) {
	// multiple announcement sending
	while($row = mysql_fetch_array($select)){
		$users = mysql_query("SELECT * FROM users WHERE (status='active' or status='newuser')");
		if(mysql_num_rows($users) > 0) {
			$employee ='';
			$cc = '';
			while($user = mysql_fetch_array($users)) {
					// cc mail list
				if($user['role'] == "admin") {
					$cc .= $user['email_id'].","; 
				} else {
					// employee mail list
					$employee .= $user['email_id'].",";
				}
			}
			// mail function list
			// remove last comma
			$cc = substr($cc, 0, -1);
			$employee = substr($employee, 0, -1);
			$content = addslashes($row['content']);
			$title_info = addslashes($row['title']);
			ANNOUNCEMENT($employee,$settings['title'],$conf_path,$conf_mail,$cc, $content, $title_info,$hrmail);
		}
	}
}


// Appreciation cron job mail function
$select_app = mysql_query("SELECT * FROM appreciation WHERE display_date='".$date_now."'");
if(mysql_num_rows($select_app) > 0) {
	// multiple announcement sending
	while($app = mysql_fetch_array($select_app)){
		$users = mysql_query("SELECT * FROM users WHERE (status='active' or status='newuser')");
		if(mysql_num_rows($users) > 0) {
			$employee ='';
			$cc = '';
			while($user = mysql_fetch_array($users)) {
					// cc mail list
				if($user['role'] == "admin") {
					$cc .= $user['email_id'].","; 
				} else {
					// employee mail list
					$employee .= $user['email_id'].",";
				}
			}
			// mail function list
			// remove last comma
			$cc = substr($cc, 0, -1);
			$employee = substr($employee, 0, -1);
			$app_name = addslashes($app['app_name']);
			$app_designation = addslashes($app['app_designation']);
			$app_details = addslashes($app['app_details']);
			if(!empty($app['app_img'])) {
			$app_img = $app['app_img'];
			} else { 
			$app_img = '';
			}
			APPRECIATION($employee,$settings['title'],$conf_path,$conf_mail,$cc, $app_name, $app_designation,$app_details,$app_img,$hrmail);
		}
	}
}



// Thoughts cron job mail function
$select_thoughts = mysql_query("SELECT * FROM thoughts WHERE display_date='".$date_now."'");
if(mysql_num_rows($select_thoughts) > 0) {
	// multiple announcement sending
	while($thoughts = mysql_fetch_array($select_thoughts)){
		$users = mysql_query("SELECT * FROM users WHERE (status='active' or status='newuser')");
		if(mysql_num_rows($users) > 0) {
			$employee ='';
			$cc = '';
			while($user = mysql_fetch_array($users)) {
					// cc mail list
				if($user['role'] == "admin") {
					$cc .= $user['email_id'].","; 
				} else {
					// employee mail list
					$employee .= $user['email_id'].",";
				}
			}
			// mail function list
			// remove last comma
			$cc = substr($cc, 0, -1);
			$employee = substr($employee, 0, -1);
			
			$t_title = addslashes($thoughts['t_title']);
			$t_details = addslashes($thoughts['t_details']);
			
			// THOUGHTS($employee,$settings['title'],$conf_path,$conf_mail,$cc, $t_title, $t_details,$hrmail);
		}
	}
}

echo "error";
?>