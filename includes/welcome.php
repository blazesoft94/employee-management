<?php
$unique_array1 = $unique_array2 = $unique_array3 = array();
//$sql1 = mysql_query("SELECT * FROM announcement");
$sql1 = mysql_query("SELECT * FROM announcement WHERE display_from <= '".date("Y-m-d")."'");
if(mysql_num_rows($sql1) > 0) {
	while($row = mysql_fetch_array($sql1)) {
		// create array
		$unique_array1[] = array('id'=>$row['ann_id'], 'date_info'=>$row['display_from'], 'table'=>"announcement");
	}
}
//$sql2 = mysql_query("SELECT * FROM appreciation");
 $sql2 = mysql_query("SELECT * FROM appreciation  WHERE display_date <= '".date("Y-m-d")."'");
if(mysql_num_rows($sql2) > 0) {
	while($row2 = mysql_fetch_array($sql2)) {
		// create array
		$unique_array2[] = array('id'=>$row2['app_id'], 'date_info'=>$row2['display_date'], 'table'=>"appreciation");
	}
}
//$sql3 = mysql_query("SELECT * FROM thoughts ");
$sql3 = mysql_query("SELECT * FROM thoughts WHERE display_date <= '".date("Y-m-d")."'"); 
if(mysql_num_rows($sql3) > 0) {
	while($row3 = mysql_fetch_array($sql3)) {
		// create array
		$unique_array3[] = array('id'=>$row3['tid'], 'date_info'=>$row3['display_date'], 'table'=>"thoughts");
	}
}
// merge 3 array
$main_array = array_merge($unique_array1, $unique_array2, $unique_array3);

// var_dump($main_array);
// acending order array sort
/* 1st methods */
/*function date_compare($a, $b)
{
    $t1 = strtotime($a['date_info']);
    $t2 = strtotime($b['date_info']);
    return $t1 - $t2;
}*/
// descending order array sort
function date_compare($a, $b)
{
    $t1 = strtotime($a['date_info']);
    $t2 = strtotime($b['date_info']);
    return $t2 - $t1;
}
usort($main_array, 'date_compare');
//var_dump($main_array);
/* 1st method end */
// 2nd methods 
/*uasort($main_array, function($a, $b){
    $format = 'd-m-Y'; 
    $ascending = false;
    $zone = new DateTimeZone('UTC');
    $d1 = DateTime::createFromFormat($format, $a[1], $zone)->getTimestamp();
    $d2 = DateTime::createFromFormat($format, $b[1], $zone)->getTimestamp();
    return $ascending ? ($d1 - $d2) : ($d2 - $d1);
}); */
// 2nd method end
?>