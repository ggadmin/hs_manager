<?php
$location=" &gt; <a href=\"editkeys.php\">Manage User ACLs</a>";
$page_libs = "auth";
include './function-loader.php';
if (!$_SESSION['loggedin']){
	header("Location:index.php");
}
else {

// Get user info from databases and concatenane

//UID from GET
$edit_uid = intval($_GET['uid']);
if (mypage($edit_uid))
{
#Pull User info from DB:

$userq = database_query($databases['seltzer'], "select * from seltzer.user,seltzer.contact,seltzer.user_role where user.cid=".$edit_uid." and contact.cid=".$edit_uid." and user_role.cid=".$edit_uid."");
$userinfo=$userq['result'][0];
$userinfo[uid] = $userinfo['cid'];

// Check the members database. Generate a new record if one does not exist.
$member_q = database_query($databases['geekspace'], "select * from members where uid=".$userinfo['cid']);
if ($member_q['count'] == 0)
{
    $field = array();
    $field['uid'] = $userinfo['cid'];
    database_insert($databases['geekspace'], "members", $field);
    unset($field);
    $member_q = database_query($databases['geekspace'], "select * from members where uid=".$userinfo['cid']);
}
$userinfo = array_merge($userinfo, $member_q['result'][0]);



echo <<<TBL
<table align="center" width="100%" border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="100%" colspan="2" class="title">$userinfo[username]</td>
</tr>
<td align="center" width="100%">
$userinfo[firstName] $userinfo[lastName]<br>
$userinfo[phone]<br>
$userinfo[email]<br>
</td>
<tr><td width="100%">
$edituser&nbsp;
</td>
</tr>
<tr>
<td width="100%"><hr><br>
$stats
$acl

</td></tr>
</table>
TBL;


}
else {
    header("Location:userdb.php");
}}
?>