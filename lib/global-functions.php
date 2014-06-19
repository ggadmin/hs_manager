<?php
/**
 * @file   global-functions.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  global function library
 *
 * Functions for use in a lot of places...
 */

 /* Error handling function
*/
function error_page($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
    case E_USER_ERROR:
        $errors= "<b>My ERROR</b> [$errno] $errstr<br />\n";
        $errors.="  Fatal error on line $errline in file $errfile";
        $errors.= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $errors.= "Aborting...<br />\n";
        echo $errors;
        break;

    case E_USER_WARNING:
        $errors= "<b>WARNING</b> [$errno] $errstr<br />\n";
        return $errors;
		break;
		
    case E_USER_NOTICE:
        $bfile = basename($errfile);
        $errors= "<b>FREEMAN:</b> $errstr. (Line $errline in $bfile.)<br />\n";
        echo $errors;
        break;
    
   

    default:
        $errors= "Error: [$errno] $errstr<br />\n";
       #echo $errors;
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}
//Enable error handling first thing we can
$errors = set_error_handler("error_page");

function gman_error($text, $file=__FILE__, $line=__LINE__)
{
    error_page(E_USER_NOTICE, $text, $file, $line);
}


function my_url()
{
    $where_array = pathinfo($_SERVER['SCRIPT_NAME']);
    $where_i_am = $where_array['dirname'];
    return "http://".$_SERVER['HTTP_HOST'].$where_i_am."/".$where_array['basename'];
}

function print_array($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    exit();
}

?>