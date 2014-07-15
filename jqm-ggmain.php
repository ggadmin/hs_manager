<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/24/14
 * Time: 10:19 PM
 */



$included = true;
$page_title= "GMAN Operations Menu";
require_once("function-loader.php");
require_once("jqm-head.php");
require_once("users.php");
require_once("events.php");
require_once("options.php");


function generateTodaysEventList()
{
    $events =  listEvents("today");
    $html = "";
   
    
    foreach ($events as $event)
    {
        
        $eventinfo = eventinfo($event['evid']);
        #print_array($eventinfo,true);
        
        $host_array = getUser($eventinfo['evhostid']);
        $host_name = $host_array['fname']." ".$host_array['lname'];
        
        $html .= '<div data-role="collapsible" data-theme="b" data-content-theme="b">
            <h3>' . $eventinfo['eventname'] . '</h3>
            <ul data-role="listview" data-filter="false">';
            
            $html .= "<li><b>Host: ".$host_name. "</b></li>";
        if ($_SESSION['loggedin']){   
            $html .= '<li><a data-transition="slide" href="eventpage.php?evid=' . $event['evid'] . '">View Attendees</a></li>';
        }
        $html .= '<li><a data-transition="slide" href="jqm-ggsignin.php?evid=' . $event['evid'] . '">Sign-In</a></li>
            </ul>
            </div>';
    }
    //$html .= '</ul>';
    return $html;
}

function generateAdminList()
{
    // User Level 2 (all members)
    $adminMenu = '<li data-role="list-divider">' . "Member Options" . '</li>';
    $adminMenu .= '<a data-role="button" href="jqm-ggnewevent.php" data-transition="slideup" >Create Event</a>';
    $adminMenu .= '<a data-role="button" href="jqm-ggmemberdb.php" data-transition="slideup" >Member Database</a>';
    $adminMenu .= '<a data-role="button" href="jqm-ggeditprofile.php" data-transition="slideup" >My Profile</a>';
    //User Level 3 (staff)
    if ($_SESSION['rid'] >= 3)
    {
        
        $adminMenu .= '<a data-role="button" href="jqm-ggdues.php" data-transition="slideup" >Member Payments</a>';
        $adminMenu .= '<a data-role="button" href="jqm-ggstats.php" data-transition="slideup" >Member Statistics</a>';
    }
    
    return $adminMenu;
}

function generateMainPage()
{

    $adminMode = false;

    if (isset($_SESSION['adminmode']))
    {
        $adminMode = $_SESSION['adminmode'];
    }

      
    $html .=
        '<ul data-role="listview" data-inset="true">
            <li data-role="list-divider">' . "Today's Events" . '</li>';
    
    $html .= generateTodaysEventList();
    if ($adminMode)
    {
        $html .= generateAdminList();
    }

    $html .=
        '</ul>
        <div data-role="footer" class="ui-bar">
        <a data-role="button" href="jqm-ggnewuser.php" data-transition="slideup" >New User</a>';
    if ($adminMode)
    {

        $html .= 'Logged in as '.$_SESSION['fullname'].' <a data-role="button" href="logout.php" data-transition="slideup" >Logout</a>';


        
    }
    else
    {
        $html .= '<a data-role="button" href="jqm-ggadmin.php" data-transition="slideup" >Member Login</a>';
    }

    $html .= '</div></div>';

    return $html;
    
    
}

$html = generateMainPage();

JQMrender($html);