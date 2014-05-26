<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/26/14
 * Time: 11:03 AM
 */
var_dump($_POST);
session_start();
$adminMode = false;
$msg = NULL;

$included = true;
require_once("jqm-head.php");
require_once("users.php");
require_once("events.php");
require_once("options.php");

if (isset($_SESSION['adminmode']))
{
    $adminMode = $_SESSION['adminmode'];
}


if (isset($_POST['cmd']))
{
    echo "received cmd";
    switch ($_POST['cmd'])
    {
        case "signin":
            $eid = (int)$_POST['eid'];
            $uid = (int)$_POST['uid'];
            $msg = signIn($eid, $uid);
            echo $msg;
            //header('Location: jqm-ggmain.php');
            break;
        case "newevent":
            $eventData = array();
            $eventData['eName'] = $_POST['eName'];
            $eventData['category'] = $_POST['category'];
            $eventData['descrip'] = $_POST['descrip'];
            $eventData['date'] = $_POST['date'];
            $msg = createEvent($eventData);
            echo $msg;
            break;
        case "newuser":
            $userData = array();
            $userData['fName'] = $_POST['fName'];
            $userData['lName'] = $_POST['lName'];
            $userData['email'] = $_POST['email'];
            $userData['phone'] = $_POST['phone'];
            $userData['eContact'] = $_POST['eContact'];
            $userData['ePhone'] = $_POST['ePhone'];
            $msg = createUser($userData);
            echo $msg;
            break;
        case "admin":
            $clientSecret = $_POST['code'];
            break;

    }
}