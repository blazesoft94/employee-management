<?php

// RECOVER MAIL LIST
function recoverPass($to, $title, $url, $from, $username, $salt) {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$title.' <'.$from.'>' . "\r\n";
	$subject = 'Forgot Password - '.$title;
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Techware Solution | Eoffice</title></head><body style="background:#EDEDED "><table style="background-repeat: repeat-x;" width="100%" height="100%" cellpadding="1" cellspacing="0"  bgcolor="#EDEDED"><tr><td valign="top" align="center"><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr><div align="center">
  <table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#c7c7c7;border-top-right-radius:5px;border-top-left-radius:5px">
   <tbody><tr>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
    <td width="570" style="width:427.5pt;padding:0in 0in 0in 0in; color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">
    <h2 style="line-height: 26.25pt; text-align: center; margin-top: 15px; color:#5b5b5b;"><span style="color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">Techware Solution</span></h2>
    </td>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
   </tr>
  </tbody></table>
  </div></table><table width="600" cellpadding="15" cellspacing="0"><tr><td height="1" width="600" bgcolor="#F3F5F9" ></td></tr><tr><td align="left" width="600" bgcolor="#F3F5F9" valign="top" style="font-size:14px;line-height:10px;font-family:Arial, Helvetica, sans-serif; padding: 15px 12px 0 12px; color:#666">Hi  '.$username.',</td></tr><tr><td align="left" width="600" bgcolor="#F3F5F9" valign="top" style="font-size:14px;line-height:20px;font-family:Arial, Helvetica, sans-serif; color:#666"><p> If you have initiated a forgot password request, please click on the link below <br /><br /><a href="'.$url.'/forget-password.php?r=1&username='.$username.'&resetcode='.$salt.'" target="_blank"><center><h1>RESET PASSWORD</h1><center/></a></p></td></tr></table><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr>
  <tr><td valign="top" align="center" style="background:#c7c7c7;border-bottom-right-radius:5px;border-bottom-left-radius:5px"></td></tr></table><div style="font-size:10px;color:gray;margin-bottom:10px"><div>This is an automated email notification for forgot password. If you didn\'t initiate this request, please reset your password <a style="color:#3366cc;text-decoration:none" href="'.$url.'/recover/" target="_blank">here</a></div><div></div></div></div></div></div></body></html>';
	return @mail($to, $subject, $message, $headers);
}

// ANNOUNCEMENT MAIL LIST
function ANNOUNCEMENT($to, $title, $url, $from, $CC, $content,$title_info,$hrmail) {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$title.' <'.$from.'>' . "\r\n";
	$headers .= 'Cc:'.$CC. "\r\n";
	$headers .= 'Bcc:'.$to. "\r\n";
	$subject = ' ANNOUNCEMENT - '.$title;
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Techware Solution | Eoffice</title></head><body style="background:#EDEDED "><table style="background-repeat: repeat-x;" width="100%" height="100%" cellpadding="1" cellspacing="0"  bgcolor="#EDEDED"><tr><td valign="top" align="center"><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr><div align="center">
  <table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#c7c7c7;border-top-right-radius:5px;border-top-left-radius:5px">
   <tbody><tr>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
    <td width="570" style="width:427.5pt;padding:0in 0in 0in 0in; color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">
    <h2 style="line-height: 26.25pt; text-align: center; margin-top: 15px; color:#5b5b5b;"><span style="color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">Techware Solution - Announcement</span></h2>
    </td>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
   </tr>
  </tbody></table>
  </div></table><table width="600" cellpadding="15" cellspacing="0"><tr><td height="1" width="600" bgcolor="#F3F5F9" ></td></tr><tr><td align="left" width="600" bgcolor="#F3F5F9" valign="top" style="font-size:14px;line-height:30px;font-family:Arial, Helvetica, sans-serif; padding: 15px 12px 0 12px; color:#666">
  Hi  All,<br />
  <strong>Announcement Title:</strong>'.$title_info.'<br />
  <strong>Announcement Details:</strong>'.$content.'<br /><br />
  </td></tr><tr><td valign="top" align="center" style="background:#c7c7c7;border-bottom-right-radius:5px;border-bottom-left-radius:5px"></td></tr></table><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr></table><div style="font-size:10px;color:gray;margin-bottom:10px"><div>This is an automated email notification for forgot password. If you didn\'t initiate this request, please reset your password <a style="color:#3366cc;text-decoration:none" href="'.$url.'/recover/" target="_blank">here</a></div><div></div></div></div></div></div></body></html>';
	return @mail($hrmail, $subject, $message, $headers);
}



