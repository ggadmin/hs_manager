<?php

// User functions library. These functions re use for displaying user and profile data


//is_member (group version)
// Gets a list of all current members (those that are current on their dues). Returns a count and an array of details
function get_current_members()
{
    global $databases;
    $output = array();
    $today = date("Y-m-d")." 23:59:59";
    $member_query = database_query($databases['gman'],"select members.uid,fname,lname, UNIX_TIMESTAMP(subend) as tssubend from members, subscriptions where members.uid = subscriptions.uid and subend > CURRENT_TIMESTAMP order by lname asc");
    if ($member_query['count'] != 0)
    {
        $output = $member_query;
        
        
        return $output;
    }
    else
    {
        $output['message'] = "There are no active members! EVERYBODY PANIC";
        return $output;
    }
}

//is_member (group version)
// Gets a list of all members expiring within X days. Defaults 7. sorts by date to expire rather than name.
function get_expiring_members($days=7)
{
    global $databases;
    $days = intval($days);
    $output = array();
    $multiplier = $days * 86400;
    $expiry = date("Y-m-d", time() + $multiplier)." 23:59:59";
    $member_query = database_query($databases['gman'],"select members.uid,fname,lname, UNIX_TIMESTAMP(subend) as tssubend from members, subscriptions where members.uid = subscriptions.uid and subend > CURRENT_TIMESTAMP and subend <= '".$expiry."' order by subend asc");
    if ($member_query['count'] != 0)
    {
        $output = $member_query;
        
        
        return $output;
    }
    else
    {
        $output['message'] = "There are no members expiring in ".$days." days.";
        return $output;
    }
}

//is_member (group version)
// Gets a list of all members who have expired but haven't yet been locked out
function get_delinquent_members($days=7)
{
    global $databases;
    $days = intval($days);
    $output = array();
    $member_query = database_query($databases['gman'],"select members.uid,fname,lname, subend, unix_timestamp(subend) as tssubend, unix_timestamp(ADDDATE(subend, interval ".$days." day)) as lockout from members, subscriptions where members.uid = subscriptions.uid and CURRENT_TIMESTAMP < ADDDATE(subend, interval ".$days." day) and subend < CURRENT_TIMESTAMP order by lockout asc");
    if ($member_query['count'] != 0)
    {
        $output = $member_query;
        
        
        return $output;
    }
    else
    {
        $output['message'] = "There are no members delinquent.";
        return $output;
    }
}

// Gets a list of all members who have expired and are locked out
function get_inactive_members($days=7)
{
    global $databases;
    $days = intval($days);
    $output = array();
    $member_query = database_query($databases['gman'],"select members.uid,fname,lname, unix_timestamp(subend) as tssubend, unix_timestamp(ADDDATE(subend, interval ".$days." day)) as lockout from members, subscriptions where members.uid = subscriptions.uid and CURRENT_TIMESTAMP > ADDDATE(subend, interval ".$days." day) order by lockout asc");
    if ($member_query['count'] != 0)
    {
        $output = $member_query;
        
        
        return $output;
    }
    else
    {
        $output['message'] = "There are no members delinquent.";
        return $output;
    }
}

//is_member (individual version)
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
        $start_stamp = strtotime($startdate);
        $end_stamp = $start_stamp + $length;
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