<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/12/14
 * Time: 9:21 PM
 */

function findEvents($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'events');

    $events = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $events = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $events = iterator_to_array($cursor);
    }

    return $events;
}

function todaysEvents()
{
    date_default_timezone_set('America/New_York');
    $today = (int)date("Ymd");
    //echo "today-->" . $today;
    return findEvents(array('date' => $today));
}

function getEvent($eventID)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'events');

    echo "eid-->" . $eventID;
    $event = $collection->findOne(array('eid' => (int)$eventID));
    var_dump($event);

    return $event;
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
    if ( array_key_exists( 'date', $eventData ) )
    {
        if ( array_key_exists( 'descrip', $eventData ) )
        {
            return true;
        }
    }
    return false;
}

function createEvent($eventData)
{
    if (!validateEvent($eventData))
    {
        return "Error: eventData is invalid!";
    }

    $eventData['date'] = (int)formatDate($eventData['date']);

    $events = findEvents(array('date' => $eventData['date']));

    $lastEvent = 0;

    foreach ($events as $event )
    {
        if ( $event['eid'] > $lastEvent )
        {
            $lastEvent = $event['eid'];
        }
    }
    if ($lastEvent == 0)
    {
        $today = (int)date("Ymd");
        $lastEvent = $today * 100; // add 2 0's to end of date to make event id format
    }

    // increment event number in id
    $eventData['eid'] = $lastEvent + 1;

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'events');

    if($collection->insert($eventData))
    {
        return "Added Event: " . $eventData['eName'];
    }
    else
    {
        return "Add Event Failed!";
    }
}

function signIn($eventID, $userID)
{
    $usercheck = getUser($userID);
    if (!$usercheck)
    {
        return "ERROR: userID " . $userID . " not found.";
    }

    $event = getEvent($eventID);
    if (!$event)
    {
        return "ERROR: couldn't retrieve event";
    }

    $users = $event['users'];
    if (!$users)
    {
        $users = array($userID);
    }
    else
    {
        $found = false;
        foreach ($users as $user)
        {
            if ($user == $userID)
            {
                $found = true;
            }
        }
        if (!$found)
        {
            $users[] = $userID;
        }
        else
        {
            return "ERROR: User already signed in.";
        }
    }

    if (updateEvent($eventID, array('users' => $users)))
    {
        return "SIGN-IN: SUCCESS";
    }
}

if (!$included)
{
        $events = findEvents();
        echo json_encode($events);
}
