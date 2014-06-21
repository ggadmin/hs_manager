<?php 
#ini_set ('display_errors', 1);
#function library: general
date_default_timezone_set("EST5EDT");
#Free hours set here:

# Set default loginloc path:
$loginloc="index.php";
#All decimals round DOWN
#Set # hours paid per free hour
$freepts['hours']=10;
#Number of paid hours a day pass counts as:
$freepts['daypassct']=5;
#Number of paid hours a lock-in counts as:
$freepts['lockinct']=5;
#Set # free hours per free day pass:
$freepts['freedayhr']=5;

#smartlaunch compat passwd hasher:
function gethash($password) {
return base64_encode(pack('H*',sha1(strtolower($password))));
}

session_start();
header("Cache-control: private");


#error handler function 
function errorpage($errno, $errstr, $errfile, $errline)
{
    switch ($errno) {
    case E_USER_ERROR:
        $errors= "<b>My ERROR</b> [$errno] $errstr<br />\n";
        $errors.="  Fatal error on line $errline in file $errfile";
        $errors.= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $errors.= "Aborting...<br />\n";
        echo $errors;
        break;

    case E_USER_WARNING:
        $errors= "<b>WARNING</b> [$errno] $errstr<br />\n";
        return $errors;
		break;
		
    case E_USER_NOTICE:
        $errors= "<b>NOTICE</b> [$errno] $errstr<br />\n";
        echo $errors;
        break;

    default:
        $errors= "Error: [$errno] $errstr<br />\n";
       #echo $errors;
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}
$errors=set_error_handler("errorpage");

include './config.php';
include './template.php';

function dbconnect($dbinfo,$dbcname,$keepopen=1)
	{
	$dbstuff['conn'] 	=	(mysql_connect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpass'])) &&
					 (mysql_select_db($dbinfo['dbname']));

	if (!$dbstuff['conn']) dbfailure($dbcname);

	$dbstuff['dbcname']	=	$dbcname;
	$dbstuff['dbname']	=	$dbinfo['dbname'];
	$dbstuff['keepopen']	=	$keepopen;
	
	return $dbstuff;
	
	}
	#Connect to the DB

$scdb	=	dbconnect($scinfo,"scdb");


#clear details after DB Connect
unset($scinfo);

#set title if not already set by the content page:
if (!isset($pagetitle))		$pagetitle="GG Management System";


#USE: dbfailure($scdb)
function dbfailure($dbcname)
	{
	
	$db	= 	$dbcname['dbcname'];
	$errorlog.=	"Failed to connect to '".$db."' database!<br>";
	
	}

function dbclose($db,$override=0)
	{
	
	#mysql_close($db['conn']); 
	
	}

#query tables, load data into array and count results
function dbquery($table,$where='',$limit='',$orderby='',$fields='',$db='',$close=0,$debug=1)
	{
	global $scdb;
	if ($db=='')		$connect	=	$scdb['conn'];
	if ($limit!='')		$limit		=	"LIMIT ".$limit;
	if ($fields=='')	$fields		=	"*";
	if ($orderby!='')	$orderby	=	"ORDER BY ".$orderby;
	if ($where!='')		$where 		=	"WHERE ".$where;
	
	$query['db']		=	$scdb['dbname'];
	$query['query']		= 	"SELECT ".$fields." from ".$table." ".$where." ".$orderby." ".$limit."";
	#echo $query['query'];
	$get			=	mysql_query($query['query']) or die(mysql_error());
	$n=0;
	while ($arr=mysql_fetch_assoc($get))
		{
		$query['result'][$n]=$arr;
		$n++;
		}
		
	$query['count']		=	mysql_num_rows($get);
	

	mysql_free_result($get);

	if ($debug == 0 )
		{
		#unset($query['query']);
		unset($query['db']);
		}
	
	dbclose($db.$close);
	return $query;
	}

function userfree($uid){
global $freepts;
	#Get the users total number of PAID hours and day passes to date:
	$getpoints=query("select * from userpoints where uid='".$uid."'");
	$pointsavail=0;
	$pointsspent=0;
	$pointsearned=0;
	foreach ($getpoints['result'] as $data){
		
		$pointsavail=$pointsavail+$data['points'];
		
		if (substr($data['points'],0,1)=="-"){
		$pointsspent=$pointsspent-$data['points'];
		}
		else {
		$pointsearned=$pointsearned+$data['points'];
		}
}
	$unq=query("select fname,lname,username from members where uid='$uid'");
				$username=$unq['result'][0]['username'];
				$results['username']=$username;
				$results['uid']=$uid;
				$results['fname']=$unq['result'][0]['fname'];
				$results['lname']=$unq['result'][0]['lname'];
				$results['pointstotal']=$pointsavail;
	return $results;
}

function query($var,$db='',$close=0,$debug=1)
        {
        global $scdb;
        if ($db=='')            $connect        =       $scdb['conn'];
        $query['db']            =       $scdb['dbname'];
       $query['query']         =       $var;
        $get                    =       mysql_query($var) or die(mysql_error());
        $n=0;

        while ($arr=mysql_fetch_assoc($get))
              {
              $query['result'][$n]=$arr;
              $n++;
              }
       $query['count']         =       mysql_num_rows($get);
		$query['id']				=		mysql_insert_id();
       mysql_free_result($get);
       if ($debug == 0 )
             {
              unset($query['query']);
              unset($query['db']);
             }
      dbclose($db.$close);
      return $query;
      }

function wsquery($var,$db='',$close=0,$debug=1)
        {
        global $wsinfo;
        $wsdb=dbconnect($wsinfo,"wsdb");
        if ($db=='')            $connect        =       $wsdb['conn'];
        $query['db']            =       $wsdb['dbname'];
       $query['query']         =       $var;
        $get                    =       mysql_query($var) or die(mysql_error());
        $n=0;

        while ($arr=mysql_fetch_assoc($get))
              {
              $query['result'][$n]=$arr;
              $n++;
              }
       $query['count']         =       mysql_num_rows($get);
		$query['id']				=		mysql_insert_id();
       mysql_free_result($get);
       if ($debug == 0 )
             {
              unset($query['query']);
              unset($query['db']);
             }
      dbclose($db.$close);
      return $query;
      }

function updateq($var){
	global $scdb;
	if ($db=='')            $connect        =       $scdb['conn'];
	        $query['db']            =       $db['dbname'];
		       $query['query']         =       $var;
		       $get                    =       mysql_query($var) or die(mysql_error());
			$result['id']=mysql_insert_id();   
			return $result;

}


#Count Rows in a table given WHERE
function dbcount($table,$where='')
	{
	global $scdb;
	if ($where !='')
		{
		$where ='WHERE '.$where;
		}
	$get	=	mysql_query("SELECT count(*) from ".$table." ".$where."") or die(mysql_error());
	$arr	=	mysql_fetch_array($get);
			mysql_free_result($get);
	$ct	=	$arr[0];
	return $ct;

	}

#Associative Array Insert/update:
#Automatically inserts/updates to a given table based on an associative array with key names corresponding to fieldnames
#if $where is left blank or returns 0, INSERT. Else update based on where
#Will automagically run qt() on everything
function dbinsert($table,$fields,$where='')
	{
	#See if WHERE is empty
	if ($where!='')
		{
		$whereq ='WHERE '.$where;
		#Get Count on WHERE
		$count	= dbcount($table,$where);
		}
	#set COUNT = 0 if where is blank (enable INSERT mode later
	else {
		$count	= 0;
		}
	
	#deconstruct $fields array and put values where they're supposed to be, run qt() and string together
	$n	=	0;
	$c	=	count($fields)-1;
	$flist	=	'SET ';
	$fn	=	array_keys($fields);
	while ($n <= $c)
		{
		$fieldname	=	$fn[$n];
		$qtval		=	qt($fields[$fieldname]);
		$flist		.=	$fieldname . " = " . $qtval . ", ";
		$n++;
		}
	$flist  =       trim($flist);
	$flist	=	trim($flist,",");
	#echo $count;
	if ($count ==0)
		{
		#echo "insert into ".$table." ".$flist."<br>";
		$ins=mysql_query("insert into ".$table." ".$flist."") or die(mysql_error());
		return	TRUE;
		}
	if ($count !=0)
		{
		$upd=mysql_query("update ".$table." ".$flist." ".$whereq."") or die(mysql_error());
		return	TRUE;
		}
	}
	
#end DBAPP stuff

#begin basic result manipulation

###seltzhash()
function seltzhash($password, $salt)
{
    $input = empty($salt) ? $password : $salt . $password;
    return sha1($input);
}


###SLAGGAUTH() (from slagg3 && DrFoo)
function slaggauth($username="default",$pass="",$remember=1) {
        global $_SESSION;
	        if (isset($_COOKIE['autologin']) && $_COOKIE['uid'] != "") {
                $field = "id"; $arg = $_COOKIE['uid'];
                $autohash=$_COOKIE['autologin'];
                $response=$autohash;
        } else {
                $field="handle"; $arg=$username;
        }
	
	       
	session_destroy();
	session_start();
	
	#$res=dbquery("members","username ='".$username."' and uid !=94");
	#$row=$res['result'][0];
	#$dbname   = $row['username'];
        #$dbpass   = $row['pass'];
        #$uid      = $row['uid'];
	
	mysql_select_db("seltzer");
	$res=dbquery("user","username ='".$username."'");
	$row=$res['result'][0];
	$dbname   = $row['username'];
        $dbpass   = $row['hash'];
        $uid      = $row['cid'];


	if($username != "default" && $pass != "")
		{
		$pass=seltzhash($pass, $row['salt']);
		if ($pass==$dbpass)
			{
		
		$con_info = dbquery("contact", "cid=".$uid);
		 $contacts = $con_info['result'][0];
		$_SESSION['uid']	=	$uid;
		$_SESSION['uname']	=	$row['username'];
		$_SESSION['rname']	=	$contacts['firstName'];
		$_SESSION['loggedin']	=	1;
		$_SESSION['usertype']	= "member";
		
		//Get role
		$roleq = dbquery("user_role", "cid=".$uid, "", "rid desc" );
		$rolea = $roleq['result'][0];
		$_SESSION['rid']	=	$rolea['rid'];
		$_SESSION['level']	=	 3;
		
		if ($_SESSION['rid'] > 2 ){
		 $_SESSION['sid']	=	$uid;
		 $_SESSION['usertype']	= "staff";
		}
		
		 if ($remember == 1){
                                $loginhash = md5($dbname.$uid.$dbpass.$_SERVER['REMOTE_ADDR']);
                                //Foo: cookie path=/ and domain=slagg.org
                                setcookie("autologin", $loginhash, time()+2419200, "/", "geekspacegwinnett.org");
                                setcookie("uid", $uid, time()+2419200, "/", "geekspacegwinnett.org");
                                }
		// Log them in
		$act_fields = array();
		$act_fields['cid'] = intval($uid);
		$act_fields['ipaddr'] = $_SERVER['REMOTE_ADDR'];
		$act_fields['twhen'] = date("Y-m-d H:i:s",time());
		dbinsert("geekspace.activity_log", $act_fields);
		
		return true;


		



			}
		else {
		//If bad login, throw em out the nearest airlock.
		$_SESSION['sid']=0;
		$_SESSION['uid']	=	$row['uid'];
		$_SESSION['uname']="";
		$_SESSION['level']=0;
		$_SESSION['loggedin']=0;
	
		$_SESSION['loginform']="Bad Login";
		return false;
		}

		}
	else {$_SESSION['loginform']="";
	return false;
	}


}


# Function mypage: see if the user logged in is viewing their own personal info. Also returns true for staff
function mypage($uid){
    if ($_SESSION['uid'] == $uid){
	return TRUE;
    }
    else {
	if (isstaff()){
	    return TRUE;
	}
	else {
	    return FALSE;
	}
    }
    
    
}

#timedrop: Generate a time-based drop down
function timedrop($name,$value="00:00"){
    $hrdrop='<select name="'.$name.'.hour">';
    $mndrop='<select name="'.$name.'.min">';
    $timearr=explode(":",$value);
    
    
    $hour=0;
    $min=0;
    $hi=0;
    $mi=0;
    while ($hour <= 24 ){
	if ($timearr[0]==$hour){
	    $sel="selected";
	}
	else {
	    $sel="";
	}
	
	if ($hour < 10){
	    $hd="0".$hour;
	}
	else {
	    $hd=$hour;
	}
	$hrdrop.='<option value="'.$hd.'" '.$sel.'>'.$hd.'</option>';
	$hour=$hour+1;
    }
    while ($min <= 59 ){
	if ($timearr[1]==$min){
	    $sel="selected";
	}
	else {
	    $sel="";
	}
	if ($min < 10){
	    $md="0".$min;
	}
	else {
	    $md=$min;
	}
	$mndrop.='<option value="'.$md.'" '.$sel.'>'.$md.'</option>';
	$min=$min+15;
    }
    $hrdrop.="</select>";
    $mndrop.="</select>";
     return $hrdrop.$mndrop;
 
    
}

# isstaff: returns T/F if user has staff level privs or not. Confirms with database to ensure session variables haven't been flipped.
function isstaff(){
   $roleq = dbquery("seltzer.user_role", "cid=".$_SESSION['uid'], "", "rid desc" );
		$rolea = $roleq['result'][0];
	if ($rolea['rid'] > 2){
	    return TRUE;
	}
	else {
	    return FALSE;
	}
    
}

# hassubscription($uid): checks to see if a member has an active subscription. Returns TRUE/FALSE
function hassubscription($uid){
    $uid = intval($uid);
    $get=dbquery("seltzer.membership", "cid=".$uid." and end is NULL");
    if ($get['count']==0){
	return FALSE;
    }
    else {
    return TRUE;
    }	
    
}
###

# Find out when the user's subscription ended
function hadsub($uid){
    #echo "had a sub ";
     $res=dbquery("subscriptions","uid=".$uid,"","subend desc","UNIX_TIMESTAMP(subend) as tsend");
     #print_r($res);
    if ($res['count']==0){
	return FALSE;
    }
    else {
	return$res['result'][0]['tsend'];
	
    }	
}

# Multiputpose member dropdown lists.

function memberdrop($name,$selected="S",$not=0) {
    if ($not!=0){
	$notuserid="and uid !='".$not."'";
    }
    else {
	$notuserid="";
    }
    $drop="<select name=\"".$name."\"><option value=\"S\">-- Select Member --</option>";
	# Get member list
					$mems=query("select uid, fname, lname from members where isbanned='No'  ".$notuserid." ");
					#echo $mems['count'];
					foreach ($mems['result'] as $row){
							$sel="";
							if ($row['uid'] == $selected ){
								$sel="selected";
							}
							$drop .= '<option '.$sel.' value="'.$row['uid'].'">'.$row['fname'].' '.$row['lname'].'</option>';
						}
					$drop .= '</select>';
    return $drop;
    
    
}

# Get subscription info
function subscription_info($uid){
    if (!hassubscription($uid)){
	return FALSE;
    }
    else {
	$subinfo=array();
	$subinfo['uid']=$uid;
	$subinfo['memsince']='';
	$subinfo['suspendcount']=0;
	$get=dbquery("subscriptions","uid=".$uid." and voiddate is NULL","","substart asc","*, UNIX_TIMESTAMP(substart) as tsstart, UNIX_TIMESTAMP(subend) as tsend");
	$results=$get['result'];
	foreach ($results as $row){
	    if ($subinfo['memsince']==''){
		$subinfo['memsince']=$row['substart'];
	    }
	    if (!is_null($row['suspenddate'])){
		$subinfo['suspendcount']=$subinfo['suspendcount']+1;
	    }
	    $subinfo['subtype']=$row['subtype'];
	    $subinfo['tabok']=$row['tabok'];
	    $subinfo['parentuid']=$row['parentid'];
	    $subinfo['tsend']=$row['tsend'];
	    $subinfo['tsstart']=$row['tsstart'];
	}
	 
	return $subinfo; 
    }
}
###



#qtable notes:
#	$query = 	dbquery() var
#	fieldlist	full fieldlist() var
#	tblformat	tblheader() (no meat)

function qtable ($query,$fieldlist,$tblformat,$hdrformat='std')
	{
	$result	=	$query['result'];
	$count	=	$query['count'];
	echo "<pre>";
	print_r($fieldlist['headers']);
	echo "</pre>";
	$fieldct=	$fieldlist['count'];
	$fieldnames=	$fieldlist['names'];
	$headernames=	$fieldlist['headers'];
	$fn	=	0;
	$meat	=	'';
	#Someday...
	#$hdrformat='link';
	#	Table headers as links to sort by.
	#iterate through fieldnames, producing header:
	$header='<tr>';
	foreach ($headernames as $hdr)
		{
	
		$header	.=	'<td class="title">'.$hdr.'</td>';
		}
	$header='</tr>';
	echo $header;
	#iterate through results, printing rows
	$tn=0;
	foreach($result as $result)
		{
		$fn=0;
		$meat	.="<tr>";
		while ($fn <= $fieldct)
			{
			if ($result[$fieldnames[$fn]] !='')
				{
				$meat .='<td>'.$result[$fieldnames[$fn]].'</td>';
				}
			$fn++;
			}
		$meat	.="</tr>";
		$tn++;
		}
	$table= $tblformat.$header.$meat.'</table>';
	return $table;
	}

#tblheader
#generates a table with parameters
#
#options:
#	
#	width:		width in px or percent (required)
#       meat:           contents of table (if present will output full table, else print just heading)
#	border:		border (default 0)
#	spacing:	cellspacing (default 0)
#	padding:	cellpadding (default 2)
#       align:          alignment on page (default center)

function tblheader($width,$meat='',$border=1,$spacing=0,$padding=2,$align="center")
	{
	$table	=	'<table width="'.$width.'" border="'.$border.'" cellspacing="'.$spacing.'"
			cellpadding="'.$padding.'" align="'.$align.'">';

	if ($meat!='')
		{
		$table	.=	$meat."";
		}
	return $table;
		
	}


#fieldlist()
#returns arrays suitable for use in queries and tables:
# ['query']: SQL syntax formatted list
# ['names']: SQL field name
# ['headers']: Table header name for $names
#syntax for list:
# <fieldname1>:<Table Header 1>,<fieldname2>:<Table Header 2>...
#if no list is specified, all fields are listed, headers match field names
function fieldlist($table,$list='')
	{
	$num=0;
	if ($list =='')
		{
		$q=mysql_query("describe ".$table."");
		while ($arr=mysql_fetch_assoc($q))
			{
			$list 	.=	$arr['Field'].":".$arr['Field'].",";
			$list1 	 = 	rtrim($list,",");
			
			}
		}
	else 
		{
		$list1	=	$list;
		}
	$flist = explode(",",$list1);
	foreach ($flist as $flist)
		{
		$names = explode(":",$flist);
		$fieldnames[$num]	=	$names[0];
		$headernames[$num]	=	$names[1];
		$fieldlist 		.=	$names[0].",";
		$num++;
			
		}
		
	$fieldinfo['query']	=	rtrim($fieldlist,",");
	$fieldinfo['names']	=	$fieldnames;
	$fieldinfo['headers']	=	$headernames;
	$fieldinfo['count']	=	count($fieldnames);
	return $fieldinfo;
	}

			

#end result manip.
#begin table generators
###


# Mysql magic quote function (from slagg3)
function qt($value)
{
        // Stripslashes
	if (get_magic_quotes_gpc()) 
		{
		$value = stripslashes($value);
		}
	// Quote if not integer
	if (!is_numeric($value)) 
		{
		$value = "'" . mysql_real_escape_string($value) . "'";
		}
	return $value;
}

#Build a simple autofocus ID form for use with the barcode scanner
function bcform($action,$content="uid",$conname="User")
	{
	$error =(isset($_SESSION['bcerror']))?"<b>BARCODE ERROR</b>":"";
	unset($_SESSION['bcerror']);
	$form	=	 <<<FRM
				
			<form name="f" method="POST" action="$action">
			Enter $conname Name:
			<input type="hidden" name="content" value="$content">
			<input type="text" tabindex="1" name="g" size="25" maxlength="50" value="$_SESSION[testbc]">
			<input type="Submit" name="Scan" value="Search">
			<font color="red"><b>$_SESSION[bcer]</b></font><font color="green"><b>$_SESSION[bcok]</b></font>
			</form>
FRM;
	return $form;
	}

#The barcode b0rk function. Will return to page of origin and print $reason next to the form.
function bcerror($reason='Borken Barkoden')
	{
	#set error code:
	$_SESSION['bcer']=$reason;
	#go to previous page
	header("Location: ".$_SERVER['HTTP_REFERER']."");
	exit();
	}
function bcok(){
	$_SESSION['bcer']='';
	}

#Clear barcode-related session variables.
function bcinit(){
	#clear error code
	unset($_SESSION['bcer']);
	#clear form default value
	unset($_SESSION['testbc']);
	return TRUE;
	}

#Make sure a barcode's prefix is a valid datatype as defined by the database
function bcprefix($value,$d='')
	{
	$px= substr($value,0,2);
	$arr=dbquery("datatype","","","","prefix");
	
	$n=0;
	
	while ($n <= $arr['count'])
		{
			
		$p =$arr['result'][$n]['prefix'];

		if ($d=='')
			{
			$c=$p;
			}
		else { $c=$d;}

		if ($px==$c)
			{
			
			$cond=0;
			$n=$arr['count'];	
			}
		else {$cond=1;}
		$n++;
		}
	
	if ($cond==0){ return $px;}
	else {return FALSE;}

	}



function checkPH($ph)
{
	 return (
         substr($ph,0,1)=='('            &&
	 ctype_digit(substr($ph,1,3))    &&
	 substr($ph,4,2)==') '           &&
	 ctype_digit(substr($ph,6,3))    &&
	 substr($ph,6,3)!="555"          &&
	 substr($ph,9,1)=='-'            &&
	 ctype_digit(substr($ph,10,4)));
}

function fixPH(&$ph)
{
    $phlen = strlen($ph);
    // Keep only the digits
    $dg = "";
    for($i=0; $i<$phlen; $i++) {
   $ch=substr($ph,$i,1);
    if (ctype_digit($ch))
    $dg .= $ch;
        }
   $dglen = strlen($dg);
   if ($dglen==7)
   $ph = "(678) " . substr($dg,0,3) . "-" . substr($dg,3,4);
   else
  if ($dglen==10)
  $ph = "(" . substr($dg,0,3) . ") " . substr($dg,3,3) . "-" . substr($dg,6,4);
  return $ph;
	}

function showphone($ph){
	$ph = str_replace("-", "", $ph);
	$phone="(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6,4);
	return $phone;
	}

function hasgold($uid){
	$q=query("select *, unix_timestamp(tend) as exp from goldsub where uid='".$uid."' and tend >= now() limit 1");
		$exp=date("M d, Y",$q['result'][0]['exp']);
		if ($q['count']==1){
		return $exp;
		return TRUE;


		}
		else {
		return FALSE;
		}

	}

function menubutton($name,$link){
	
	$menu='<a class="topmenu" href="'.$link.'">&nbsp;'.$name.'&nbsp;</a>';
	return $menu;
	}

function sresult($array,$count="lots",$page='users.php'){
	$table = <<<TB
	<table width="500" border="1" cellspacing="0" cellpadding="2">
	<tr>
	<td width="100%" colspan="5" class="title">$count Members Found</td>
	</tr>
	<tr>
	<td align="center" width="5%"><b>UID</b></td>
	<td align="center" width="25%"><b>Handle</b></td>
	<td align="center" width="30%"><b>Name</b></td>
	<td align="center" width="30%"><b>Phone</b></td>
	<td align="center" width="10%">&nbsp;</td>
	</tr>
TB;
    
	foreach ($array as $array){
		$phone=fixPH($array['phone1']);
		$table.=<<<EOF
		<tr>
		<td><a href="$page?uid=$array[uid]">$array[uid]</a></td>
		<td><a href="$page?uid=$array[uid]">$array[username]</a></td>
		<td>$array[fname] $array[lname]</td>
		<td>$phone</td>
		<td><a href="edituser.php?uid=$array[uid]">Edit</a></td>
		</tr>
EOF;
	}

	$table .="</table>";
	return $table;
}

function siresult($array,$count="lots",$page){
	global $ticketinfo;
	
	
	$table = <<<TB
	<table width="90%" border="1" cellspacing="0" cellpadding="2">
	<tr>
	<td width="100%" colspan="5" class="title">$count Items Found</td>
	</tr>
	<tr>
	<td align="center" width="5%"><b>UPC</b></td>
	<td align="center" width="25%"><b>Name</b></td>
	<td align="center" width="40%"><b>Desc</b></td>
	<td align="center" width="20%"><b>Price</b></td>
	<td align="center" width="10%">On Hand</td>
	</tr>
TB;
	foreach ($array as $array){
		if ($page=="edititem.php"){$href="edititem.php?itemid=$array[itemid]";}
	else {
		$href="pos.php?invid=$ticketinfo[id]&itemid=$array[itemid]";
}
			$money="$".number_format($array['price'],2,'.',",");
		$table.=<<<EOF
		<tr>
		<td><a href="$href">$array[itemid]</a></td>
		<td>$array[name]</td>
		<td>$array[desc]</td>
		<td>$money</td>
		<td>$array[onhand]</td>
		</tr>
EOF;
	}

	$table .="</table>";
	return $table;
}

function userexists($test,$type="uid"){
		if ($type=="uid")
		{
			$where="where uid='".$test."'";
			}
		if ($type=="name")
		{
			$where="where username='".$test."'";
			}	
		$q=query("select uid from members ".$where."");
			if ($q['count'] !=0){
				$uid=	$q['result'][0]['uid'];
				return $uid;
								}
				else {
					
					return FALSE;
					}
	
}

#cleans non-digits from a string
function digitck($bc)
{
	$phlen=strlen($bc);
	$dg = "";
	for($i=0; $i<$phlen; $i++) {
	  $ch=substr($bc,$i,1);
	  if (ctype_digit($ch))
	$dg .= $ch;
	}
	return $dg;
}

#validate a submitted barcode
#return TRUE if:
#ID number given is a valid number after stripping '-' from human-entered codes and any whitespace.
#ID number has a valid prefix (as defined by bcprefix()
#return FALSE and return to page of entry with error code

function mknewpw($lname,$phone){
	$phone=substr($phone,6,4);
	$lname=strtolower($lname);
	$newpass=$lname.$phone;
	return $newpass;

}

function bcval($page="users.php",$anon="No",$srcinfo='')
{
$result['form']=bcform($page);
$result['content']=$_POST['content'];
bcinit();
	if (isset($_GET['uid'])){
		$bc=mysql_real_escape_string($_GET['uid']); 
		#If GET is used, run query on uid directly. If uid not found, b0rk.
		$bc=trim($bc);
		$bc=digitck($bc);
			if ($anon=="Yes"){
				$wact="";
				}
			if ($anon=="No"){
				$wact="";
				}
		$uidq=query("select cid from seltzer.user where cid='".$bc."'");
		$_SESSION['testbc']=$bc;
		if ($uidq['count']==1)
		{
		    $result['uid'] = $uidq['result'][0]['cid'];
		    return $result;}
		else {
		#	\\die
			bcinit();
			#$_SESSION['bcer']="Page error: UID not found";
			$result['uid']=0;
			return $result;

			}
		
		}
		else {
			if (isset($_POST['g']))
			{
			$bc=mysql_real_escape_string($_POST['g']);
			$_SESSION['testbc']=$bc;
			}
			else {bcinit();$result['uid']=0; return $result;}
		}
	
	if ($bc !=''){
	global $areacode;
	$bc=	trim($bc);
	$first=substr($bc,0,1);
	$bc=	str_replace('-','',$bc);
	
	#$bcpx= bcprefix($bc,$d);
	
	$slen=strlen($bc);
	#$sx=substr($bc,2,$slen);
	#$result['px']=$bcpx;
	#$result['sx']=$sx;
	$result['bc']=$bc;
	
	#search against userdb, numerics first (uid, phone, then strings (handle, lname
	#if one resu;t found, return the uid value, else return a search string of possible matches
	# search by uid
	if (is_numeric($bc) && $first !="+")
		{
		$uidq=query("select cid from seltzer/user where cid=".$bc."");
		if ($uidq['count'] ==1)
			{
			$result['uid'] = $uidq['result'][0]['cid'];
			$_SESSION['testbc']=$bc;			
			$_SESSION['bcer']='';
			return $result;
			}
		
		if ($uidq['count'] ==0)
			{
			if ($bc !=0){
			bcerror("User Invalid or Unknown");
			}
						
			
			}
		$_SESSION['testbc']=$bc;
		}
	else {
		#search by phone number
		if (is_numeric($bc) && $first =="+"){
		$phlen=strlen($bc);
	    	$dg = "";
	        for($i=0; $i<$phlen; $i++) {
		   $ch=substr($bc,$i,1);
		       if (ctype_digit($ch))
		           $dg .= $ch;
			           }
				   $bc=$dg;
			
			if (strlen($bc)==7)
				{
				$bc=$areacode.$bc;
				}
		$phoneq=query("select uid,username,fname,lname,phone1 from members where phone1='".$bc."' ");
		if ($phoneq['count']==1)
			{
			$result['uid']=$phoneq['result'][0]['uid'];
			$_SESSION['testbc']=$result['uid'];	
			return $result;
			}
		if ($phoneq['count']>=1)
			{
			$result['form'].="<br>".sresult($phoneq['result'],$phoneq['count'],$page);
			$_SESSION['testbc']=$bc;
			return $result;
			}
		if ($phoneq['count']==0)
			{
			bcerror("ID10T: Phone Number Not Found!");
			$_SESSION['testbc']=$bc;
			}
		}
		else
		{
			#search by handle
		if(!is_numeric($bc) && $first !="+")
			{
			
			$handleq=query("select uid,username,fname,lname,phone1 from members where username LIKE '".$bc."%'");
			if ($handleq['count']==1){
				{
				$result['uid'] = $handleq['result'][0]['uid'];
				$_SESSION['testbc']=$bc;
	                        $_SESSION['bcer']='';
	                        return $result;
				}
			}
			if ($handleq['count'] ==0){bcerror("ID10T: User name not found");}
			$_SESSION['testbc']=$bc;
			}
			if ($handleq['count']>=1)
                        {
                        $result['form'].="<br>".sresult($handleq['result'],$handleq['count'],$page);
                        $_SESSION['testbc']=$bc;
                        return $result;
                        }
		}
		if (!is_numeric($bc) && $first=="+"){
			$bc=trim($bc,"+");
			$nameq=query("select uid,username,fname,lname,phone1 from members where lname LIKE '%".$bc."%' ");
			if ($nameq['count']==1)
			{
				$result['uid']=$nameq['result'][0]['uid'];
				$_SESSION['testbc']=$bc;
				return $result;
			}
			if ($nameq['count']==0)
				{
				bcerror("ID10T: No names found!");
				}
			if ($nameq['count']>=1)
			{
			$result['form'].="<br>".sresult($nameq['result'],$nameq['count'],$page);
			$_SESSION['testbc']=$bc;
			return $result;
			}
		}
		
}
}
		
$_SESSION['bctest']=$bc;
return $result;
}

function itembc($page){
	if ($_GET['itemid']=='new' && $page="edititem.php"){$result['itemid']='new'; return $result;}
	$result['form']=bcform($page,"itemid","Item");
	$result['content']=$_POST['content'];
	bcinit();
	if (isset($_GET['itemid'])){
		$bc=$_GET['itemid']; 
		#If GET is used, run query on itemid directly. If uid not found, b0rk.
		$bc=trim($bc);
		$bc=digitck($bc);
			
		$uidq=query("select itemid from items where itemid='".$bc."'");
		$_SESSION['testbc']=$bc;
		if ($uidq['count']==1){$result['itemid']=$uidq['result'][0]['itemid']; return $result;}
		else {
		#	\\die
			bcinit();
			#$_SESSION['bcer']="Page error: UID not found";
			$result['itemid']=0;
			$result['s']="get";
			return $result;

			}
		
		}
		else {
			if (isset($_POST['g']) && $_POST['g'] !='' )
						{
			
							
			$bc=$_POST['g'];
			$_SESSION['testbc']=$bc;
			}
			else {bcinit();$result['itemid']=0; return $result;}
		}
		if ($bc !=''){
			$bc=	trim($bc);
			$first=substr($bc,0,1);
			$result['s']=$first;
			$bc=	str_replace('-','',$bc);
		if (is_numeric($bc)){
			$itemq=query("select * from items where itemid=".$bc."");
		if ($itemq['count'] ==1)
						{
			$result['itemid'] = $itemq['result'][0]['itemid'];
			$result['name'] =   $itemq['result'][0]['name'];
			$_SESSION['testbc']=$bc;			
			$_SESSION['bcer']='';
			$result['s']="num";
			return $result;
			}
		
		if ($itemq['count'] ==0)
					{
			if ($bc !=0){
			bcerror("ID10T: Item Invalid or Unknown");
			}
						
			
			}
		$_SESSION['testbc']=$bc;
		}
			
		if (!is_numeric($bc) && $first !="+"){
			$result['s']="name";
			$bc=trim($bc,"+");
			$nameq=query("select * from items where name LIKE '%".$bc."%' ");
			if ($nameq['count']==1)
			{
				$result['itemid']=$nameq['result'][0]['itemid'];
				$result['name'] = $nameq['result'][0]['name'];
				$_SESSION['testbc']=$bc;
				return $result;
			}
			if ($nameq['count']==0)
				{
				bcerror("ID10T: No items found!");
				}
			if ($nameq['count']>=1)
			{
			$result['form'].="<br>".siresult($nameq['result'],$nameq['count'],$page);
			$_SESSION['testbc']=$bc;
			return $result;
			}
		}
		if (!is_numeric($bc) && $first =="+"){
			$result['s']="name";
			$bc=trim($bc,"+");
			$nameq=query("select * from items where `desc` LIKE '%".$bc."%' ");
			if ($nameq['count']==1)
			{
				$result['itemid']=$nameq['result'][0]['itemid'];
				$result['name'] = $nameq['result'][0]['name'];
				$_SESSION['testbc']=$bc;
				return $result;
			}
			if ($nameq['count']==0)
				{
				bcerror("ID10T: No items found!");
				}
			if ($nameq['count']>=1)
			{
			$result['form'].="<br>".siresult($nameq['result'],$nameq['count'],$page);
			$_SESSION['testbc']=$bc;
			return $result;
			}
		}
		
		
			
			
		}
			
}


#return the tablename based on BC prefix number
function bctable($px)
	{
	$arr=dbquery("datatype","prefix='".$px."'");
	$res['table']=$arr['result'][0]['table'];
	$res['field']=$arr['result'][0]['fldname'];
	return $res;
	}

#Pull single-row query based on barcode (runs bcval and bctable)
function bcquery($bc)
	{
	$barcode=bcval($bc);
	if ($barcode)
		{
		$info	=	bctable($barcode['px']);
		$where	=	$info['field']." = ".$barcode['bc'];
		$table	=	$info['table'];
		$query	=	dbquery($table,$where);

		if ($query['count']==0)
			{
			#bcerror("ID10T: Item does not exist");
			}
		else {
			$row	=	$query['result'][0];
			return $row;
			}
		}
	}

#Pull information on an item based on its number (non-barcode entry version)
function iteminfo($id)
	{
	$px=bcprefix($id);
	if ($px)
		{
		$info   =       bctable($px);
		                $where  =       $info['field']." = ".$id;
		                $table  =       $info['table'];
		                $query  =       dbquery($table,$where);

		if ($query['count']==0)
		       {
		#bcerror("ID10T: Item does not exist");
		       }
		else {  
			$row    =       $query['result'][0];
			                    return $row;
			}
		}
	}

function loggedin(){
	if ($_SESSION['loggedin'] !=0){
	return true;
	}
	else {return false;}

}

function pv($var) {
        return ( empty($var) ? "&nbsp;" : htmlspecialchars($var) );
	}

function yesno($name, $prompt, $value){
	if ($value=="Yes"){ $yes="checked"; $no="";}
	else {$no="checked"; $yes="";}
	echo "<td align=\"right\">$prompt:</td><td><input type=\"radio\" name=\"".$name."\" ".$yes." value=\"Yes\">Yes<br><input type=\"radio\" name=\"".$name."\" ".$no." value=\"No\">No</td>\n";

	}

function field( $name, $prompt, $value, $size, $max, $fix="", $help="", $tabindex=10 ) {
global $badfields;
	if (in_array($name,$badfields)){$class="class=\"alert\"";}
		else {$class="";}
if ($prompt !=""){$prompt.=":";}
    echo "<td $class align=\"right\">$prompt</td><td><input tabindex=\"$tabindex\"";
    //echo "onmouseover=\"showhelp('";
    //echo empty($help)?$name:$help;
    //echo "',''); \"";
       
    
    if (!empty($fix))
    echo "onchange=\"$fix;\" ";
    echo "type=\"text\" name=\"$name\" ";
    if (!empty($value))
    echo 'value="'.pv($value).'" ';
    echo "size=\"$size\" maxlength=\"$max\"></td>\n";
    }

// Readonly field
//
function rofield( $name, $prompt, $value, $size, $max, $fix="", $help="", $tabindex=10 ) {
     echo "<td align=\"right\">".$prompt.":</td><td><input readonly tabindex=\"$tabindex\"";
    //echo "onmouseover=\"showhelp('";
    //echo empty($help)?$name:$help;
    //echo "',''); \"";
    
    
    if (!empty($fix))
    echo "onchange=\"$fix;\" ";
    echo "type=\"text\" name=\"$name\" ";
    if (!empty($value))
    echo 'value="'.pv($value).'" ';
    echo "size=\"$size\" maxlength=\"$max\"></td>\n";
}

// Password field
//

$statestring="AL AK AS AZ AR CA CO CT DE DC FM FL GA GU HI ID IL IN IA KS KY LA ME MH MD MA MI MN MS MO MT NE NV NH NJ NM NY NC ND MP OH OK OR PW PA PR RI SC SD TN TX UT VT VI VA WA WV WI WY AE AA AP";
$statelist=explode(" ",$statestring);
function statedrop($def="GA",$tabindex="12"){
	global $statelist;
	
$states=$statelist;
	echo "<td align=\"right\">State:</td><td><select tabindex=\"".$tabindex."\" name=\"state\">";
	$def=trim($def);
	foreach ($states as $state){
		if($def==$state){
			$sel="selected";
			}
		else {
			$sel='';
			}
		echo '<option '.$sel.' value="'.$state.'">'.$state.'</option>';
			
		}
	echo "</select></td>";
}

function stateval($val){
	global $statelist;
	foreach ($statelist as $state){
	if ($val==$state){return TRUE;}
	}
return FALSE;

}

function check($S,$okChars)
{
    $SLen=strlen($S);
    $okLen=strlen($okChars);
    for ($i=0; $i<$SLen; $i++)
       {
       $ch = substr($S,$i,1);
       for ($j=0; $j<$okLen; $j++)
      if ($ch==substr($okChars,$j,1))
               break;
      if ($j==$okLen)
      return(false);
    }
     return(true);
}


function checkDT($dt)
{
    if (strlen($dt)!=10)
        return(false);
        $y  = substr($dt,0,4);
    $m  = substr($dt,5,2);
      $d  = substr($dt,8,2);
    $s1 = substr($dt,4,1);
       $s2 = substr($dt,7,1);
    return( (check($s1,"./-")) &&
          (check($s2,"./-")) &&
     (check($y,"0123456789")) &&
     (check($m,"0123456789")) &&
    (check($d,"0123456789")) &&
    ($y>=1880) &&
   ($y<=date("Y")) &&
    ($m>=1) &&
    ($m<=12) &&
    ($d>=1) &&
    ($d<=31));
}


function fixDT(&$dt)
{
    $dtlen=strlen($dt);
    for($i=0; $i<$dtlen; $i++)
    if (check(substr($dt,$i,1),".-/"))
            break;
        if ($i>=$dtlen)
       return;
    $s1=$i; // First sep char
       for($i=$s1+1; $i<$dtlen; $i++)
       if (check(substr($dt,$i,1),".-/"))
       break;
       if ($i>=$dtlen)
       return;
    $s2=$i; // Second sep char
// Check for Y-M-D format first
    $y=intval(substr($dt,0,$s1));
    $m=intval(substr($dt,$s1+1,$s2-$s1-1));
    $d=intval(substr($dt,$s2+1));
    if ($d<=31) // otherwise must be M-D-Y
    {
   $res = sprintf("%04d-%02d-%02d",$y,$m,$d);
   if ( checkDT($res) ) {
   $dt = $res;
   return;
    }
   }
 // Okay, try M-D-Y
   $m=intval(substr($dt,0,$s1));
   $d=intval(substr($dt,$s1+1,$s2-$s1-1));
   $y=intval(substr($dt,$s2+1));
   $res = sprintf("%04d-%02d-%02d",$y,$m,$d);
   if ( checkDT($res) ) {
   $dt = $res;
   return;
   }
// Hopeless
}

function phonefield($def="",$tabindex){
	$phone=parsephone($def);

	echo "<td align=\"right\">Phone:</td><td>";
	$tab=$tabindex+1;
	echo "<input type=\"text\" tabindex=\"$tabindex\" name=\"phcode\" value=\"".$phone['areacode']."\" size=\"3\" maxlength=\"3\"><input type=\"text\" tabindex=\"$tab\" name=\"phnum\" value=\"".$phone['number']."\" size=\"7\" maxlength=\"7\"></td>";
	}

function pfield( $name, $prompt, $value, $size, $max, $fix="", $help="", $tabindex=10 ) {
	echo "<td align=\"right\">$prompt:</td><td><input tabindex=\"$tabindex\"";
	//echo "onmouseover=\"showhelp('";
	//echo empty($help)?$name:$help;
	//echo "',''); \"";
	echo "onfocus=\"showhelp('";
	echo empty($help)?$name:$help;
	echo "',''); \"";
	if (!empty($fix))
	echo "onchange=\"$fix;\" ";
	echo "type=\"password\" name=\"$name\" ";
	if (!empty($value))
	echo 'value="'.pv($value).'" ';
	echo "size=\"$size\" maxlength=\"$max\"></td>\n";
	}


// Make a submit button
//
function sbutton( $name, $label, $action="", $tabindex=10 )
{
        echo "<input class=butn tabindex=$tabindex ";
        if (!empty($name)) echo "name=\"$name\" ";
        echo "type=submit value=\"$label\" ";
        if (!empty($action)) echo "onclick=\"$action;\" ";
        echo ">\n";
}

// Make a reset button
//
function rbutton( $name, $label, $action="", $tabindex=10 )
{
	echo "<input class=butn tabindex=$tabindex ";
	if (!empty($name)) echo "name=\"$name\" ";
	echo "type=reset value=\"$label\" ";
	if (!empty($action)) echo "onclick=\"$action;\" ";
	echo ">\n";
}



function updatebb ($reg) {
		global $wsinfo;
		$opendb=mysql_connect($wsinfo['dbhost'],$wsinfo['dbuser'],$wsinfo['dbpass']);
		mysql_select_db($wsinfo['dbname']);
	// relevant phpbb_users fields: user_id, username, user_regdate, user_password, user_email
        // Make cdate the earliest non-null date for this user
        // () ## Hive: Use tcreate data from members table
	$cdate = $reg['tcreate'];
	if ($cdate=="0000-00-00")
	$cdate="now";
	if (empty($cdate) || ($cdate=="0000-00-00"))
	$cdate="now";
	$hashpass = md5($reg['pass']);
	$fields='
	username=       "'.$reg['username'].'",
	user_regdate=   "'.strtotime($cdate).'",
	user_password=  "'.$hashpass.'",
	user_email=     "'.$reg['email1'].'"';
        // First try to create a new record for this user
        //
        $res = mysql_query('INSERT into phpbb_users SET user_id="'.$reg['uid'].'", '.$fields);
        if ($res)
        return 1;
       // INSERT failed, so user record must exist - update it with the new data
       // 12-8-2005: excluding the date!
      //
     $fields='
     username=       "'.$reg['username'].'",
     user_password=  "'.$hashpass.'",
     user_email=     "'.$reg['email1'].'"';
    $res = mysql_query('UPDATE phpbb_users SET '.$fields.' WHERE user_id="'.$reg['uid'].'"');
    mysql_close($opendb);
	return $res;
	
}



//inventory balance query:
function invquery($itemid){
	//figure out how much of an item is currently on hand
	$query=query("select * from inventorydata where void=0 and itemid ='".$itemid."'");
	$qty=0;

	foreach($query['result'] as $invinfo){
		
		$qty=$invinfo['qty']+$qty;
				
	}
	return $qty;
}

//Get current item counts that are out on tabs:
function itemsoncredit($itemid){
	//get the invoices
	$itemqty=0;
	$ginv=query("select invid from invoices where void =0 and uid !=23474 and haspaid=0");
	foreach ($ginv['result'] as $invoices){
		$gitems=query("select qty from invitems where invid='".$invoices['invid']."' and srcitemid='".$itemid."'");
		foreach ($gitems['result'] as $item){
			
		$itemqty=$itemqty+$item['qty'];		
			
			
		}
	}
	return $itemqty;
}

// Enable Mail functionality
require_once "Mail.php";  

  
/* SMTP server name, port, user/passwd */  


function gg_mail($to,$subject,$message){
    $smtpinfo["host"] = "ssl://smtp.gmail.com";  
    $smtpinfo["port"] = "465";  
    $smtpinfo["auth"] = true;  
    $smtpinfo["username"] = "geekspacegwinnett@gmail.com";  
    $smtpinfo["password"] = "g33ksp4c3Mail3r!!!@@2";

   $from    = "geekspacegwinnett@gmail.com";  
   
    $sub = "GMAN: ".$subject;  
    $body    = $message;
    $footer=<<<EOF

-----
Geekspace Gwinnett Automailer
Geekspace Gwinnett, Inc.
This message was sent to ".$to."
Please do not reply to this message.
Please contact operations@geekspacegwinnett.org with questions.
EOF;
    $body=$body.$footer;    
    $headers = array ('From' => $from,'To' => $to,'Subject' => $subject);  
    $smtp = &Mail::factory('smtp', $smtpinfo );  
    $mail = $smtp->send($to, $headers, $body);  
  
    if (PEAR::isError($mail)) {  
    updateq("insert into maillog set content='".$mail->getMessage()."'");
    return FALSE;
 } else {  
  return TRUE;
 }  
    
}

if (!loggedin()) {
	if ($isindex==0){
header("Location: index.php");
exit();
}}

?>
