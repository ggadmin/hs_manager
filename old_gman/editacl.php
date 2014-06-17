<?php
$location=" &gt; <a href=\"editkeys.php\">Manage User ACLs</a>";
$page_libs = "auth";
include './function-loader.php';
if (!$_SESSION['loggedin']){
	header("Location:index.php");
}
else {
    

    if (isset($_POST['idmemberacl'])){
    #print_r($_POST);
    
    # assume stop hour of 0 is midnight
    if ($_POST['timestop_hour']== "00"){
        $stophour=24;
    }
    else {
        $stophour=$_POST['timestop_hour'];
    }
    
    $starttime=$_POST['timestart_hour'].":".$_POST['timestart_min'];
    $stoptime=$stophour.":".$_POST['timestop_min'];
    
    # lockid not set. kick them back
    if ($_POST['lockid']==0 && $_POST['idmemberacl']=="new"){
        echo "no lock id set. bye!";
        header("Location: users.php?uid=".$_POST['uid']);
        exit();
    }
    
    $n=6;
    $d=0;
    $nodays=1;
    while ( $d <= $n ){
        if (isset($_POST['D'.$d])){
            $days.=$d.",";
            $nodays=0;
        }
        $d++;
    }
    if ($nodays ==1){
        $days="0,1,2,3,4,5,6";
    }
    else {
        trim($days,",");
    }
    
    
    if ($_POST['idmemberacl']=="new"){
        #insert
        $query="insert into lockacl set lockid=".qt($_POST['lockid']).", uid=".qt($_POST['uid']).", timestart=".qt($starttime).", timestop=".qt($stoptime).", days=".qt(trim($days,",")).", tadded=NOW()";
        #echo $query;
        updateq($query);
        header("Location: users.php?uid=".$_POST['uid']);
        exit();
    }
    else {
        # update
         $query="update lockacl set timestart=".qt($starttime).", timestop=".qt($stoptime).", days=".qt(trim($days,",")).", tadded=NOW() where idmemberacl=".qt($_POST['idmemberacl']);
       #echo $query;
       updateq($query);
        header("Location: users.php?uid=".$_POST['uid']);
        exit();
    }
    
    
    
    }
else {
#GET handler:

if (isset($_GET['uid']) && isset($_GET['deactivate'])){
    echo "GET MODE!";
    updateq("update lockacl set tremoved=NOW() where idmemberacl=".qt($_GET['deactivate']));
    header("Location: users.php?uid=".$_GET['uid']);
    exit();
    
    
}
echo "get vars not set";
print_r($_GET);

}
}


?>