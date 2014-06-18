<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/25/14
 * Time: 7:33 PM
 */

$included = true;

require_once("function-loader.php");
require_once("lib/form-functions.php");
require_once("jqm-head.php");
require_once("users.php");
require_once("events.php");
require_once("options.php");

function generateNewEventPage()
{
    $html =
        '<div data-role="page" id="newEventPage" data-theme="b" data-title="New Event">
            <div data-role="header" data-theme="b">
                <h1>New Event</h1>
            </div>
        <div data-role="content">
            <form id="newEvent" class="ui-body ui-body-b ui-corner-all" action="jqm-ggmenucontrol.php" data-ajax="false" method="POST">
                <input type="hidden" name="cmd" value="newevent">
                <div data-role="fieldcontain">
                    <label for="eName">Event Name</label>
                    <input type="text" id="eName" name="eName">
                </div>

                <div data-role="fieldcontain">
                    <label for="descrip">Description</label>
                    <input type="text" id="descrip" name="descrip">
                </div>
                <div data-role="fieldcontain">
                    <label for="date">Start Date</label>
                    <input type="date" id="startdate" name="startdate" value="">
                </div>
                <div data-role="fieldcontain">
                    <label for="time">Start Time</label>
                    <input type="time" id="starttime" name="starttime" value="">
                </div>
                <div data-role="fieldcontain">
                    <label for="date">End Date</label>
                    <input type="date" id="enddate" name="enddate" value="">
                </div>
                <div data-role="fieldcontain">
                    <label for="date">End Time</label>
                    <input type="time" id="endtime" name="endtime" value="">
                </div>
                <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
            </form>
        </div>
        <div data-role="footer">
            <h1>New Event</h1>
        </div>
    </div>';
    echo $html;
}

echo '<html>';
generateJQMHeader();
echo '<body>';
generateNewEventPage();
echo '</body>';
echo '</html>';