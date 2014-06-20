<?php

$included = true;
$page_libs = "form pos user";
$page_title="Member Payments";
require_once("function-loader.php");
require_once("jqm-head.php");
require_once("users.php");
require_once("options.php");

$out = "";

if (!$_SESSION['loggedin'] || $_SESSION['rid'] < 3 ){
	header("Location: ".$gmcfg['index']);
}

else {
#print_r($_POST);
    pos_parse_post();
	// If we don't have an invoice ID, show me
	if (!isset($_GET['invid']))
	{
		
		$new_form = new_invoice_form();
		$out .= $new_form;
	}
	else
    {
		$invoice_id = intval($_GET['invid']);
		
		$invoice_info = get_invoice_info($invoice_id);
                if (!haspaid($invoice_id))
                {
                    $out .= planform($invoice_id);
                   
                    if (count($invoice_info['lines']) == 0)
                    {
                         $plan_drop = plandrop("plans");
                         $sub_status = is_current($invoice_info['uid']);
                         
                         if (!$sub_status)
                         {
                            $startdate = date("Y-m-d", time());
                            $start_date = '<input type="text size="12" name="startdate" value="'.$startdate.'">';
                         }
                         else
                         {
                            $startdate = date("Y-m-d",$sub_status +1);
                            $start_date ='<input type="hidden" data-role="none" name="startdate" id="startdate" value="'.$startdate.'"> '.$startdate;
                         }
                         $member_name = getname($invoice_info['uid']);
                         
                         $out .= <<<EOF
                         <div data-role="content">
                         <form class="ui-body ui-body-b ui-corner-all" action="jqm-ggdues.php" method="POST">
                         <input type="hidden" name="formname"  value="membership">
                         <input type="hidden" name="invid"  value="$_GET[invid]">
                         <div data-role="header">Member: $member_name</div>
                         <div role="fieldcontain">$plan_drop</div>
                         <div role="fieldcontain">
                         <label for="qty">Qty</label>
                         <input type="text" id="qty" size="2" name="qty" value="1">
                         </div>
                          <div role="fieldcontain">
                         <label for="startdate">Start Date</label>
                         $start_date
                         </div>
                         <input type="Submit" name="Submit" value="Submit">
                         </form>
EOF;
                    }
                    
                
                }
		
	}



        
}

JQMrender($out);
#echo $out;
?>