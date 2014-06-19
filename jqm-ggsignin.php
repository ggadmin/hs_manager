<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/25/14
 * Time: 9:06 PM
 */

$included = true;


require_once("function-loader.php");
require_once("events.php");


$eventinfo = eventinfo($_GET['evid']);


$page_title= $eventinfo['eventname']. "<br>Sign-In";


require_once("jqm-head.php");
require_once("users.php");



    if (isset($_GET['evid']))
    {
        $evid = (int)$_GET['evid'];
    }
    else
    {
        exit("Error: evid required for signin list!");
    }


    $html =
        '
            <div data-role="content">
                <form class="ui-body ui-body-b ui-corner-all" action="jqm-ggmenucontrol.php" data-ajax="false" method="post">
                    <input type="hidden" data-role="none" name="cmd" id="cmd" value="signin">
                    <input type="hidden" data-role="none" name="evid" id="evid" value="' . $evid . '">
                    <ul data-role="listview" data-inset="true" data-filter-reveal="true" data-theme="b" data-filter="true" data-filter-placeholder="name">';


    $users = listUsers();

    foreach ($users['result'] as $user)
    {
        $html .= '<li>'
            . '<button type="submit" name="uid" id="uid" value="' . $user['uid'] . '">'

            . $user['fname']
            . ' '
            . $user['lname']
            . ' -- '
            . $user['email1']
            . '</button>'
            . '</li>';

    }
    $html .=
                    '</ul>
                </form>
            </div>';
    


JQMrender($html);
#echo $html;