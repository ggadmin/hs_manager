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
        return false;
    }

    $events = findEvents(array('date' => $eventData['date']));

    $lastEvent = 0;

    foreach ($events as $event )
    {
        if ( $event['eid'] > $lastEvent )
        {
            $lastEvent = $event['eid'];
        }
    }

    $eventData['eid'] = $lastEvent + 1;

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'events');

    if($collection->insert($eventData))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function signIn($eventID, $userID)
{
    $event = getEvent($eventID);
    if (!$event)
    {
        echo "couldn't retrieve event";
        return false;
    }

    $users = $event['users'];
    if (!$users)
    {
        $users = array($userID);
    }
    else
    {
        $users[] = $userID;
    }

    return updateEvent($eventID, array('users' => $users));
}

if (!$included)
{
    if ( count($_GET) > 0 )
    {
        $sCriteria = array();
        foreach ($_GET as $key => $value)
        {
            switch ($key)
            {
                case 'eid':
                    $event = getEvent($value);
                    echo json_encode($event);
                    break;
                default:
                    $sCriteria[$key] = $value;
                    break;
            }
        }

        if ( count($sCriteria) > 0 )
        {
            $events = findEvents($sCriteria);
            echo json_encode($events);
        }
    }
    elseif ( count($_POST) > 0 )
    {
        //echo "post request was detected";
        $eventData = array();
        $eventID = NULL;
        foreach ($_POST as $key => $value)
        {
            switch ($key)
            {
                case 'eid':
                    $eventID = $value;
                    break;
                case 'date':
                    echo $value;
                    break;
                default:
                    $eventData[$key] = $value;
                    break;
            }
        }

        //var_dump($eventData);

        if ( count($eventData) > 0 )
        {
            if ($eventID)
            {
                if (updateEvent($eventID, $eventData))
                {
                    $message = "update of event-->" . $eventID . " SUCCESS";
                    echo json_encode(array('message' => $message));
                }
                else
                {
                    $message = "update of event-->" . $eventID . " FAILED";
                    echo json_encode(array('message' => $message));
                }
            }
            else
            {
                if (createEvent($eventData))
                {
                    $message = "creation of new event SUCCESS";
                    echo json_encode(array('message' => $message));
                }
                else
                {
                    $message = "creation of new event FAILED";
                    echo json_encode(array('message' => $message));
                }
            }
        }
    }
    else
    {
        $events = findEvents();
        echo json_encode($events);
    }
}
