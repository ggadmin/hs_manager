<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/24/14
 * Time: 10:18 PM
 */

// jquery mobile required header
function generateJQMHeader()
{
    $html =
        '<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="jqm/jquery.mobile-1.4.2.min.js"></script>
        <link href="jqm/jquery.mobile-1.4.2.min.css" rel="stylesheet">
        <title>GG Main</title>
        </head>';
    echo $html;
}

?>

