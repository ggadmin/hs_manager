<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/10/14
 * Time: 1:05 PM
 */
$page_libs = "auth";
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

// Even quicker username getter
function getname($uid)
{
    if($array = getUser($uid))
    {
        $output = $array['fname']." ".$array['lname'];
        return $output;
    }
    else
    {
        return "";
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
    global $databases;
    if (!validateUser($userData))
    {
        return "ERROR: User data invalid.";
    }

    //Check for this email address and reject if there is a duplicate.
    $email_check = database_query($databases['gman'], "select email1 from members where email1 = ".qt($databases['gman'],$userData['email']));
    if ($email_check['count'] != 0)
    {
        return "ERROR: Email address already in use!";
    }
    else
    {
        // OK, we're clear. Let's build the fields
        $fields = array();
        $fields['fname'] = $userData['fName'];
        $fields['lname'] = $userData['lName'];
        $fields['email1'] = $userData['email'];
        $fields['phone1'] = $userData['phone1'];
        $fields['econtactname'] = $userData['eContact'];
        $fields['econtactphone'] = $userData['ePhone'];
        $fields['salt'] = user_salt();
        $fields['pass'] = user_hash($userData['password1'], $fields['salt']);
        
        //Run the insert
        if ($insert = database_insert($databases['gman'], "members", $fields))
        {
            return "Created user.<br>Username: ".$userData['email']."<br>Password is \"".$userData['password1']."\"";
        }
        else{
            return "ERROR: Could not insert user into database.";
        }
        
    }
    
    
}

if (!$included)
{
    #$users = findUsers();
    echo json_encode($users);

}
