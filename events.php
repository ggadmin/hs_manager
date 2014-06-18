<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/12/14
 * Time: 9:21 PM
 */

 //
 
 
 
 // Functions should be in the library and not on the action pages
$page_libs = "form";
require_once("./function-loader.php");
function listEvents($criteria = "future" )
{
    global $databases;
    $current_date = date("Y-m-d");
    switch($criteria)
    {
        
        case "future":
            $action = ">";
            break;
        
        case "past":
            $action = "<";
            break;
        
        case "today":
            $action = "WHERE evstartdate >= '".$current_date." 00:00:00' and evstartdate <= '".$current_date." 23:59:59' ";
            break;
        
        case "all":
            $action= "";
        
    }
    
    
    $get_events = database_query($databases['gman'], "select * from events ".$action." ");
    if ($get_events['count'] == 0)
    {
        $get_events['error'] = "no events today";
    }

    return $get_events;
}

//Event info
function eventinfo($evid)
{
    global $databases;
    
    // trust no input;
    $evid = intval($evid);
    
    $get_events = database_query($databases['gman'], "select * from events where evid = ".$evid);
    if ($get_events['count'] == 0)
    {
        return false;
    }
    $event_info = $get_events['result'];
    
    // We need user registration data
    $get_users =  database_query($databases['gman'], "select * from event_registration where evid = ".$evid." and dtunreg is NULL");
    $event_info['users'] = $get_users['result'];
    
    return $event_info;
}

function updateEvent($eventID, $atts)
{
    if ( !$eventID )
    {
        echo "eventID not set";
        return false;
    }
    elseif (!is_array($atts))
    {
        echo "atts not set properly";
        return false;
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'events');

    $collection->findAndModify(
        array('eid' => (int)$eventID),
        array('$set' => $atts)
    );
    return true;
}

function formatDate($date)
{
    return date("Ymd", strtotime($date));
}

function validateEvent($eventData)
{
    // check for required fields
    if ( array_key_exists( 'evstartdate', $eventData ) )
    {
        if ( array_key_exists( 'eventname', $eventData ) )
        {
            return true;
        }
    }
    return false;
}

function createEvent($eventData)
{
    global $databases;
    if (isset($_SESSION['adminmode']))
    {
    if (!validateEvent($eventData))
    {
        return "Error: eventData is invalid!";
    }
    
    
    //FIXME: Locations. for now, "GG"
    $eventData['evlocation'] = "GG";
  
    if( database_insert($databases['gman'], "events", $eventData))
    {
        return "Added Event: " . $eventData['eventname'];
    }
    else
    {
        return "Add Event Failed!";
    }
    }
}

function signIn($eventID, $userID)
{
    
    global $databases;
    $usercheck = getUser($userID);
    if (!$usercheck)
    {
        return "ERROR: userID " . $userID . " not found.";
    }

    $event = eventinfo($eventID);
    if (!$event)
    {
        return "ERROR: couldn't retrieve event with ID ".$eventID;
    }

    $users = $eventinfo['users'];
    if (!in_array($userID, $users))
    {
        $evid = intval($eventID);
        $uid = intval($userID);
        
        if(database_update($databases['gman'], "insert into event_registration set evid = ".$evid.", uid = ".$uid.", dtattend = CURRENT_TIMESTAMP"))
        {
            return TRUE;
        }
        else
        {
            return "error with signin";
        }
    }
    else
    {
        // user is already signed in.
        return TRUE;
    }
}

if (!$included)
{
        $events = findEvents();
        echo json_encode($events);
}
