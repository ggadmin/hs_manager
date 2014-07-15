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
 $page_libs = "auth user";
$page_title="Member Login";
 require_once("./function-loader.php");
require_once("users.php");

 // If we are not logged in, force the user to go to the login page
 

 
 if (!$_SESSION['loggedin'])
 {
 
    // Pretty this up
    #background="images/splash.png
     $html =
        '
            <div data-role="content">
                <form class="ui-body ui-body-b ui-corner-all" action="jqm-ggadmin.php" data-ajax="false" method="post">
                    <ul data-role="listview" data-inset="true" data-filter-reveal="true" data-theme="b" data-filter="true" data-filter-placeholder="name">';


    $users = listUsers();

    foreach ($users['result'] as $user)
    {
        $html .= '<li>'
            . '<button type="submit" name="uid" id="uid" value="' . $user['uid'] . '">'

            . $user['fname']
            . ' '
            . $user['lname']
            . ' -- '
            . $user['email1']
            . '</button>'
            . '</li>';

    }
    $html .=
                    '</ul>
                </form>
            </div>';
    $login = $html;

    if (isset($_POST['uid']))
    {
        
        if (!isset($_POST['pass']))
        {
            $uname = getname($_POST['uid']);
            
            // Password Prompt
             $html =
        '
            <div data-role="content">
                <form class="ui-body ui-body-b ui-corner-all" action="jqm-ggadmin.php" data-ajax="false" method="post">
                <div data-role="fieldcontain">
        <label for="uname">Username:</label>
        <input type="hidden" id="uid" name="uid" value="'.$_POST['uid'].'">'.$uname.'
        
        </div>
                <div data-role="fieldcontain">
        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" value="">
        
        </div>
         <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
                </form>
            </div>';
            JQMrender($html);
        }
        
        
        //Parse login
        else
        {
        if (user_auth($_POST['uid'], $_POST['pass']))
        {
             
            $_SESSION['adminmode']="admin on";
            
            header("Location: jqm-ggmain.php");
        }
        else {
            #echo "Login failed!";
             JQMrender("Login failed!".$login); 
            
        }
        }
        
    }
    else
    {
        
        #echo $login;
        JQMRender($login);
        

        
    }

 }
 else
 {
   header("Location: jqm-ggmain.php");
    
 }

 #echo $page_footer;
 
 ?>
