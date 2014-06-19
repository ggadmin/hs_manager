<?php

$location=" &gt; <a href=\"editkeys.php\">Manage User ACLs</a>";
$page_libs = "auth pos";
include 'function-loader.php';
if (!$_SESSION['loggedin'] && $_SESSION['rid'] < 3 ){
	header("Location:index.php");
}
else {
$invoice_id = intval($_GET['invid']);
$location=" &gt; <a href=\"pos.php\">Point Of Sale";
if (isset($invoice_id) && !isvoid($invoice_id)){
	$location .="</a> &gt; #".$invoice_id;
	}
	else {
			if (isset($invoice_id)){
			$location .=" (New)</a> <a href=\"vinvoice.php&invid=".$invoice_id."\">[View Voided Ticket #".$invoice_id."]</a>";
			}
			else {
				$location .=" (New)</a>";
				}
		}
if (isstaff() && $_GET['kill']=="kill" && isset($invoice_id)){
	killticket($invoice_id);
	header("Location: invlist.php");
	exit();
}
		
if (haspaid($invoice_id)){
header("Location: vinvoice.php?invid=".$invoice_id."");
exit();
}

# make sales go through



if ($_POST['pay']=="Pay" && !haspaid($invoice_id) && !hasbatched($invoice_id))
{
echo "ok";
echo "<pre>";
$gi=database_query($databases['gman'],"select * from invoices where invid='".$invoice_id."'");
$ticketinfo=$gi['result'][0];
print_r($_POST);
	$invid=$invoice_id;
	$getuid=database_query($databases['gman'],"select uid,sid from invoices where invid='".$invid."'");
	$invuid=$getuid['result'][0]['uid'];
	$invsid=$getuid['result'][0]['sid'];
	#make a payment :)
	#get items:
	$items=database_query($databases['gman'],"select * from invitems where invid='".$invid."'");
	$itemarr=$items['result'];
	$rline=array();
	$n=0;
	foreach ($itemarr as $item){
	$qty=$item['qty'];
	#confirm its really in stock, if not then send it back with error
	$numoh=instock($item['srcitemid']);
	
	# Run subscription stuff here!
	
	
	if ($item['srcitemid']>="847242000100" && $item['srcitemid']<="847242000999"){
		# Key for UPC Codes:
		#100-199: Individual Membership iterations
		#200-299: Dependant Membership iterations
		#300-399: Gift Membership iterations
		# Last 2:
		# 01: Month
		# 03: Quarter
		# 06: Half-year
		# 12: Year
		# 99: Life
		$typecode=substr($item['srcitemid'],9,1);
		$lengthcode=substr($item['srcitemid'],10,2);
			switch ($typecode){
				case "2":
					$type="fam";
					$memberid=$_POST['fam'.$item['lineid']];
					$parentid=$ticketinfo['uid'];

					;;
					break;
				case "3":
					$type="std";
					$memberid=$_POST['giftsel'.$item['lineid']];
					;;
					break;
				default:
					$type="std";
					$memberid=$ticketinfo['uid'];
					;;
					break;
			}
			if ($lengthcode=="99"){
				$dateend="2063-04-05 11:15:00";
			}
			else {
				switch($lengthcode){
					case "01":
						$length=2628000*1;
						break;
					case "03":
						$length=2628000*3;
						break;
					case "06":
						$length=2628000*6;
						break;
					case "12":
						$length=2628000*12;
						break;
				}
				
				$getname=dbquery("members","uid=".$memberid."","","","fname,lname");
				$name = $getname['result'][0]['fname']." ".$getname['result'][0]['lname'];;
				if (hassubscription($memberid)){
					$subinfo=subscription_info($memberid);
					$datestart=$subinfo['tsend']+1;
					print_r($subinfo);
				}
				else {
					$datestart=time();
					
				}
				$dateend=$datestart+$length;
			}
			
			# OK, run the update:
			
			#echo "MemberID: ".$memberid." | ParentID: ".$parentid." | DateStart: ".date("m/d/Y",$datestart)." | Length: ".date("m/d/Y",$dateend)." | Type: ".$type; 
			$updateq=updateq("update invitems set memo='".$memberid."' where lineid='".$item['lineid']."'");
			#echo "\n\r";
			$createsub=updateq("insert into subscriptions set uid=".$memberid.", parentid='".$parentid."', subtype='".$type."', substart='".date("Y-m-d H:i:s",$datestart)."', subend='".date("Y-m-d H:i:s",$dateend)."', invid='".$invid."'");
			#echo "insert into subscriptions set uid=".$memberid.", parentid='".$parentid."', subtype='".$type."', substart='".date("Y-m-d H:i:s",$datestart)."', subend='".date("Y-m-d H:i:s",$dateend)."'";
	}
		$itemdata=dbquery("items","itemid=".$item['srcitemid']);
		$iteminfo=$itemdata['result'][0];
			$rline[$n]=$iteminfo['desc']." (".$name.") => $".$item['price']." x".$item['qty']." = ".money($item['price']*$item['qty']);
			$n=$n+1;
	
	####
		if ($numoh==0 && substr($item['srcitemid'],0,6)!="847242")
			{
			#echo "something's out";
			header("Location: pos.php?invid=".$invid.""); 
			exit();
			}
		else{
			if ($numoh>0){
			$new=$numoh-$qty;
			$updateq=updateq("insert into inventorydata set qty='-".$qty."', itemid='".$item['srcitemid']."', memo='Sale: ".$invid."', tmod=NOW() ");
			
			
				}
			}
		
		
			
	}
	#get balance:
	$subt=gettotal($invid);
	$subdisp=money($subt);
	$tax=gettax($invid);
	$taxdisp=money($tax);
	$gt=$subt+$tax;
	$grand=round($gt,2);
	$granddisp=money($grand);
	$tendered=$_POST['tendered'];
	if ($tendered >= $grand && $tendered >=$_POST['balance']){
	if ($grand==$_POST['balance'])
	 {
	#echo "paid";
	$dt=date("m/d/Y H:i:s",time());
	// Get User's email address
	$getmail=dbquery("members,invoices","members.uid=invoices.uid and invid=".qt($invoice_id),"","","email1,fname,lname");
	$emailaddy=$getmail['result'][0]['email1'];
	$name = $getmail['result'][0]['fname']." ".$getmail['result'][0]['lname'];;
	$rheader=<<<EOF
Geekspace Gwinnett Point-of-Sale Receipt
Date: $dt
Invoice #: $invid
Billed To: $name
------------\n
EOF;
$rcontent="";
foreach ($rline as $line){
	$rcontent.=$line."\n";
}
$rfooter=<<<EOF
------------\n
Sub-Total: $subdisp
Sales Tax: $taxdisp
Payment Method: $_POST[paycode]
Total: $granddisp
EOF;
	
	
	#gg_mail($emailaddy,"Receipt for Invoice #".$invoice_id,$rheader.$rcontent.$rfooter);
	$loc="vinvoice.php";
		$up=updateq("update invoices set paycode='".$_POST['paycode']."',  rtime=now(), tendered='".$tendered."', haspaid=1 where invid='".$invid."'");
		echo "all done!";
		header("Location: ".$loc."?invid=".$invid."");
	exit();
	     }
	}
	
}	



###Begin invoice function definitions


if (isset($_POST['Void'])){
	voidticket($_POST['invid']);
}

#scan for voidables, void:
if (!isset($invoice_id)){
$vget=database_query($databases['gman'],"select * from invoices where haspaid=0 and void=0");
$voidables=$vget['result'];
foreach ($voidables as $vinv){
$itemscan=database_query($databases['gman'],"select * from invitems where invid='".$vinv['invid']."'");
if ($itemscan['count']==0 || $vinv['uid']=='94'){
	voidticket($vinv['invid']);
	
}
}
}






include './header.php';

if(isset($_POST['lineid'])){
	$qty=$_POST['qty'];
	$ck=database_query($databases['gman'],"select srcitemid from invitems where lineid='".$_POST['lineid']."'");
	$cl=database_query($databases['gman'],"select * from items where itemid='".$ck['result'][0]['srcitemid']."'");
	$onhand=$cl['result'][0]['onhand'];
	if ($qty <=$onhand){
	$upd=updateq("update invitems set qty='".$_POST['qty']."' where lineid='".$_POST['lineid']."'");
	}
	else {$_SESSION['bcer']="ID10T: You don't have as many as you think you do!";
	}
	header("Location: pos.php?invid=".$invoice_id."");
	
}

if (isset($_GET['lineid'])&& isset($invoice_id)){
	remgame($_GET['lineid'],$invoice_id);
	header("Location: pos.php?invid=".$invoice_id."");
	exit();
	}
	if (isset($_GET['itemid'])&& isset($invoice_id)){
		if (isset($_GET['inc'])){
		$inc=$_GET['inc'];	
		}
		else {$inc="+";}
		$userinfo=userinfo($ticketinfo['uid']);
	addline($_GET['itemid'],$invoice_id,$inc);
	header("Location: pos.php?invid=".$invoice_id."");
	exit();
	}
	
if (isset($_GET['delete'])&& isset($invoice_id)){
	voidticket($invoice_id);
	header("Location= pos.php");
	#echo $invoice_id;
	exit();
	}

if (!isset($invoice_id) || isvoid($invoice_id) || $invoice_id<=0){
echo "poke";

}
else {

	$new_form = new_invoice_form();;	
	echo $header;
	echo <<<TBL
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="100%" colspan="1" class="title">Create New Ticket</td></tr>
<tr>
<td width="50%" colspan="1" align="left">$new_form</td>
</td>
</tr>
TBL;
$getopen=database_query($databases['gman'],"select *,invoices.tcreate as time,username,fname,lname from invoices,members where void =0 and  invoices.uid=members.uid and haspaid=0");
$invs=$getopen['result'];

if ($getopen['count'] > 0){
echo <<<TBHD
<tr>	
<td width="100%" colspan="1" class="title">$getopen[count] Users Unpaid</td>
</tr>
<tr>
<td width="100%">
<table width="100%" border="1" cellspacing="0" cellpadding="2">
<tr>
	<td width="50"><b>UID</b></td>
	<td width="175"><b>User Name</b></td>
	<td width="175"><b>Real Name</b></td>
	<td width="100"><b>Opened</b></td>
	<td width="100"><b># Items</b></td>
	<td width="100"><b>Balance</b></td>
	</tr>
	
TBHD;
$even="profileconteven";
foreach ($invs as $invs){
	$itemsdet=database_query($databases['gman'],"select * from invitems where invid='".$invs['invid']."'");
	$numitems=0;
		foreach($itemsdet['result'] as $itemsdet){
			$numitems=$numitems+$itemsdet['qty'];
}
	$totalun=gettotal($invs['invid']);
	$untax=gettax($invs['invid']);
	$totalsub=$totalun+$untax;
	$balform=money($totalsub);
	echo <<<TBRW
	<tr>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$invs[uid]</td>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$invs[username]</td>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$invs[fname] $invs[lname]</td>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$invs[time]</td>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$numitems</td>
	<td ondblclick="location='pos.php?invid=$invs[invid]';" class="$even">$balform</td>
	</tr>
TBRW;
$totunpaid=$totunpaid+$totalsub;
if ($even=="profilecontodd")
	{$even="profileconteven";}
	else {$even="profilecontodd";}
	}
$totform=money($totunpaid);
echo <<<NST
	</table>
	</td>
	</tr>
	<tr>
	<td width="100%" class="title">Total Unpaid: $totform</td>
	</tr>
	

NST;
}
	}


	$ct=database_query($databases['gman'],"select * from invoices where invid='".$invoice_id."'");
	if ($ct['count'] ==0){header("Location: pos.php"); exit();}
############Begin Stuff for the actual tickets
$q=database_query($databases['gman'],"select *,unix_timestamp(tcreate) as invdate from invoices where invid='".$invoice_id."'");
	$ticketinfo['date']=date("F d, Y @ h:i",$q['result'][0]['invdate']);
	$ticketinfo['id']=$q['result'][0]['invid'];
	$ticketinfo['uid']=$q['result'][0]['uid'];
	$ticketinfo['sid']=$q['result'][0]['sid'];
	
$userinfo=userinfo($ticketinfo['uid']);
$total = gettotal($ticketinfo['id']);

#$res=bcval("pos.php");
$itm=itembc("pos.php?invid=".$ticketinfo['id']);
if ($itm['itemid']!=0){
	$userinfo=userinfo($ticketinfo['uid']);
	addline($itm['itemid'],$ticketinfo['id']);
	header("Location: pos.php?invid=".$invoice_id."");

	exit();
}
$gameform=gameform($ticketinfo['id']);
echo $header;
$ttl="Point Of Sale";

	if ($ticketinfo[uid] != "94"){
	$soldto=<<<STEOF
	#$ticketinfo[uid] $userinfo[fname] $userinfo[lname] 
STEOF;
 
	}
	else {
		$soldto="Counter Sale";		
	}

$subtotal=gettotal($ticketinfo['id']);
$subdisp=money($subtotal);
$tax=gettax($ticketinfo['id']);
$taxdisp=money($tax);
$gto=$subtotal+$tax;
$gtotal=round($gto,2);
$gtdisp=money($gtotal);
$hassub=hassubscription($userinfo['uid']);
if (!$hassub){

	
	}
	if ($hassub != 0){
		$since=" since ".date("m/d/Y",hadsub($userinfo['uid']));
		$club="Active Member Until ".date("m/d/Y",$hassub);
		}
		else {
		$club="Non-Member".$since;
		}

if ($ticketinfo['uid']!="94" && $ticketinfo['uid']!="94"){
	$savebtn=posbtn("pos.php",$ticketinfo['id'],"Save");
	
}

$voidbtn=posbtn("pos.php",$ticketinfo['id'],"Void");

$sp="&nbsp;";
$buttons='<table border="0" cellspacing="0" cellpadding="4"><tr><td>'.$savebtn.'</td><td>'.$voidbtn.'</td></tr></table>';
$paydrop=<<<PD
<select name="paycode"><option selected value="Cash">Cash</option><option value="Credit Card">Credit Card</option><option value="House Charge">House Charge</option></select>
PD;

#Get number of points
$pointdata=userfree($ticketinfo['uid']);



$ticketinfo['employee']=$_SESSION['uname'];
echo <<<TBL


<table width="100%"  border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="100%" colspan="4" class="title">$ttl</td></tr>
<tr>
<td width="50%" colspan="2" align="left">
		<table border="0" cellspacing="0" cellpadding="0" align="left">
	<tr>
		<td align="right"><b>Ticket:</b></td>
		<td width="20">&nbsp;</td>
		<td >#$ticketinfo[id]</td>
	</tr>
	
	<tr>
		<td align="right"><b>Employee:</b>
		<td></td>
		<td>$ticketinfo[employee]</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td></td>
		<td>&nbsp;</td>
	</tr>
	</table>
</td>
<td width="50%" colspan="2" valign="top" align="right">
		<table border="0" cellspacing="0" cellpadding="0" valign="top" align="right">
	<tr>
		<td align="right"><b>Date Created:</b></td>
		<td width="20">&nbsp;</td>
		<td >$ticketinfo[date]</td>
	</tr>
	<tr>
		<td align="right"><b>Sold to:</b></td>
		<td></td>
		<td>$soldto<br></td>
		</tr>
		<tr>
		<td>&nbsp;</td><td>&nbsp;</td>
		<td>$club</td>
	</tr>
	
	</table>

</td>
</tr>
<tr>
<td width="100%" colspan="4" align="center"><hr>$itm[form]</td>
</tr>
<tr>
<td width="100%" colspan="4" align="center">
<form name="main" onsubmit="return verify();" action="pos.php?invid=$ticketinfo[id]" method="post">
	$gameform
	</td>
	</tr>
	
	<tr>
	<td width="50%" colspan="2" align="center">
	$sp
	</td>
	<td colspan="2">

	

	<table width="300"  border="1" cellspacing="0" cellpadding="0" align="right">
	<tr>
	<td width="50%">Subtotal:</td><td align="right">$subdisp</td></tr>
	<tr>
	<td width="50%">Sales Tax:</td><td align="right">$taxdisp</td>
	</tr>
	<tr>
	<td width="50%"><b>Grand Total:</b></td><td align="right"><b>$gtdisp</b></td></tr>
	<tr>
	<td width="50%">Pay type</td><td align="right">$paydrop</td></tr>
	<tr>
	<td>Tendered:</td><td><input type="hidden" name="balance" value="$gtotal"><input tabindex="10"onfocus="showhelp('tendered',''); "onchange="setchange();" type="text" name="tendered" size="10" maxlength="10"  value="$gtotal"></td></tr>
	<tr>
	<td>Change Due:</td><td><input tabindex="10"onfocus="showhelp('change',''); "onchange="fixDollar(this);" type="text" name="change" size="10" maxlength="10"></td></tr>
	<tr><input type="hidden" name="pay" value="Pay">
	<td>Submit:</td><td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="50%"><input type="Submit" name="Submit" value="Submit"></td></tr></table></form></td></tr>
	
	</table>
	
</td>
</tr>
<tr>
	<td width="100%" colspan="4">
	<div align="left">&nbsp;</div><br>$buttons
	</td>
	</tr>
</table>
TBL;
}


include './footer.php';


?>
