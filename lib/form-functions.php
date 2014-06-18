<?php

# Multiputpose member dropdown lists.

function memberdrop($name,$selected="S",$not=0) {
    global $databases;
    if ($not!=0){
	$notuserid="and uid !='".$not."'";
    }
    else {
	$notuserid="";
    }
    $drop="<select name=\"".$name."\"><option value=\"S\">-- Select Member --</option>";
	# Get member list
					$mems = database_query($databases['gman'], "select uid, fname, lname from members ".$notuserid." ");
					#echo $mems['count'];
					foreach ($mems['result'] as $row){
							$sel="";
							if ($row['uid'] == $selected ){
								$sel="selected";
							}
							$drop .= '<option '.$sel.' value="'.$row['uid'].'">'.$row['fname'].' '.$row['lname'].'</option>';
						}
					$drop .= '</select>';
    return $drop;
    
    
}

#timedrop: Generate a time-based drop down
function timedrop($name,$value="00:00"){
    $hrdrop='<select name="'.$name.'.hour">';
    $mndrop='<select name="'.$name.'.min">';
    $timearr=explode(":",$value);
    
    
    $hour=0;
    $min=0;
    $hi=0;
    $mi=0;
    while ($hour <= 24 ){
	if ($timearr[0]==$hour){
	    $sel="selected";
	}
	else {
	    $sel="";
	}
	
	if ($hour < 10){
	    $hd="0".$hour;
	}
	else {
	    $hd=$hour;
	}
	$hrdrop.='<option value="'.$hd.'" '.$sel.'>'.$hd.'</option>';
	$hour=$hour+1;
    }
    while ($min <= 59 ){
	if ($timearr[1]==$min){
	    $sel="selected";
	}
	else {
	    $sel="";
	}
	if ($min < 10){
	    $md="0".$min;
	}
	else {
	    $md=$min;
	}
	$mndrop.='<option value="'.$md.'" '.$sel.'>'.$md.'</option>';
	$min=$min+15;
    }
    $hrdrop.="</select>";
    $mndrop.="</select>";
     return $hrdrop.$mndrop;
 
    
}


#category dropdown
# semi-arbitrary version of the member dropdown
# Needs associative array with database value -> display pairs
function catDrop($selected="S")
{
    global $databases;
    $selected = intval($selected);
    $cat_query = database_query($databases['gman'], "select * from event_categories order by catname desc");
    $cats = $cat_query['result'];
     
     $drop="<select name=\"category\"><option value=\"S\" selected>-- Select ".$display_name." --</option>";

    
    foreach ($cats as $key => $row){
		    $sel="";
		    if ($row['catid'] == $selected ){
			    $sel="selected";
		    }
		    $drop .= '<option  value="'.$row['catid'].'">'.$row['catname'].'</option>';
	    }
    $drop .= '</select>';
    return $drop;
}

?>