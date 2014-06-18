<?php
$page_libs ="auth";
require_once("function-loader.php");

# reset passwords
$password = "testpass";

$salt = user_salt;

$hash = user_hash($password, $salt);

database_update($databases['gman'], "update members set pass = '".$hash."', salt = '".$salt."'");
?>