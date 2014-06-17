<?php
/**
 * @file   index.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  main index page
 *
 * index
 */
 //Set this first
 $page_libs = "auth";

 require_once("./function-loader.php");

 // If we are not logged in, force the user to go to the login page
 
 
 
 if (!$_SESSION['loggedin'])
 {
 
    // Pretty this up
    $login =	<<<LGN
<table cellspacing="0" cellpadding="1" border="0" width="432" height="768" background="images/splash.png">
<tr>
	<td colspan="2" width="100%" height="550">&nbsp;</td>
</tr>
<tr>
<td width="50%">&nbsp;</td>
<td width="50%">
<center>
<font color="#ffffff">
<form name="f" method="POST" action="index.php">
Username:<br><input type="text" name="user" size="15"><br>Password:<br><input type="password" size="15" name="pass"><br><input type="Submit" value="Submit" 
name="Login">

</form>
</font>
</center>
</td>
</tr>
</table>
LGN;

    if (isset($_POST['Login']))
    {
        //Parse login
        
        if (user_auth($_POST['user'], $_POST['pass']))
        {
            header("Location: index.php");
        }
        else {
            echo $login. "<b>$_SESSION[loginform]</b>";
        }
        
    }
    else
    {
        echo $login;

        
    }

 }
 else
 {
    $page_header;
    // now that we're logged in, do useful things.
    echo "Logged in as: ".$_SESSION['uname'].". (<a href=\"logout.php\">Logout</a>)<br>";
    print_r($_SESSION);
    
    //Security clearence level 6:
    if ($_SESSION['rid'] >= 3 )
    {
        echo '<a href="pointsale.php">Point of Sale</a>';
    }
    
 }

 echo $page_footer;
 
 ?>
