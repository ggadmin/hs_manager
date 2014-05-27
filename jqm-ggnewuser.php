<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/25/14
 * Time: 12:08 PM
 */

$included = true;
require_once("jqm-head.php");
require_once("users.php");

function generateNewUserPage()
{
    $html =
        '<div data-role="page" id="newUserPage" data-theme="b" data-title="New User">'
        . '<div data-role="header" data-theme="b">'
        . '<h1>New User</h1>'
        . '</div>'
        . '<div data-role="content">'
        . '<form id="newUser" class="ui-body ui-body-b ui-corner-all" action="jqm-ggmenucontrol.php" data-ajax="false" method="POST">'
        . '<input data-role="none" type="hidden" name="cmd" id="cmd" value="newuser">'
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

echo '<html>';
generateJQMHeader();
echo '<body>';
generateNewUserPage();
echo '</body>';
echo '</html>';