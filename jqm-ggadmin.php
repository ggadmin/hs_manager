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
    #background="images/splash.png
    $login =	<<<LGN
<table cellspacing="0" cellpadding="1" border="0" width="432" height="768" ">
<tr>
	<td colspan="2" width="100%" height="550">&nbsp;</td>
</tr>
<tr>
<td width="50%">&nbsp;</td>
<td width="50%">
<center>
<font color="#ffffff">
<form name="f" method="POST" action="jqm-ggadmin.php">
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
        print_r($_SESSION);
        //Parse login
        
        if (user_auth($_POST['user'], $_POST['pass']))
        {
             #generateJQMHeader();
            $_SESSION['adminmode']="admin on";
            header("Location: jqm-ggmain.php");
        }
        else {
             generateJQMHeader();
             echo $login;
            "<b>$_SESSION[loginform]</b>";
        }
        
    }
    else
    {
        
        
        generateJQMHeader();
        echo $login;

        
    }

 }
 else
 {
   header("Location: jqm-ggmain.php");
    
 }

 #echo $page_footer;
 
 ?>
