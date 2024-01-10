<?php

/*
 * All database connection variables
 */

require_once __DIR__ .'/config.php';

$serverName = $_SERVER['SERVER_NAME'];
if($serverName == $GLOBALS['production']['WEB_SERVER']){
    $globalVar = $GLOBALS['production'];
}else{
    $globalVar = $GLOBALS['localhost'];
}

define('DB_USER', $globalVar['DB_USER']); // db user
define('DB_PASSWORD', $globalVar['DB_PASSWORD']); // db password (mention your db password here)
define('DB_DATABASE', $globalVar['DB_DATABASE']); // database name
define('DB_SERVER', $globalVar['DB_SERVER']); // db server

define('WEB_SERVER', $globalVar['WEB_SERVER']); // web server
define('DIR_API', $globalVar['DIR_API']); // directori API Production
define('PATH_FRONTEND', $globalVar['PATH_FRONTEND']);


?>