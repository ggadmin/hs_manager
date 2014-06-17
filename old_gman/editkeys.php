<?php

$location=" &gt; <a href=\"editkeys.php\">Manage Access Keys</a>";
$page_libs = "auth form";
include './function-loader.php';
if (!$_SESSION['loggedin']){
	header("Location:index.php");
}
else {
	if (!isstaff()){header("Location:index.php");}
else {


if (isset($_POST['Submit'])){
	#Process the form here	
	#print_r($_POST);
	if (isset($_POST['edititem'])){
		$uid=intval($_POST['uid']);
		$keycardsid=intval($_POST['edititem']);
		$up = database_update($databases['geekspace'], "update keycards set uid=".$uid." where keycardsid=".$keycardsid);
		#echo $up['query']." : ".$up['count'];
		header("Location: editkeys.php");
	}
	if (isset($_POST['newitem'])){
		$fields = array();
		$fields['uid'] = intval($_POST['uid']);
		$fields['rfidnumber'] = "'".$_POST['rfidnumber']."'";
		
		#print_r($fields);
		$insert = database_insert($databases['geekspace'], "keycards", $fields);
		#echo $insert['query'];
		header("Location: editkeys.php");
	}

}
# No form submitted... show stuff
else {
	
	# Get actions for summoning kill and forms, yadda:
	if ( isset($_GET['kill'] )){
		$val=intval($_GET['kill']);
		$up = database_update($databases['geekspace'], "update keycards set tremoved=NOW() where keycardsid=".$val);
		
		header("Location: editkeys.php");
			
	}
		if ( isset($_GET['reactivate'] )){
		$val=intval($_GET['reactivate']);
		database_update($databases['geekspace'], "update keycards set tremoved=NULL where keycardsid=".$val);
		header("Location: editkeys.php");
			
	}
	
		if ( isset($_GET['purge']) && $_GET['purge'] == "yes" ){
		
		database_update($databases['geekspace'], "delete from keycards where tremoved is not null");
		header("Location: editkeys.php");
			
	}
	
	
	
	
	# We need a member drop down

	
	
	echo $header;
	# Create the basic table
	$tableheader=<<<EOF
	<table width="100%"  border="0" cellspacing="0" cellpadding="1">
	<tr>
	<td width="100%" colspan="5" class="title">Active RFID Access Keys</td>
	</tr>
	<tr>
	<td width="25%" align="left"><b>Key ID</b></td>
	<td width="25%" align="left"><b>Member</b></td>
	<td width="25%" align="left"><b>Status</b></td>
	<td width="25%" align="left">&nbsp;</td>
	</tr>
EOF;
$mode="odd";
$content="";
	#Get listed keys
	$list= database_query($databases['seltzer'], "select * from geekspace.keycards,seltzer.contact where tremoved is NULL and keycards.uid=seltzer.contact.cid order by lastName asc");
	$keylist=$list['result'];
	
	foreach ($keylist as $row){
		if (is_null($row[tremoved])){
			$status="Active";
		}
		else {
			$status="<b>Removed ".$row[tremoved]."</b>";
		}
	
	if ($_GET['edit']==$row['keycardsid']){
		$drop=memberdrop("uid",$row['uid']);
		$member="<form name=\"userstat\" action=\"editkeys.php\" method=\"POST\">".$drop;
		
		# we need a drop down with the username
		
		$action=<<<EOF
	
	<input type="hidden" name="edititem" value="$row[keycardsid]">
	<input type="Submit" name="Submit" value="Submit">
	</form>
EOF;
	}
	else{
		$member=$row['firstName']." ".$row['lastName'];
		$action='<a href="editkeys.php?edit='.$row['keycardsid'].'">Reassign</a> | <a href="editkeys.php?kill='.$row['keycardsid'].'">Deactivate</a>';
	}
		
	$content.=<<<EOF
	<tr>

	
	<td class="profilecont$mode">$row[rfidnumber]</td>
	<td class="profilecont$mode">$member</td>
	<td class="profilecont$mode">$status</td>
	<td class="profilecont$mode">$action</td>
	</form>
	</tr>
EOF;
	if ($mode=="odd"){$mode="even";} else {$mode="odd";}
	}
	
	# Show "add new" form:
	$drop=memberdrop("uid");
	$content.=<<<EOF
	<tr>
	<form name="addnew" action="editkeys.php" method="POST">
	<input type="hidden" name="newitem" value="new">
	<td class="profilecont$mode"><input type="text" name="rfidnumber" length="8" maxlength=10"></td>
	<td class="profilecont$mode">$drop</td>
	<td class="profilecont$mode"><b>NEW</b></td>
	<td class="profilecont$mode"><input type="Submit" name="Submit" value="Submit"></td>
	</form>
	</tr>
EOF;
	
	
	
	
	echo $tableheader.$content."<tr><td colspan=\"5\" width=\"100%\" class=\"title\">&nbsp;</td></tr></table>";
	
	###
	# Inactive Key table
	$tableheader=<<<EOF
	<table width="100%"  border="0" cellspacing="0" cellpadding="2">
	<tr>
	<td width="100%" colspan="5" class="title">Inactive Keys (<a href="editkeys.php?purge=yes"> Purge</a>)</td>
	</tr>
	<tr>
	<td width="20%" align="left"><b>Key Type</b></td>
	<td width="20%" align="left"><b>Key ID</b></td>
	<td width="20%" align="left"><b>Member</b></td>
	<td width="20%" align="left"><b>Date Removed</b></td>
	<td width="20%" align="left">&nbsp;</td>
	</tr>
EOF;
$mode="odd";
$content="";
	#Get listed keys
	$list= database_query($databases['geekspace'], "select * from keycards,seltzer.contact where tremoved is NOT NULL and keycards.uid=seltzer.contact.cid order by lastName asc");
	$keylist=$list['result'];
	foreach ($keylist as $row){
		$member=$row['firstName']." ".$row['lastName'];
	$content.=<<<EOF
	<tr>

	<td class="profilecont$mode">$row[keytype]</td>
	<td class="profilecont$mode">$row[rfidnumber]</td>
	<td class="profilecont$mode">$member</td>
	<td class="profilecont$mode">$row[tremoved]</td>
	<td class="profilecont$mode"><a href="editkeys.php?reactivate=$row[keycardsid]">Reactivate</a></td>
	</form>
	</tr>
EOF;
	if ($mode=="odd"){$mode="even";} else {$mode="odd";}
	}
	
	
	
	echo "<br>".$tableheader.$content."<tr><td colspan=\"5\" width=\"100%\" class=\"title\">&nbsp;</td></tr></table>";
		
	include './footer.php';	
}


}}
?>

