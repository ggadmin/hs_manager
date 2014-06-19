<?php

// User functions library. These functions re use for displaying user and profile data



//is_member
//Given uid, returns true/false. If true, returns expiry date as unix stamp;
function is_current($uid)
{
     $uid = intval($uid);
    global $databases;
    $output = array();
    $today = date("Y-m-d")." 23:59:59";
    $member_query = database_query($databases['gman'],"select UNIX_TIMESTAMP(subend) as tssubend from subscriptions where uid = '".$uid."' and subend > CURRENT_TIMESTAMP order by subend desc");
    if ($member_query['count'] != 0)
    {
        return $member_query['result'][0]['tssubend'];
    }
    else
    {
        return false;
    }
}

//Are they a newly-expired member (within a week). returns the day their membership expires or expired if they are in arrears.
//is_member
function is_member($uid)
{
    $uid = intval($uid);
    global $databases;
    if ($current = is_current($uid))
    {
        return $current;
    }
    else
    {
        $output = array();
    $week = date("Y-m-d",time()+604800)." 23:59:59";
    $member_query = database_query($databases['gman'],"select UNIX_TIMESTAMP(subend) as tssubend from subscriptions where uid = '".$uid."' and subend < CURRENT_TIMESTAMP order by subend desc");
    if ($member_query['count'] != 0)
    {
        return $member_query['result'][0]['subend'];
    }
    else
    {
        return false;
    } 
    }
}

//were they ever a member? Get their last expiry date, else return false
function wasmember($uid)
{
    $uid = intval($uid);
    global $databases;
    $output = array();
    $today = date("Y-m-d")." 23:59:59";
    $member_query = database_query($databases['gman'],"select UNIX_TIMETAMP(subend) from subscriptions where uid = '".$uid."' order by subend asc");
    if ($member_query['count'] != 0)
    {
        return $member_query['result'][0]['subend'];
    }
    else
    {
        return false;
    }
}

//Add a subscription for a user. Given uid and planid, do the math.
function addmembership($uid, $planid, $qty, $startdate, $invid)
{
    global $databases;
    //Sanitize the inputs
    $qty = intval($qty);
    $uid = intval($uid);
    $planid = intval($planid);
    $startdate = date("Y-m-d H:i:s", strtotime($startdate));
    
    // Get the plan details
    $plan_query = database_query($databases['gman'], "select * from plans where planid = ".$planid);
    $details = $plan_query['result'][0];

    // Enter an invoice and line item for them
    
    $fields = array();
    // Compute plan length in days from today.
    $multiplier = 86400;
    $length = $details['planlength']*$multiplier*$qty;
    
    $fields['uid'] = $uid;
    $fields['subname'] = "Plan: ".$planid;
    $fields['invid'] = intval($invid);
    $fields['votable'] = $details['votable'];
    $sub_status = is_current($uid);
    if (!$sub_status)
    {
        $start_stamp = time();
        $end_stamp = time() + $length;
    }
    else {
        $start_stamp = $sub_status+1;
        $end_stamp = $start_stamp + $length;
    }
    
    
    
    $fields['substart'] = date ("Y-m-d", $start_stamp)." 00:00:00";
    $fields['subend'] = date ("Y-m-d", $end_stamp)." 23:59:59";
    
    if ($sub_insert = database_insert($databases['gman'], "subscriptions", $fields))
    {
        return $sub_insert;
    }
    else{
        return false;
    }
    
}

?>