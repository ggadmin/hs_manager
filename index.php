<?php

require_once("jqm.php");

$signedIn = NULL;
$msg = NULL;

if (isset($_POST['cmd']))
{
    $cmd = $_POST['cmd'];
    switch ($cmd)
    {
        case "signin":
            break;

        case "newuser":
            break;

        case "newevent":
            break;

        case "admin":
            break;
    }
}

if ( isset($_GET['eid']) && isset($_GET['uid']) )
{
    $eventID = (int)$_GET['eid'];
    $userID = (int)$_GET['uid'];

    $status = signIn($eventID, $userID);

    if ($status == true)
    {
        $signedIn = "User-->" . $userID . " signed into Event-->" . $eventID;
    }
    else
    {
        $signedIn = "Event signin Failure!";
        echo $signedIn;
    }
}

generateHTML($msg);

?>
