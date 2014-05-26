<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/26/14
 * Time: 2:45 PM
 */
session_start();

$included = true;
require_once("jqm-head.php");

function generateMessage()
{
    $msg = $_SESSION['msg'];

    if($msg)
    {
        $html =
            '<div data-role="page" data-theme="b" data-title="Message">
                <div data-role="header">
                    <h1>Message</h1>
                </div>
                <div role="main" class="ui-content">
                    <p>' . $msg . '</p>
                    <a data-role="button" href="jqm-ggmain.php">Okay</a>
                </div>
            </div>';
        echo $html;
        $_SESSION['msg'] = NULL;
    }
}

echo '<html>';
generateJQMHeader();
echo '<body>';
generateMessage();
echo '</body>';
echo '</html>';