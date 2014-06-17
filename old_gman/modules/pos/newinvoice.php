<?php
if (!$_SESSION['loggedin'] || $_SESSION['rid'] < 3 ){
	header("Location: ".$gmcfg['indexpage']);
}
else {
echo "creating ticket for ".$POST['uid'];

}
?>