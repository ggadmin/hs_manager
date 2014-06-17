<?php
$location=" &gt; <a href=\"editkeys.php\">Manage User ACLs</a>";
$page_libs = "auth pos form";
include './function-loader.php';


if (!$_SESSION['loggedin'] || $_SESSION['rid'] < 3 ){
	header("Location: ".$gmcfg['index']);
}
else {
    pos_parse_post();
	// If we don't have an invoice ID, show me
	if (!isset($_GET['invid']))
	{
		echo "New invoice goes here";
		$new_form = new_invoice_form();
		echo $new_form;
	}
	else
    {
		$invoice_id = intval($_GET['invid']);
		
		$invoice_info = get_invoice_info($invoice_id);
		echo "<pre>";
		print_r($invoice_info);
		$plan_drop = plandrop("plans");
		$startdate = date("Y-m-d", time());
		
		echo <<<EOF
		<form action="" method="POST">
		<input type="hidden" name="formname"  value="membership">
		$plan_drop x <input type="text" size="2" name="qty" value="1">Start date: <input type="text size="12" name="startdate" value="$startdate">
		<input type="Submit" name="Submit" value="Submit">
		</form>
		
EOF;
		
	}



        
}	
?>