<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/10/14
 * Time: 1:05 PM
 */
require_once("./function-loader.php");
function listUsers($sCriteria = NULL)
{
   global $databases;
       
    $get_users = database_query($databases['gman'], "select uid,fname,lname,email1 from members order by lname desc");

    return $get_users;
}

function getUser($userID)
{
    global $databases;
    $uid = intval($userID);
    if ($member_q = database_query($databases['gman'], "select * from members where uid=".$uid))
    {
        $user = $member_q['result'][0];
        return $user;
    }
    else
    {
        return FALSE;
    }
}

function updateUser($userID, $atts)
{
    if ( !$userID )
    {
        return false;
    }
    elseif (!is_array($atts))
    {
        return false;
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'users');

    $collection->findAndModify(
        array('uid' => (int)$userID),
        array('$set' => $atts)
    );
    return true;
}


function validateUser($user)
{
    // check for required fields
    if ( array_key_exists( 'fName', $user ) )
    {
        if ( array_key_exists( 'lName', $user ) )
        {
            if ( array_key_exists( 'email', $user ) )
            {
                return true;
            }
        }
    }
    return false;
}

function createUser($userData)
{
    if (!validateUser($userData))
    {
        return "ERROR: User data invalid.";
    }

    $users = findUsers();

    $lastUser = 0;

    foreach ($users as $user )
    {
        if ( $user['uid'] > $lastUser )
        {
            $lastUser = $user['uid'];
        }
    }

    $userData['uid'] = $lastUser + 1;

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'users');

    if($collection->insert($userData))
    {
        return "User Added";
    }
    else
    {
        return "ERROR: Failed to add user.";
    }
}

if (!$included)
{
    $users = findUsers();
    echo json_encode($users);

}
