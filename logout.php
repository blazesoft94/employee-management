<?php
ob_start();
session_start();
include_once("includes/config.php");
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['role']);
session_destroy();
header("Location: $conf_path");
?>