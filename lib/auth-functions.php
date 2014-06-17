<?php



function user_auth($username="default", $pass="", $remember=1) {
        global $_SESSION;

	global $databases;

	        if (isset($_COOKIE['autologin']) && $_COOKIE['uid'] != "") {
                $field = "id"; $arg = $_COOKIE['uid'];
                $autohash=$_COOKIE['autologin'];
                $response=$autohash;
        } else {
                $field="handle"; $arg=$username;
        }
	
	       
	session_destroy();
	session_start();
	
	//Sanitize me!
	$user = qt($databases['gman'], $username);
	
	
	$res = database_query($databases['gman'],"select * from members where username = ".$user);
	$row = $res['result'][0];
	$dbname   = $row['username'];
        $dbpass   = $row['pass'];
        $uid      = $row['uid'];

	if ( $res['count'] == 0 )
	{
		return false;
	}
	
	#print_r($res);
	if($username != "default" && $pass != "")
		{
		$pass=user_hash($pass, $row['salt']);
		if ($pass==$dbpass)
			{
		
		
		$_SESSION['uid']	=	$uid;
		$_SESSION['uname']	=	$row['username'];
		$_SESSION['rname']	=	$row['fname'];
		$_SESSION['loggedin']	=	TRUE;
		$_SESSION['rid']	=	$row['rank'];
		
		
		
		 if ($remember == 1){
                                $loginhash = md5($dbname.$uid.$dbpass.$_SERVER['REMOTE_ADDR']);
                              
                                setcookie("autologin", $loginhash, time()+2419200, "/", "geekspacegwinnett.org");
                                setcookie("uid", $uid, time()+2419200, "/", "geekspacegwinnett.org");
                                }
				
		
		// Log them in
		$act_fields = array();
		$act_fields['uid'] = intval($uid);
		$act_fields['ipaddr'] = $_SERVER['REMOTE_ADDR'];
		$act_fields['twhen'] = date("Y-m-d H:i:s",time());
		#dbinsert("geekspace.activity_log", $act_fields);
		
		return true;

			}
		else {
		//If bad login, throw em out the nearest airlock.
		unset($_SESSION['sid']);
		unset($_SESSION['uid']);
		unset($_SESSION['uname']);
		unset($_SESSION['level']);
		unset($_SESSION['loggedin']);
	
		$_SESSION['loginform']="Bad Login";
		return false;
		}

		}
	else {$_SESSION['loginform']="";
	return false;
	}
}

###seltzhash()
function user_hash ($password, $salt)
{
    $input = empty($salt) ? $password : $salt . $password;
    return sha1($input);
}

/**
 * @return a random password salt.
 */
function user_salt () {
    $chars = 'abcdefghijklmnopqrstuvwxyz01234567890!@#$%^&*()-_=+[]{}\\|`~;:"\',./<>?';
    $char_count = strlen($chars);
    $salt_length = 16;
    $salt = '';
    for ($i = 0; $i < 16; $i++) {
        $salt .= $chars{rand(0, $char_count - 1)};
    }
    return $salt;
}


#isstaff
function isstaff()
{
	if ($_SESSION['rid'] > 3 )
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
# Function mypage: see if the user logged in is viewing their own personal info. Also returns true for staff
function mypage($uid){
    if ($_SESSION['uid'] == $uid){
	return TRUE;
    }
    else {
	if (isstaff()){
	    return TRUE;
	}
	else {
	    return FALSE;
	}
    }
    
    
}

?>