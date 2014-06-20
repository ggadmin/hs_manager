<?php

// member statistics page 

$included = true;
$page_libs = "form pos user";
$page_title="Member Statistics";
require_once("function-loader.php");
require_once("jqm-head.php");
require_once("users.php");
require_once("options.php");

$out = "";

// Kick them if they are not a high enogh clearence
if (!$_SESSION['loggedin'] || $_SESSION['rid'] < 3 ){
	header("Location: ".$gmcfg['index']);
}
else {

$activeuids = array();

// Get a list of active members
$active_members = get_current_members();

 $actives = <<<EOF
        <div data-role="collapsible" data-theme="b" data-content-theme="b">
        <h3>Active Members ($active_members[count])</h3>
            <ul data-role="listview" data-filter="false">
EOF;
    if ($active_members['count'] != 0 )
    {
        foreach ($active_members['result'] as $member)
        {
            $activeuids[$member['uid']] = $member['uid'];
            $actives .= '<li><a data-transition="slide" href="jqm-userprofile.php?uid='.$member['uid'].'">'.$member['fname'].' '.$member['lname'].'</a></li>';    
        }
         $actives .= '</ul></div>';
    }
    
        
   

// Get a list of expiring members
$expiring_members = get_expiring_members();
if ($expiring_members['count'] != 0 )
    {
 $warning = <<<EOF
        <div data-role="collapsible" data-theme="b" data-content-theme="b">
        <h3>Expiring this week ($expiring_members[count])</h3>
            <ul data-role="listview" data-filter="false">
EOF;
    
        foreach ($expiring_members['result'] as $member)
        {
            $activeuids[$member['uid']] = $member['uid'];
            $warning .= '<li><a data-transition="slide" href="jqm-userprofile.php?uid='.$member['uid'].'">'.$member['fname'].' '.$member['lname'].'</a></li>';    
        }
        $warning .= '</ul></div>';
    }     
        
    

    // Get a list of expired-ish members
$expired_members = get_delinquent_members();
if ($expired_members['count'] != 0 )
    {
 $expired = <<<EOF
        <div data-role="collapsible" data-theme="b" data-content-theme="b">
        <h3>Delinquent Members ($expired_members[count])</h3>
            <ul data-role="listview" data-filter="false">
EOF;
    
        foreach ($expired_members['result'] as $member)
        {
            $activeuids[$member['uid']] = $member['uid'];
            $exdate = date ("m/d/y", $member['tssubend']);
            $expired .= '<li><a data-transition="slide" href="jqm-userprofile.php?uid='.$member['uid'].'">'.$member['fname'].' '.$member['lname'].' ('.$exdate.')</a></li>';    
        }
        $expired .= '</ul></div>';
    }     
        
    

// Get a list of inactive (fully expired) members
$inactive_members = get_inactive_members();
if ($inactive_members['count'] != 0 )
    {
 $inactive = <<<EOF
        <div data-role="collapsible" data-theme="b" data-content-theme="b">
        <h3>Inactive Members ($expired_members[count])</h3>
            <ul data-role="listview" data-filter="false">
EOF;
    
        foreach ($inactive_members['result'] as $member)
        {
            if (!in_array($member['uid'], $activeuids))
            {
                $exdate = date ("m/d/y", $member['tssubend']);
                $inactive .= '<li><a data-transition="slide" href="jqm-userprofile.php?uid='.$member['uid'].'">'.$member['fname'].' '.$member['lname'].' ('.$exdate.')</a></li>';
            }
        }
    $inactive .= '</ul></div>';
    }     
        
    
    $out = $actives.$warning.$expired.$inactive;

#echo $out;
JQMrender($out);
}
?>
