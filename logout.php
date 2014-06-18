<?php
#include './functions.php';
#$act_fields= array();
#$act_fields['logout'] = date("Y-m-d H:i:s",time());
#updateq("update geekspace.activity_log set logout='".$act_fields['logout']."' where cid=".$_SESSION['uid']." and logout IS NULL");

$_SESSION = array();
session_start();
session_destroy();
header ("Location: index.php");
exit();
?>
