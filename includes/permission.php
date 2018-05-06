<?php
/* page permission */
	if(isset($_SESSION['permission'])) {
	$pm = mysql_query("SELECT * FROM `pages` WHERE pagename='".basename($_SERVER['PHP_SELF'])."'");
	if(mysql_num_rows($pm) == 1) {
		$upm = mysql_fetch_array($pm);
		if(in_array($upm['p_id'], $_SESSION['permission'])) {
			$permission = "access";
		} else {
			$permission = "failed";
			header("Location: $conf_path/");
		}
	} else {
		$permission = "failed";
	}
	}
	/* page permission */
?>