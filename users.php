<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/10/14
 * Time: 1:05 PM
 */

function findUsers($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'users');

    $users = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $users = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $users = iterator_to_array($cursor);
    }

    return $users;
}

function getUser($userID)
{
    global $databases;
    $member_q = database_query($databases['geekspace'], "select * from members where uid=".$userID);
    $user = $member_q['result'][0];
    return $user;
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
