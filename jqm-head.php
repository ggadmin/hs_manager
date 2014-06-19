<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/24/14
 * Time: 10:18 PM
 */

// jquery mobile required header
if (isset($page_title))
{
<<<<<<< HEAD
    $page_title = $page_title;
}
else
{
    $page_title = "GMAN";
}

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
=======
    $html =
        '<head>
>>>>>>> origin/master
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="jqm/jquery.mobile-1.4.2.min.js"></script>
        <link href="jqm/jquery.mobile-1.4.2.min.css" rel="stylesheet">
<<<<<<< HEAD
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
=======
        <title>GG Main</title>
        </head>';
>>>>>>> origin/master
    echo $html;
}

?>

