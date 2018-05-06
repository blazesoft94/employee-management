<?php 
include_once("includes/config.php");
include_once("includes/function.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));
// $sql = "CREATE table disciplines(
//     di_id int(11) AUTO_INCREMENT primary key,
//     di_emp_idu int(11) NOT NULL,
//     di_date date NOT NULL,
//     di_hour varchar(2) NOT NULL,
//     di_minute varchar(2) NOT NULL,
//     di_meridian varchar(2) NOT NULL,
//     di_location varchar(255) NOT NULL,
//     di_description text NOT NULL,
//     di_witnesses varchar(255) NOT NULL,
//     di_violation varchar(3) NOT NULL,
//     di_p_violation text,
//     di_action text NOT NULL, 
//     di_impropriety varchar(3) NOT NULL,
//     di_explanation text,
//     foreign key (di_emp_idu) references users(idu)
// )";

// $sql = "CREATE table discipline_history(
//     dh_id int(11) AUTO_INCREMENT primary key,
//     dh_di_id int(11) NOT NULL,
//     status_from varchar(50),
//     status_to varchar(50),
//     created_info date NOT NULL,
//     foreign key (dh_di_id) references disciplines(di_id)
// )";


mysql_query($sql);



?>