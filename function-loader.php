<?php
/**
 * @file   function-loader.php
 * @Author Brad Newton ()
 * @date   February 2014
 * @brief  Global function loader. 
 *
 * Goes on every page as an include/require.
 */

//Start session stuff:
header("Cache-control: private");
 
 // Load basic confiiguration
require_once("global.config.inc.php");
require_once("jqm-head.php");


/* Function thing
 * @param array distribution info string
 * @return bool TRUE/FALSE
*/




// Load globally-required libraries
require_once("global-functions.php");
require_once("database-functions.php");


//Now that we're bootstrapped, load the databases
$databases['gman'] = database_connect( $localdb, $localdb['gman']);
$databases['seltzer'] = database_connect( $localdb, $localdb['seltzer']);

#$test = database_query($seltzer, "select * from user");
#echo $test['count'];

// List of page-required libraries is loaded in a space-deliminated list called $page_libs, parse it

    $lib_array = explode(" ", $page_libs);
    if ($lib_array[0] != "" ){
        foreach ( $lib_array as $lib )
        {
            if (file_exists($gmcfg['source']."/".$gmcfg['lib_dir']."/".$lib."-functions.php"))
                {
                    require_once($lib."-functions.php");
                }
                else
                {
                    gman_error("Library ".$gmcfg['source']."/".$gmcfg['lib_dir']."/".$lib."-functions.php not found");
                }
        
        }
    }




?>