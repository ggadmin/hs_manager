<?php

	#uber void
	
function killticket($invid){
	global $databases;
	if (!hasbatched($invid)){
	$getitems = database_query($databases['gman'],"select * from invitems where invid='".$invid."'");
	$itemarr=$getitems['result'];
	foreach ($itemarr as $item){
		$qt=$item['qty'];
		$get = database_query($databases['gman'],"select * from items where itemid='".$item['srcitemid']."'");
		if ($get['result'][0]['onhand']>=0){
			$new=$qty;
			$up = database_update($databases['gman'],"insert into inventorydata set qty=1, itemid='".$item['srcitemid']."', tmod=NOW(), memo='Voided entry: ".$invid."'");
			}
			
		}	
	$upd = database_update($databases['gman'],"update invoices set void=1, haspaid=0, tendered=0, paycode='' where invid='".$invid."'");
	$ups = database_update($databases['gman'],"update subscriptions set voiddate=NOW() where invid='".$invid."'");
	}
	
}

#make sure an invoice is un-batched
function hasbatched($invid){
	global $databases;
	$get = database_query($databases['gman'],"select * from invoices where invid=".qt($invid)." and batchid=0");
	if ($get['count']==1){ return FALSE;}
	else { return TRUE;}
}

function posbtn($page,$invid,$name){
	global $databases;
	$pos=<<<FRM
	<form action="$page" method="post">
	<input type="hidden" name="invid" value="$invid">
	<input type="Submit" name="$name" value="$name">
	</form>
FRM;
return $pos;
}


//voids a ticket (only if no payments made)
function voidticket($invid){
	global $databases;
		if (!haspaid($invid)){
			$del = database_update($databases['gman'],"update invoices set void=1 where invid=".$invid."");
			return TRUE;
			}
		else {
			return FALSE;
			}
}

function remgame($itemid,$invid){
	global $databases;
		if (!haspaid($invid)){
	$del=updateq("delete from invitems where lineid=".qt($itemid)."");
		return TRUE;
		}
		else {
			return FALSE;
			}
		
	}

function instock($itemid){
	global $databases;
	
	$res=invquery($itemid);
	if ($res==0){return FALSE;}
	else {return $res;}
}

function addline($itemid,$invid,$inc="+") {
	global $databases;
	global $userinfo;
	
		global $ticketinfo;
	if (!haspaid($invid)){
		
		#is it a free item coupon?
		$itemidstart=substr($itemid,0,4);
		$itemidend=substr($itemid,7,5);
		if ($itemidstart=="8473"){
			$userisok=0;
}
		else {
			$userisok=1;
}
		#see if its there, if so, inc. by 1
		$noupdate=0;
		$tq=database_query($databases['gman'],"select * from invitems where invid=".qt($invid)." and srcitemid='".$itemid."'  limit 1");
		$getq=database_query($databases['gman'],"select * from items where itemid='".$itemid."'");
		$onhand=invquery($itemid);
		if ($getq['result'][0]['critqty']>0){
		$critqty=$getq['result'][0]['critqty'];
		}
		else { $critqty="-1";}
		if ($tq['count']!=0){$qtr=$tq['result'][0]['qty'];}
		else {$qtr=0;}
		$qtyavail=invquery($itemid)-$qtr;
		if ($critqty==-1){
			$qtyavail=-1;
}
		if ($qtyavail<= $critqty+1 && $critqty!="-1"){
			$_SESSION['bcer']="ALERT: Critical Levels!";
}

		#if (substr($itemid,0,10)=="8472420001" && $tq['count']!=0 ){
			$sq=database_query($databases['gman'],"select * from invitems where invid='".$invid."' and srcitemid LIKE '".substr($itemid,0,10)."%'  limit 1");
				if ($sq['count']!=0){
					$qtyavail=0;
				}
		
		#}
		if (substr($itemid,0,10)=="8472420002" && $tq['count']!=0 ){
			$noupdate=1;
			$qtyavail=-1;
			
		}
		if (substr($itemid,0,10)=="8472420003" && $tq['count']!=0 ){
			$noupdate=1;
			$qtyavail=-1;
		}
		if ($qtyavail==0 || $userisok ==0){
			$_SESSION['bcer']="ALERT: Out of stock!";
			if ($inc=="-"){$updq=database_update($databases['gman'],"update invitems set qty=qty".$inc."1 where invid='".$invid."' and srcitemid='".$itemid."'");}
			}
			else {
		if ($tq['count']==0 || $noupdate=1){
			$getq=database_query($databases['gman'],"select * from items where itemid='".$itemid."'");
		
		$gi=database_query($databases['gman'],"select * from invoices where invid='".$invid."'");
		$ticketinfo=$gi['result'][0];
		
		
		$price=$getq['result'][0]['price'];
		$tax=$getq['result'][0]['taxreg'];
			
		$upc=$getq['result'][0]['itemid'];
		
		if ($getq['result'][0]['discgroup']<=$userinfo['member'] ){ 
		
			if ($getq['result'][0]['discprice'] !=0){
				
			$price = $getq['result'][0]['discprice'];
			$tax=	 $getq['result'][0]['taxdisc'];
			}
		}

                $price=$price;
                $tax=$tax;
		if ( $getq['result'][0]['cat'] == "NonTaxable" ){
			$taxable = 0;
		}
		else {
			$taxable=1;
		}
		
		$addq=updateq("insert into invitems set invid='".$invid."', tax='".$tax."' , srcitemid='".$upc."',price='".$price."',qty=1, cst='".$getq['result'][0]['cst']."', taxable=".$taxable." ");
		}
		else {
			$invqty=$tq['result'][0]['qty']+1;
			$updq=database_update($databases['gman'],"update invitems set qty=qty".$inc."1 where invid='".$invid."' and srcitemid='".$itemid."'");
			}
	}
}
}

