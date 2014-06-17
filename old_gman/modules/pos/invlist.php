<?php

$location=" &gt; <a href=\"editkeys.php\">Manage User ACLs</a>";
$page_libs = "auth pos";
include $gmcfg['source'].'/function-loader.php';
if (!$_SESSION['loggedin'] && $_SESSION['rid'] < 3 ){
	header("Location: ".$gmcfg['source']."/index.php");
}
else {


$new_form = new_invoice_form();
	echo $header;
	echo <<<TBL
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="100%" colspan="1" class="title">Create New Ticket</td></tr>
<tr>
<td width="50%" colspan="1" align="left">$new_form</td>
</td>
</tr>
</table>
TBL;

}
?>