<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/12/14
 * Time: 11:51 PM
 */

$included = true;
require_once("users.php");
require_once("events.php");
require_once("options.php");

function generateJQMHeader()
{
    $html =
    '<head>'
        . '<meta name="viewport" content="width=device-width, initial-scale=1">'
        . '<script src="js/jquery-1.11.0.min.js"></script>'
        . '<script src="jqm/jquery.mobile-1.4.2.min.js"></script>'
        . '<link href="jqm/jquery.mobile.structure-1.4.2.min.css" rel="stylesheet">'
        . '<link href="jqm/jquery.mobile.theme-1.4.2.min.css" rel="stylesheet">'
        . '<title>GG Main</title>'
  . '</head>';
    echo $html;
}

function generateLastMsg($msg)
{
    $html = NULL;
    if ($msg)
    {
        $html = '<button disabled="">' . $msg . '</button>';
    }
    else
    {
        //$html = '<button disabled="">' . 'Nothing to report here!' . '</button>';
        $html = '';
    }
    echo $html;
}

function generateUserList($id, $users)
{
    $html =
    '<div data-role="dialog" id="e' .$id .'" data-theme="b" data-title="Users">'
        . '<div data-role="header">'
            . '<h1>Select User</h1>'
        . '</div>'
        . '<div data-role="content">'
            . '<ol data-role="listview" data-inset="true" data-theme="b" data-filter="true" data-filter-placeholder="name">';

    foreach ($users as $user)
    {
        $html .= '<li><a href="index.php?'
            . 'eid=' . $id . '&'
            . 'uid=' . $user['uid'] . '">'
            . $user['fName'] . ' ' . $user['lName']
            . '</a></li>';
    }

    $html .= '</ol>'
        . '</div>'
        . '</div>';
    echo $html;
}

function generateEventList($events)
{
    $html =
    '<ul data-role="listview" data-inset="true">'
        . '<li data-role="list-divider">' . "Today's Events" . '</li>';

    foreach ($events as $event)
    {
        $html .= '<div data-role="collapsible" data-theme="b" data-content-theme="b">'
                    . '<h3>' . $event['descrip'] . '</h3>'
                    . '<ul data-role="listview" data-filter="false">';
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
                        $html .= '<li><a href="#e' . $event['eid'] . '">Sign-In' . '</a></li>'
                    . '</ul>'
                . '</div>';
    }
    $html .= '</ul>';
    echo $html;
}

function generateNewEventPage()
{
    $html =
        '<div data-role="page" id="newEventPage" data-theme="b" data-title="New Event">'
        . '<div data-role="header" data-theme="b">'
            . '<h1>New Event</h1>'
        . '</div>'
        . '<div data-role="content">'
            . '<form id="newEvent" class="ui-body ui-body-b ui-corner-all" action="events.php" data-ajax="false" method="POST">'
                . '<div data-role="fieldcontain">'
                    . '<label for="eName">Event Name</label>'
                    . '<input type="text" id="eName" name="eName">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="category">Category</label>';
                    $html .= '<select id="category" name="category">';
                    $options = getOptions("eCategory");
                    foreach ($options['options'] as $option)
                    {
                        $html .= '<option value="' . $option . '">' . $option . '</option>';
                    }
                    $html .= '</select>'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="descrip">Description</label>'
                    . '<input type="text" id="descrip" name="descrip">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="date">Date</label>'
                    . '<input type="date" id="date" name="date" value="">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="organizer">Organizer</label>'
                    . '<input type="text" id="organizer" name="organizer">'
                . '</div>'
                . '<button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>'
            . '</form>'
        . '</div>'
        . '<div data-role="footer">'
            . '<h1>New Event</h1>'
        . '</div>'
    . '</div>';
    echo $html;
}

function generateNewUserPage()
{
    $html =
    '<div data-role="page" id="newUserPage" data-theme="b" data-title="New User">'
        . '<div data-role="header" data-theme="b">'
            . '<h1>New User</h1>'
        . '</div>'
        . '<div data-role="content">'
            . '<form id="newUser" class="ui-body ui-body-b ui-corner-all" action="users.php" data-ajax="false" method="POST">'
                . '<div data-role="fieldcontain">'
                    . '<label for="fName">First</label>'
                    . '<input type="text" id="fName" name="fName">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="mName">Middle</label>'
                    . '<input type="text" id="mName" name="mName">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="lName">Last</label>'
                    . '<input type="text" id="lName" name="lName">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="email">Email</label>'
                    . '<input type="text" id="email" name="email">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="phone">Phone</label>'
                    . '<input type="text" id="phone" name="phone">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="eContact">Emergency Contact</label>'
                    . '<input type="text" id="eContact" name="eContact">'
                . '</div>'
                . '<div data-role="fieldcontain">'
                    . '<label for="ePhone">Emergency Phone</label>'
                    . '<input type="text" id="ePhone" name="ePhone">'
                . '</div>'
                . '<button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>'
            . '</form>'
        . '</div>'
        . '<div data-role="footer">'
            . '<h1>New User</h1>'
        . '</div>'
    . '</div>';
    echo $html;
}

function generateMainPage($events, $users, $msg)
{
    $html =
    '<div data-role="page" id="mainPage" data-theme="b" data-title="Geekspace Gwinnett Main">'
    . '<div data-role="header">'
        . '<h1>Geekspace Gwinnett Main</h1>'
    . '</div>';
    echo $html;
    generateLastMsg($msg);
    generateEventList($events);

    $html =
    '<div data-role="footer" class="ui-bar">'
        . '<a data-role="button" href="#newUserPage" data-transition="slideup" >New User</a>'
        . '<a data-role="button" href="#newEventPage" data-transition="slideup" >Create Event</a>'
    . '</div>';
    echo $html;

    echo '</div>'; // end of main page
}

function generateAdminPage()
{

}

function generateHTML($msg)
{
    $users = findUsers();
    $events = todaysEvents();

    echo '<html>';
    generateJQMHeader();
    echo '<body>';
    generateMainPage($events, $users, $msg);

    foreach ($events as $event)
    {
        generateUserList($event['eid'], $users);
    }

    generateNewUserPage();
    generateNewEventPage();

    echo '</body>';
    echo '</html>';
}
