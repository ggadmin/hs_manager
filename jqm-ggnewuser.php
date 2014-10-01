<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/25/14
 * Time: 12:08 PM
 */

$included = true;
$page_libs = "form user auth";

require_once("function-loader.php");
require_once("users.php");
require_once("options.php");

// Are we logged in? Are we the uid in question or a staffer?

if ($_SESSION['loggedin'] )
{


// Get user info from databases and concatenane

//UID from GET
$edit_uid = intval($_GET['uid']);
if (mypage($edit_uid))
{
    // valid uid
    $command = "edituser";
    $page_title = "Edit Profile";
    $user_query = database_query($databases['gman'], "select * from members where uid = ".$edit_uid);
    $userinfo = $user_query['result'][0];

}
else
{
    $command = "newuser";
}


}
else
{
    $command = "newuser";   
}
    $html = <<<EOF
        
   
        <div data-role="content">
        <form id="newUser" class="ui-body ui-body-b ui-corner-all" action="jqm-ggmenucontrol.php" data-ajax="false" method="POST">
        <input data-role="none" type="hidden" name="cmd" id="cmd" value="$command">
        <input data-role="none" type="hidden" name="uid" id="cmd" value="$edit_uid">
        <div data-role="fieldcontain">
        <label for="fName">First</label>
        <input type="text" id="fName" name="fName" value="$userinfo[fname]">
        </div>
        <div data-role="fieldcontain">
        <label for="lName">Last</label>
        <input type="text" id="lName" name="lName" value="$userinfo[lname]">
        </div>
        <div data-role="fieldcontain">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="$userinfo[email1]">
        </div>
        <div data-role="fieldcontain">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="$userinfo[phone1]">
        </div>
        <div data-role="fieldcontain">
        <label for="eContact">Emergency Contact</label>
        <input type="text" id="eContact" name="eContact" value="$userinfo[econtactname]">
        </div>
        <div data-role="fieldcontain">
        <label for="ePhone">Emergency Phone</label>
        <input type="text" id="ePhone" name="ePhone" value="$userinfo[econtactphone]">
        </div>
		 <label for="address">Address 1</label>
        <input type="text" id="address" name="address" value="$userinfo[address]">
        <label for="address2">Address 2</label>
        <input type="text" id="address2" name="address2" value="$userinfo[address2]">
        <label for="city">City</label>
        <input type="text" id="city" name="city" value="$userinfo[city]">
        <label for="state">State</label>
        <input type="text" id="state" name="state" value="$userinfo[state]">
        <label for="zip">Zip</label>
        <input type="text" id="zip" name="zip" value="$userinfo[zip]">

        <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
        </form>
        </div>
        
        </div>
EOF;

// We do this this late so the pagetitle can be set correctly
require_once("jqm-head.php");
JQMrender($html);
#echo $html;