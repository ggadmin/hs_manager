<?php
# mail sender cron job
# It only has obe major function:
$message = "This is an automated report from GMAN.\r\n";

$page_libs = "user";
require_once("function-loader.php");

### This is mostly a shell script thing
// Enable Mail functionality
require_once "Mail.php";  

  
/* SMTP server name, port, user/passwd */  


function gg_mail($to,$subject,$message){
    $smtpinfo["host"] = "ssl://smtp.gmail.com";  
    $smtpinfo["port"] = "465";  
    $smtpinfo["auth"] = true;  
    $smtpinfo["username"] = "geekspacegwinnett@gmail.com";  
    $smtpinfo["password"] = "g33ksp4c3Mail3r!!!@@2";

   $from    = "geekspacegwinnett@gmail.com";  
   
    $sub = "GMAN: ".$subject;  
    $body    = $message;
    $footer=<<<EOF

-----
Geekspace Gwinnett Automailer
Geekspace Gwinnett, Inc.
This message was sent to ".$to."
Please do not reply to this message.

EOF;
    $body=$body.$footer;    
    $headers = array ('From' => $from,'To' => $to,'Subject' => $subject);  
    $smtp = &Mail::factory('smtp', $smtpinfo );  
    $mail = $smtp->send($to, $headers, $body);  
  
    if (PEAR::isError($mail)) {  
    database_update($databases['gman'],"insert into maillog set content='".$mail->getMessage()."'");
    return FALSE;
 } else {  
  return TRUE;
 }  
    
}



$expiring_members = get_expiring_members(7);
$expired_members = get_delinquent_members(30);





if (isset($expiring_members['message']))
{
    $message .= $expiring_members['message']."\r\n\n";
}
else {
    $message .= "The following ".$expiring_members['count']." members are expiring within the next week.\r\n They will be locked out if they are delinquent for 7 days.\r\n";
    foreach ($expiring_members['result'] as $members)
    {
        
    }
    
}

$message .= "-----\r\n";

if (isset($expired_members['message']))
{
    $message .= $expired_members['message']."\r\n\n";
}
else {

$message .= "The following members are behind on their dues by up to 30 days.";
$current_date = time();

    foreach ($expired_members['result'] as $expired)
    {
        if ($expired['lockout'] < $current_date)
        {
            $lockedout = "(Locked out Since ".date("m/d/Y",$expired['lockout']).")";
        }
        else
        {
            $lockedout = "()";
        }
        
        $message .= $expired['fname']." ".$expired['lname']." ".$lockedout;
        
        
    }


}



# Pull the "RANK 4" and above user emails
$emails = database_query($databases['gman'],"select email1 from members where rank >= 4");

$send_to = array();

foreach ($emails['result'] as $staff)
{
    $send_to[] = $staff['email1'];
}

#print_r($send_to);
$subject = "GMAN Weekly Member Report";

foreach ($send_to as $to)
{
    gg_mail($to,$subject,$message);
}


?>