// APPRECIATION MAIL LIST
function APPRECIATION($to, $title, $url, $from, $CC, $app_name, $app_designation,$app_details,$app_img,$hrmail) {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$title.' <'.$from.'>' . "\r\n";
	$headers .= 'Cc:'.$CC. "\r\n";
	$headers .= 'Bcc:'.$to. "\r\n";
	$subject = ' APPRECIATION - '.$title;
	// image checking
	if($app_img !=''){ $app_img='<tr><td align="center" bgcolor="#F3F5F9" valign="top"><img src="'.$url.'/'.$app_img.'" style="margin:0 auto"/></td></tr>';
	} else {
		$app_img = '';
	}
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Techware Solution | Eoffice</title></head><body style="background:#EDEDED "><table style="background-repeat: repeat-x;" width="100%" height="100%" cellpadding="1" cellspacing="0"  bgcolor="#EDEDED"><tr><td valign="top" align="center"><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr><div align="center">
  <table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#c7c7c7;border-top-right-radius:5px;border-top-left-radius:5px">
   <tbody><tr>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
    <td width="570" style="width:427.5pt;padding:0in 0in 0in 0in; color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">
    <h2 style="line-height: 26.25pt; text-align: center; margin-top: 15px; color:#5b5b5b;"><span style="color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">Techware Solution - Appreciation</span></h2>
    </td>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
   </tr>
  </tbody></table>
  </div></table><table width="600" cellpadding="15" cellspacing="0"><tr><td height="1" width="600" bgcolor="#F3F5F9" ></td></tr>
  '.$app_img.'
  <tr><td align="left" width="600" bgcolor="#F3F5F9" valign="top" style="font-size:14px;line-height:30px;font-family:Arial, Helvetica, sans-serif; padding: 15px 12px 0 12px; color:#666">
  Hi  All,<br /><br />
  <strong>Name of the Appreciant:</strong>'.$app_name.'<br />
  <strong>Designation:</strong>'.$app_designation.'<br />
  <strong>Appreciation Details:</strong>'.$app_details.'<br /><br />
  </td></tr><tr><td valign="top" align="center" style="background:#c7c7c7;border-bottom-right-radius:5px;border-bottom-left-radius:5px"></td></tr></table><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr></table><div style="font-size:10px;color:gray;margin-bottom:10px"><div>This is an automated email notification for forgot password. If you didn\'t initiate this request, please reset your password <a style="color:#3366cc;text-decoration:none" href="'.$url.'/recover/" target="_blank">here</a></div><div></div></div></div></div></div></body></html>';
	return @mail($hrmail, $subject, $message, $headers);
}

// THOUGHTS MAIL LIST
function THOUGHTS($to, $title, $url, $from, $CC, $t_title, $t_details,$hrmail) {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$title.' <'.$from.'>' . "\r\n";
	$headers .= 'Cc:'.$CC. "\r\n";
	$headers .= 'Bcc:'.$to. "\r\n";
	$subject = ' THOUGHTS - '.$title;
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Techware Solution | Eoffice</title></head><body style="background:#EDEDED "><table style="background-repeat: repeat-x;" width="100%" height="100%" cellpadding="1" cellspacing="0"  bgcolor="#EDEDED"><tr><td valign="top" align="center"><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr><div align="center">
  <table border="0" cellspacing="0" cellpadding="0" width="600" style="width:6.25in;background:#c7c7c7;border-top-right-radius:5px;border-top-left-radius:5px">
   <tbody><tr>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
    <td width="570" style="width:427.5pt;padding:0in 0in 0in 0in; color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">
    <h2 style="line-height: 26.25pt; text-align: center; margin-top: 15px; color:#5b5b5b;"><span style="color: rgb(0, 153, 204); font-family: "Arial","sans-serif"; text-align: center;">Techware Solution - Thoughts</span></h2>
    </td>
    <td width="15" style="width:11.25pt;padding:0in 0in 0in 0in"></td>
   </tr>
  </tbody></table>
  </div></table><table width="600" cellpadding="15" cellspacing="0"><tr><td height="1" width="600" bgcolor="#F3F5F9" ></td></tr>
  <tr><td align="left" width="600" bgcolor="#F3F5F9" valign="top" style="font-size:14px;line-height:30px;font-family:Arial, Helvetica, sans-serif; padding: 15px 12px 0 12px; color:#666">
  Today Thoughts,<br />
  <strong>Title:</strong>'.$t_title.'<br />
  <strong>Thoughts:</strong>'.$t_details.'<br /><br />
  </td></tr><tr><td valign="top" align="center" style="background:#c7c7c7;border-bottom-right-radius:5px;border-bottom-left-radius:5px"></td></tr></table><table width="600" cellpadding="0" cellspacing="0"><tr><td height="10" align="center">&nbsp;</td></tr></table><div style="font-size:10px;color:gray;margin-bottom:10px"><div>This is an automated email notification for forgot password. If you didn\'t initiate this request, please reset your password <a style="color:#3366cc;text-decoration:none" href="'.$url.'/recover/" target="_blank">here</a></div><div></div></div></div></div></div></body></html>';
	return @mail($hrmail, $subject, $message, $headers);
}



