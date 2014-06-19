<?php
/**
 * Created by PhpStorm.
 * User: Brad
 * Date: 6/19/14
 * Time: 10:18 PM
 */

// jquery mobile required header
if (isset($page_title))
{
    $page_title = $page_title;
}
else
{
    $page_title = "GMAN";
}

//Render function replaces a lot of the stuff from before

function JQMrender($body = "html here", $msg = FALSE)
{
    global $page_title;
    $title = $page_title;
    if ($msg)
    {
        $message = '<button disabled="">' . $msg . '</button>';
        #$message = "";
    }
    else
    {
        $message = "";
    }
   
    
    $html = <<<EOF
        <html>
        <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="jqm/jquery.mobile-1.4.2.min.js"></script>
        <link href="jqm/jquery.mobile-1.4.2.min.css" rel="stylesheet">
        <title>$title</title>
        </head>
        <body>
        <div data-role="page" id="mainPage" data-theme="b" data-title="$title">
        <div data-role="header">
        <h1>$title</h1>
        </div>
        $message
        $body
        </body>
        </html>
EOF;
    echo $html;
}

?>