function splitline($lineid,$invid){
	global $databases;
	$sel=database_update($databases['gman'],"select * from invitems where lineid='".$lineid."'");
	if($sel['count']==1 && $sel['result'][0]['qty']>1){
		$addq=database_update($databases['gman'],"insert into invitems set invid='".$invid."', srcitemid='".$sel['result'][0]['srcitemid']."',price='".$price."',qty=1");
		}
	
}
	
function isvoid($invid){
	global $databases;
		$q=database_query($databases['gman'],"select * from invoices where void=1 and invid='".$invid."' limit 1");
		if ($q['count']==1){
			return TRUE;
			}
			else {
				return FALSE;
				}
	
}

function userinfo($uid){
	global $databases;
	$q=database_query($databases['gman'],"select * from members where uid='".$uid."'");
	if ($q['count']==0){
		return FALSE;
		}
		else {
	$results=$q['result'][0];
	$results['phone1']=showphone($results['phone1']);
	$results['name']=$results['fname']." ".$results['lname'];
	
	return $results;
		}
}
//checks to see if an invoice has any payments applied
function haspaid($invid){
	global $databases;
		$q=database_query($databases['gman'],"select * from invoices where invid=".qt($invid)." and haspaid=1");
		if ($q['count']==0){
			return FALSE;
			}
			else {
				return TRUE;
				}
}

//figures out the total for a given invoice
function gettotal($invid){
	global $databases;
	$total=0;
	$q=database_query($databases['gman'],"select ((price-disc)*qty) as total from invitems where invid='".$invid."'");
	if ($q['count']!=0){
		while ($t = current($q['result'])){
			$total = $total+$t['total'];
			next($q['result']);
			}
		}
			
	return $total;
	}
function gettax($invid){
	global $databases;
	global $gmcfg;
	$total=0;
	$q=database_query($databases['gman'],"select *,(tax*qty)as total, (price*".$gmcfg['tax_rate'].") as taxed  from invitems where invid='".$invid."' and taxable=1");
	if ($q['count']!=0){
		while ($t = current($q['result'])){
			if ($t['tax']!="0"){
			$total = $total+$t['total'];
			}
			else {
	$total=$total+(round($t['price']*$gmcfg['tax_rate'],2)*$t['qty']);
			}
			next($q['result']);
			}
		}
		return $total;
}

//get the current balancefor a given invoice
function getbalance($invid){
	global $databases;
	$q=database_query($databases['gman'],"select amt from payments where invid='".$invid."'");
	$bal=0;
	if ($q['count']!=0){
	while ($t = current($q['result'])){
		$bal = $bal+$t['amt'];
		next($q['result']);
		}
	$total=gettotal($invid);
	$balance= $total-$bal;
	return $balance;
	}
}

function money($var,$sign="\$"){
	$money=$sign.number_format($var,2,'.',",");
	return $money;
	}
	
function discdrop($lineid){}