// IMAGE RESIZE AND UPLOAD SCRIPT

function resize($width, $height){

	/* Get original image x y*/

	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

	/* calculate new image size with ratio */

	$ratio = max($width/$w, $height/$h);

	$h = ceil($height / $ratio);

	$x = ($w - $width / $ratio) / 2;

	$w = ceil($width / $ratio);

	/* new file name */

	$paths = $_FILES['image']['name'];

	$ext = pathinfo($paths, PATHINFO_EXTENSION);

	$path = 'uploads/'.$width.'x'.$height.'_'.$_SESSION['username'].".".$ext;

	/* INSERT INTO DATABASE */

	$imageup = mysql_query(sprintf("Update users set image ='%s' where username = '%s'",mysql_real_escape_string($path),$_SESSION['username']));

	/* read binary data from image file */

	$imgString = file_get_contents($_FILES['image']['tmp_name']);

	/* create image from string */

	$image = imagecreatefromstring($imgString);

	$tmp = imagecreatetruecolor($width, $height);

	imagecopyresampled($tmp, $image,

  	0, 0,

  	$x, 0,

  	$width, $height,

  	$w, $h);

	/* Save image */

	switch ($_FILES['image']['type']) {

		case 'image/jpeg':

			imagejpeg($tmp, $path, 100);

			break;

		case 'image/png':

			imagepng($tmp, $path, 0);

			break;

		case 'image/gif':

			imagegif($tmp, $path);

			break;

		default:

			exit;

			break;

	}

	return $path;

	/* cleanup memory */

	imagedestroy($image);

	imagedestroy($tmp);

}



// mysql_real_escape_string function 

// Escapes a string to render it safe for SQL.

function sql_prep($string) {

		return mysqli_real_escape_string($string);

}



function seconds($seconds)

{

    // extract hours

    $hours = floor($seconds / (60 * 60));

 

    // extract minutes

    $divisor_for_minutes = $seconds % (60 * 60);

    $minutes = floor($divisor_for_minutes / 60);

 

    // extract the remaining seconds

    $divisor_for_seconds = $divisor_for_minutes % 60;

    $seconds = ceil($divisor_for_seconds);

 

    // return the final array

    $obj = array(

        "h" => (int) $hours,

        "m" => (int) $minutes,

        "s" => (int) $seconds,

    );

    return "$obj[h]:$obj[m]:$obj[s]";

}





// THOUGHTS OF THE DAY IMAGE UPDATE

function resize_thoughts($width, $height){

	/* Get original image x y*/

	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

	/* calculate new image size with ratio */

	$ratio = max($width/$w, $height/$h);

	$h = ceil($height / $ratio);

	$x = ($w - $width / $ratio) / 2;

	$w = ceil($width / $ratio);

	/* new file name */

	$paths = $_FILES['image']['name'];

	$ext = pathinfo($paths, PATHINFO_EXTENSION);

	$path = 'uploads/thoughts/'.$width.'x'.$height.'_'.time().'-'.mt_rand().".".$ext;

	/* read binary data from image file */

	$imgString = file_get_contents($_FILES['image']['tmp_name']);

	/* create image from string */

	$image = imagecreatefromstring($imgString);

	$tmp = imagecreatetruecolor($width, $height);

	imagecopyresampled($tmp, $image,

  	0, 0,

  	$x, 0,

  	$width, $height,

  	$w, $h);

	/* Save image */

	switch ($_FILES['image']['type']) {

		case 'image/jpeg':

			imagejpeg($tmp, $path, 100);

			break;

		case 'image/png':

			imagepng($tmp, $path, 0);

			break;

		case 'image/gif':

			imagegif($tmp, $path);

			break;

		default:

			exit;

			break;

	}

	return $path;

	/* cleanup memory */

	imagedestroy($image);

	imagedestroy($tmp);

}

// END THOUGHTS OF THE DAY IMAGE UPDATE



