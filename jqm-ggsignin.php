<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/25/14
 * Time: 9:06 PM
 */

$included = true;
require_once("jqm-head.php");
require_once("users.php");

function generateSigninPage()
{
    if (isset($_GET['evid']))
    {
        $evid = (int)$_GET['evid'];
    }
    else
    {
        exit("Error: eid required for signin list!");
    }


    $html =
        '<div data-role="page" data-theme="b" data-title="User Chooser">
            <div data-role="header">
                <h1>Select User</h1>
            </div>
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
            </div>
        </div>';
    echo $html;
}

echo '<html>';
generateJQMHeader();
echo '<body>';
generateSigninPage();
echo '</body>';
echo '</html>';