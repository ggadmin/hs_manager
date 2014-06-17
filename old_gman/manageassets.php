<?php
/**
 * @file   manageassets.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  manage assets database
 *
 * index
 */
 //Set this first
 $page_libs = "auth form assets";

 require_once("./function-loader.php");

 // If we are not logged in, force the user to go to the login page
if (!$_SESSION['loggedin']){
	header("Location:index.php");
}

else
 {
	
	if ($_POST['Submit'] == "Submit")
	{
		echo "form!";
		print_r($_POST);
		exit();
	}
	
	
    $page_header;
    // now that we're logged in, do useful things.
    echo "Logged in as: ".$_SESSION['uname'].". (<a href=\"logout.php\">Logout</a>)<br>";
    echo "Asset management page!";
    
    
    $mem_drop = memberdrop();
    echo <<<EOF
    
    <form name="new" action="manageassets.php" method="POST">
    Name<br><input type="text" name="name" size="40"><br>
    Category:<br>
    <br>
    Owner (If loan):<br>
    $mem_drop
    <br>
    Description:<br>
    <textarea name="description" rows="3" cols="40"></textarea><br>
    Upload Image<br><input type="file" name="image" size="8388608"><br>
    <input type="submit" name="Submit" value="Submit">
    </form>
EOF;

	echo "hi";
	}

 echo $page_footer;
 
 ?>