// PROFILE OF THE DAY IMAGE UPDATE

function resize_profile($width, $height){

	/* Get original image x y*/

	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

	/* calculate new image size with ratio */

	$ratio = max($width/$w, $height/$h);

	$h = ceil($height / $ratio);

	$x = ($w - $width / $ratio) / 2;

	$w = ceil($width / $ratio);

	/* new file name */

	$paths = $_FILES['image']['name'];

	$ext = pathinfo($paths, PATHINFO_EXTENSION);

	$path = 'uploads/'.$width.'x'.$height.'_'.time().'-'.mt_rand().".".$ext;

	/* read binary data from image file */

	$imgString = file_get_contents($_FILES['image']['tmp_name']);

	/* create image from string */

	$image = imagecreatefromstring($imgString);

	$tmp = imagecreatetruecolor($width, $height);

	imagecopyresampled($tmp, $image,

  	0, 0,

  	$x, 0,

  	$width, $height,

  	$w, $h);

	/* Save image */

	switch ($_FILES['image']['type']) {

		case 'image/jpeg':

			imagejpeg($tmp, $path, 100);

			break;

		case 'image/png':

			imagepng($tmp, $path, 0);

			break;

		case 'image/gif':

			imagegif($tmp, $path);

			break;

		default:

			exit;

			break;

	}

	return $path;

	/* cleanup memory */

	imagedestroy($image);

	imagedestroy($tmp);

}

// END PROFILE OF THE DAY IMAGE UPDATE





// APPRECIATION OF THE DAY IMAGE UPDATE

function resize_app($width, $height){

	/* Get original image x y*/

	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

	/* calculate new image size with ratio */

	$ratio = max($width/$w, $height/$h);

	$h = ceil($height / $ratio);

	$x = ($w - $width / $ratio) / 2;

	$w = ceil($width / $ratio);

	/* new file name */

	$paths = $_FILES['image']['name'];

	$ext = pathinfo($paths, PATHINFO_EXTENSION);

	$path = 'uploads/appreciation/'.$width.'x'.$height.'_'.time().'-'.mt_rand().".".$ext;

	/* read binary data from image file */

	$imgString = file_get_contents($_FILES['image']['tmp_name']);

	/* create image from string */

	$image = imagecreatefromstring($imgString);

	$tmp = imagecreatetruecolor($width, $height);

	imagecopyresampled($tmp, $image,

  	0, 0,

  	$x, 0,

  	$width, $height,

  	$w, $h);

	/* Save image */

	switch ($_FILES['image']['type']) {

		case 'image/jpeg':

			imagejpeg($tmp, $path, 100);

			break;

		case 'image/png':

			imagepng($tmp, $path, 0);

			break;

		case 'image/gif':

			imagegif($tmp, $path);

			break;

		default:

			exit;

			break;

	}

	return $path;

	/* cleanup memory */

	imagedestroy($image);

	imagedestroy($tmp);

}

// END APPRECIATION OF THE DAY IMAGE UPDATE

// APPLICATION LOGO
// IMAGE RESIZE AND UPLOAD SCRIPT

function resize_logo($width, $height){

	/* Get original image x y*/

	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);

	/* calculate new image size with ratio */

	$ratio = max($width/$w, $height/$h);

	$h = ceil($height / $ratio);

	$x = ($w - $width / $ratio) / 2;

	$w = ceil($width / $ratio);

	/* new file name */

	$paths = $_FILES['image']['name'];

	$ext = pathinfo($paths, PATHINFO_EXTENSION);

	$path = 'uploads/logo.'.$ext;

	/* INSERT INTO DATABASE */

	$imageup = mysql_query(sprintf("Update settings set logo ='%s' where id = '1'",mysql_real_escape_string($path)));

	/* read binary data from image file */

	$imgString = file_get_contents($_FILES['image']['tmp_name']);

	/* create image from string */

	$image = imagecreatefromstring($imgString);

	$tmp = imagecreatetruecolor($width, $height);

	imagecopyresampled($tmp, $image,

  	0, 0,

  	$x, 0,

  	$width, $height,

  	$w, $h);

	/* Save image */

	switch ($_FILES['image']['type']) {

		case 'image/jpeg':

			imagejpeg($tmp, $path, 100);

			break;

		case 'image/png':

			imagepng($tmp, $path, 0);

			break;

		case 'image/gif':

			imagegif($tmp, $path);

			break;

		default:

			exit;

			break;

	}

	return $path;

	/* cleanup memory */

	imagedestroy($image);

	imagedestroy($tmp);

}




?>