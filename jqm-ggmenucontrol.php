<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/26/14
 * Time: 11:03 AM
 */
//var_dump($_POST);

$adminMode = false;

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
            $evid = (int)$_POST['evid'];
            $uid = (int)$_POST['uid'];
            $_SESSION['msg'] = signIn($evid, $uid);
            header('Location: jqm-message.php');
            break;
        case "newevent":
            $eventData = array();
            $eventData['eventname'] = $_POST['eName'];
            $eventData['eventdesc'] = $_POST['descrip'];
            $eventData['evstartdate'] = date("Y-m-d H:i:s", strtotime($_POST['startdate']. " ".$_POST['starttime'])) ;
            $eventData['evenddate'] = date("Y-m-d H:i:s", strtotime($_POST['enddate']. " ".$_POST['endtime'])) ;

            $eventData['catid'] = $_POST['category'];
            if ($_SESSION['rid'] >= 3 )
            {
                $eventData['evhostid'] = intval($_POST['evhostid']);
            }
            else
            {
                $eventData['evhostid'] = intval($_SESSION['uid']);
            }


            $_SESSION['msg'] = createEvent($eventData);
            header('Location: jqm-message.php');
            break;
        case "newuser":
            $userData = array();
            $userData['fName'] = $_POST['fName'];
            $userData['lName'] = $_POST['lName'];
            $userData['email'] = $_POST['email'];
            $userData['phone'] = $_POST['phone'];
            $userData['eContact'] = $_POST['eContact'];
            $userData['ePhone'] = $_POST['ePhone'];
            $userData['uid'] = $_POST['uid'];
            
            //FIXME: Password and validation
            $userData['password'] = $_POST['password1'];
            
            $_SESSION['msg'] = createUser($userData);
           
            header('Location: jqm-message.php');
            break;
        case "admin":
            $clientSecret = $_POST['code'];
            break;

    }
}