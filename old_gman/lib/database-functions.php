<?php
/**
 * @file   database-functions.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  database function library
 *
 * Functions for connecting to and manipulating databases.
 */

 /* database connection creator
 * @param array database identifier
 * @param string database name of the database to connect to
 * @return object: mysqli object of the connection.
*/
 
function database_connect($database, $database_name)
{
    $db = new mysqli($database['dbhost'], $database['dbuser'], $database['dbpass'], $database_name);

    if($db->connect_errno > 0)
    {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    else
    {
        return  $db;
    }
}

 /* Function thing
 * @param object database mysqli connection to use. This assumes the user has properly sanitized all input. Bobby Tables incidents are your own damn fault.
 * @param string query
 * @return array associative array with results and addition data
*/
function database_query($database, $run_query)
{
    $output = array();
    $output['query'] = $run_query;
    if (!$query = $database->query($run_query))
    {
        #echo $run_query; 
        die(' ERROR: '.$run_query.'<br> [' . $database->error . ']');
    }
    else
    {
        $output['result']   = array();
        while ($row = $query->fetch_assoc())
        {
            $output['result'][] = $row;
        }
        $output['count']    = $query->num_rows;
        $query->free();
    }
    return $output;
}


 /* Function thing
 * @param object database mysqli connection to use. This assumes the user has properly sanitized all input. Bobby Tables incidents are your own damn fault.
 * @param string query
 * @return array associative array with results and addition data
*/
function database_update($database, $run_query)
{
    $output = array();
    $output['query'] = $run_query;
    if (!$query = $database->query($run_query))
    {
        #echo $run_query; 
        die(' ERROR: '.$run_query.'<br> [' . $database->error . ']');
    }
    else
    {
        $output['result']   = array();
        $output['count'] = $query->affected_rows;
        
    }
    return $output;
}

 /* Function thing
 * @param object database mysqli connection to use. This assumes the user has properly sanitized all input. Bobby Tables incidents are your own damn fault.
 * @param string query
 * @return array associative array with results and addition data
*/
function database_insert($database, $table, $fields)
{
   #deconstruct $fields array and put values where they're supposed to be.
	$n	=	0;
	$c	=	count($fields)-1;
	$flist	=	'SET ';
	$fn	=	array_keys($fields);
	while ($n <= $c)
		{
		$fieldname	=	$fn[$n];
		$qtval		=	$fields[$fieldname];
		$flist		.=	$fieldname . " = " . $qtval . ", ";
		$n++;
		}
	$flist  =       trim($flist);
	$flist	=	trim($flist,",");
	
	
		$ins = "insert into ".$table." ".$flist;
                 $output = array();
                 $output['query'] = $ins;
                 if (!$database->query($ins))
                 {
                    die(' There was an error running the query "'.$ins.'"[' . $database->error . ']');
                 }
                 else{
                    $output['id'] = $database->insert_id;
                 }
        return $output;
                
		
}


# Mysql magic quote function (from slagg3)
function qt($link, $value)
{

        // Stripslashes
	
	$value = stripslashes($value);
    	// Quote if not integer
	if (!is_numeric($value)) 
		{
		$value = "'" . mysqli_escape_string($link, $value) . "'";
		}
	return $value;
}

function local_connect($name)
{
    global $localdb;
    $conn = database_connect($localdb, $localdb[$name]);
    return $conn;
}

 ?>