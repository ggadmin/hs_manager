<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/24/14
 * Time: 10:19 PM
 */



$included = true;
require_once("function-loader.php");
require_once("jqm-head.php");
require_once("users.php");
require_once("events.php");
require_once("options.php");


function generateTodaysEventList()
{
    $events =  listEvents("today");
    echo "<pre>";
    print_r($events);
    echo "</pre>";
    $html = "";

    foreach ($events['result'] as $event)
    {
        $html .= '<div data-role="collapsible" data-theme="b" data-content-theme="b">
            <h3>' . $event['eventname'] . '</h3>
            <ul data-role="listview" data-filter="false">';
        if (is_array($event['users']))
        {
            foreach ($event['users'] as $userID)
            {
                $user = getUser((int)$userID);
                if ($user)
                {
                    $html .= '<li>' . $user['fName'] . ' ' . $user['lName'] .'</li>';
                }
            }
        }
        $html .= '<li><a data-transition="slide" href="jqm-ggsignin.php?evid=' . $event['evid'] . '">Sign-In</a></li>
            </ul>
            </div>';
    }
    //$html .= '</ul>';
    echo $html;
}

function generateAdminList()
{
    $html = '<li data-role="list-divider">' . "Admin Controls" . '</li>
    <a data-role="button" href="jqm-ggnewevent.php" data-transition="slideup" >Create Event</a>';
    echo $html;
}

function generateMainPage()
{

    $adminMode = false;

    if (isset($_SESSION['adminmode']))
    {
        $adminMode = $_SESSION['adminmode'];
    }

    $html =
        '<div data-role="page" id="mainPage" data-theme="b" data-title="Geekspace Gwinnett Main">
        <div data-role="header">
        <h1>Geekspace Gwinnett Main</h1>
        </div>';
        if ($msg)
        {
            $html .= '<button disabled="">' . $msg . '</button>';
        }
    $html .=
        '<ul data-role="listview" data-inset="true">
            <li data-role="list-divider">' . "Today's Events" . '</li>';
    echo $html;
    generateTodaysEventList();
    if ($adminMode)
    {
        generateAdminList();
    }

    $html =
        '</ul>
        <div data-role="footer" class="ui-bar">
        <a data-role="button" href="jqm-ggnewuser.php" data-transition="slideup" >New User</a>';
    if ($adminMode)
    {
        $html .= '<a data-role="button" href="logout.php" data-transition="slideup" >Logout</a>';
    }
    else
    {
        $html .= '<a data-role="button" href="jqm-ggadmin.php" data-transition="slideup" >Member Login</a>';
    }

    $html .= '</div>';
    echo $html;

    echo '</div>'; // end of main page
}

echo '<html>';
generateJQMHeader();
echo '<body>';


generateMainPage();
echo '</body>';
echo '</html>';