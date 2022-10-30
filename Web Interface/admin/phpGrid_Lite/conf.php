<?php
define('PHPGRID_DB_HOSTNAME','localhost'); 
define('PHPGRID_DB_USERNAME', 'root');    
define('PHPGRID_DB_PASSWORD', ''); 
define('PHPGRID_DB_NAME', 'trolleyproject');
define('PHPGRID_DB_TYPE', 'mysqli'); 
define('PHPGRID_DB_CHARSET','utf8mb4');

// *** You should only define SERVER_ROOT manually when use Apache alias directive or IIS virtual directory ***
define('SERVER_ROOT', str_replace(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])),'', str_replace('\\', '/',dirname(__FILE__))));
define('THEME', 'start');
define('FRAMEWORK', '');
define('CDN', true);    
define('DEBUG', false); // *** MUST SET TO FALSE WHEN DEPLOYED IN PRODUCTION ***






/******** DO NOT MODIFY ***********/
require_once('phpGrid.php');
/**********************************/