function gameform($invid){
	global $databases;
	global $ticketinfo;
		$gform=<<<GFT
		<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center">
		<tr>
		<td width="100%" colspan="8" class="title" align="left">Items</td>
		</tr>
		<tr>
			<td width="150" align="center"><b>Item ID</b></td>
			<td width="250" align="left"><b>Description</b></td>
			<td width="60" align="left"><b>Unit</b></td>
			<td width="65" align="left"><b>Qty</b></td>
			<td width="75" align="left"><b>Total</b></td>
			<td colspan="2" width="50">&nbsp;</td>
		</tr>

GFT;
		$q=database_query($databases['gman'],"select *,((invitems.price)*qty) as total, items.price as retail, invitems.price as extend from invitems,items where invid='".$invid."' and srcitemid=itemid order by invitems.tadd asc");
			if($q['count']!=0){
				
				while ($info = current($q['result'])){
					$rate=money($info['extend']);
					$total=money($info['total']);
					
					if ($info['onhand']>=0){
					
					$quant="(".$qtyrem.")";
					}
					else {$quant='';}
					if (substr($info['srcitemid'],0,10) == "8472420003" ){
						$selected=$info['memo'];
					
					# populate Gift Sub dropdown
					if ($info['memo'] != "" && $info['memo'] != "S" ){
						$selected=$info['memo'];
					}
						$giftsel=memberdrop("giftsel".$info['lineid'],$selected,$ticketinfo['uid']);
					
						$info['desc']=$info['desc'].$giftsel;
					}
					
					
					$gform .=<<<GFM
					<tr>
					
					<td align="left">$info[name]</td>
					<td align="left">$info[desc]</td>
					<td align="left">$rate</td>
					<td align="left">$info[qty]</td>
					<td align="left">$total</td>
					<td align="left">&nbsp;</td>
					<td align="left"><a href="pos.php?itemid=$info[itemid]&invid=$info[invid]">+</a> <a href="pos.php?itemid=$info[itemid]&invid=$info[invid]&inc=-">-</a> <a href="pos.php?lineid=$info[lineid]&invid=$info[invid]">x</a></td>
					
					</tr>
GFM;
					next($q['result']);
					}
				
				}

$gform .="</table>";
return $gform;
}


# Pull raw invoice info from database and present a associative array variious front-ends can chew on
function get_invoice_info($invoice_id)
{
	global $databases;
	//Sanitize input
	$invid = intval($invoice_id);
	$inv_query = database_query($databases['gman'],"select * from invoices where invid=".$invid);
	$results = $inv_query['result'][0];
	
	$results['line_items'] = array();
	$items = database_query($databases['gman'],"select * from invitems where invid='".$invid."'");
	$lines = array();
	$n = 1;
	
	while ($item = $items['result'])
	{
		$lines[$n]['srcitemid'] = $item['srcitemid'];
		$lines[$n]['price'] = $item['price'];
		$lines[$n]['qty'] = $item['qty'];
		$lines[$n]['linesub'] = $item['price'] * $item['qty'];
		$n++;
	}
	// Add line item array to the big array;
	$results['lines'] = $lines;
	
	//Add totals
	$results['subtotal'] = gettotal($invid);
	$results['totaltax'] = gettax($invid);
	$results['total'] = $results['subtotal'] + $results['totaltax'];
	
	return $results;
	
	
}


# parse post. handles all parsing of POST operations. As fed by form functions defined below
function pos_parse_post()
{
	global $databases;
	if (isset($_POST['Submit']))
	{
		switch ($_POST['formname'])
		{
			case "newinvoice":
				$fields = array();
				$fields['uid'] = intval($_POST['uid']);
				$fields['tcreate'] = "NOW()";
				$new_invoice = database_insert($databases['gman'], "invoices", $fields);
				$invoice_id = $new_invoice['id'];
				
				header("Location: ".my_url()."?invid=".$invoice_id);
				
				break;
			
			case "membership":
				
				echo "processing membership";
				print_r($_POST);
				break;
		}
		
		
		
	}
}

function plandrop($name,$selected="S",$not=0) {
    global $databases;
    if ($not!=0){
	$notuserid="and uid !='".$not."'";
    }
    else {
	$notuserid="";
    }
    $drop="<select name=\"".$name."\"><option value=\"S\">-- Select Plan --</option>";
	# Get member list
					$plans = database_query($databases['gman'], "select planid, planname from plans");
					
					foreach ($plans['result'] as $row){
							$sel="";
							if ($row['planid'] == $selected ){
								$sel="selected";
							}
							$drop .= '<option '.$sel.' value="'.$row['planid'].'">'.$row['planname'].'</option>';
						}
					$drop .= '</select>';
    return $drop;
    
    
}

# quickie form for creating a new invoice:
function new_invoice_form()
{
	$catarray[1] = "Membership";
	$catarray[0] = "Store items";
	
	$output = "New Ticket For:<br>";
	$output .= '<form action="" method="POST"> <input type="hidden" name="formname"  value="newinvoice" >';
	$output .= makeDrop("linetype","Ticket Type", $catarray,"S");
	$output .= memberdrop("uid");
	$output .= "<input type=\"Submit\" name=\"Submit\" value=\"Submit\"></form>";
	return $output;
}

?>