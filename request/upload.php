<?php
ob_start();
session_start();
include_once("../includes/config.php");
//If directory doesnot exists create it.
echo $output_dir = "../uploads/events/".$_SESSION['event_id']."/";

if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
   {
    
    	if(!is_array($_FILES["myfile"]['name'])) //single file
    	{
            $RandomNum   = time();
            
            $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
            $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
         
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt);
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

       	 	if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $NewImageName)) {
				$success = mysql_query("INSERT INTO events_photos (`event_id`,`photos_url`) VALUES ('".$_SESSION['event_id']."', '".$NewImageName."')");
				
			}
       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
	       	 	 $ret[$fileName]= $output_dir.$NewImageName;
    	}
    	else
    	{
            $fileCount = count($_FILES["myfile"]['name']);
    		for($i=0; $i < $fileCount; $i++)
    		{
                $RandomNum   = time();
            
                $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
                $ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.
             
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt);
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
                
                $ret[$NewImageName]= $output_dir.$NewImageName;
    		    if(move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$NewImageName )) {
				$success = mysql_query("INSERT INTO events_photos (`event_id`,`photos_url`) VALUES ('".$_SESSION['event_id']."', '".$NewImageName."')");
				
			}
    		}
    	}
    }
    echo json_encode($ret);
 
}

?>