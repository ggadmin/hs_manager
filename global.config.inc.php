<?php
/**
 * @file  global.config.inc.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  Global config file
 *
 * variables for big functions
 */
session_start();
set_include_path(getcwd());
set_include_path(getcwd()."/lib");
date_default_timezone_set('America/New_York');
 // Local database cred
$localdb['dbuser'] 	=	"root";
$localdb['dbpass']	=	"";
$localdb['dbhost']	=	"localhost";
$localdb['gman'] 	=	"geekspace";
#$localdb['seltzer'] 	=	"seltzer";



//Title:
$title = "Geekspace Management & Automation Node";

// Set source path


$where_array = pathinfo($_SERVER['SCRIPT_NAME']);
$where_i_am = $where_array['dirname'];

$gmcfg['source'] = getcwd();
$gmcfg['index'] =  "http://".$_SERVER['HTTP_HOST'].$where_i_am."/index.php";
$gmcfg['loader'] = $where_i_am."/function-loader.php";
$gmcfg['lib_dir'] = $where_i_am."/lib";
//Function lib path relative to the above:
$gmcfg['lib_dir'] = "lib";

//Local tax rate
$gmcfg['tax_rate'] = .07;

?>
