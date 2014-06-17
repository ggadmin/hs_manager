<?php
/**
 * @file   seltzersync.php
 * @Author Brad Newton ()
 * @date   April 2014
 * @brief  seltzer user import script
 *
 * index
 */
 //Set this first
 $page_libs = "auth";

 require_once("./function-loader.php");
 echo "<pre>";
 
 # sync seltzer stuff over
 $res = database_query($databases['gman'], "SELECT * FROM seltzer.user,seltzer.user_role,seltzer.contact where user.cid = contact.cid and user_role.cid = user.cid");
    foreach ($res['result'] as $line)
    {
        print_r($line);
        $fields = array();
        $fields['username'] = $line['username'];
        $fields['pass'] = $line['hash'];
        $fields['salt'] = $line['salt'];
        $fields['fname'] = $line['firstName'];
        $fields['lname'] = $line['lastName'];
        $fields['email1'] = $line['email']];
        $fields['phone1'] = $line['phone'];
        $fields['econtactname'] = $line['emergencyName'];
        $fields['econtactphone'] = $line['emergencyPhone'];
        $fields['rank'] = 2;
        
    }