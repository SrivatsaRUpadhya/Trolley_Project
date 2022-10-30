<?php

// PHP Grid database connection settings, Only need to update these in new project

define("PHPGRID_DBTYPE","mysqli"); // mysql,oci8(for oracle),mssql,postgres,sybase
define("PHPGRID_DBHOST","localhost");
define("PHPGRID_DBUSER","id19414514_teamtrolley");
define("PHPGRID_DBPASS","Password@111");
define("PHPGRID_DBNAME","id19414514_trolleyproject");

// example configuration
// define("PHPGRID_DBTYPE","mysqli");
// define("PHPGRID_DBHOST","localhost");
// define("PHPGRID_DBUSER","root");
// define("PHPGRID_DBPASS","secret123");
// define("PHPGRID_DBNAME","griddemo");

// Basepath for lib
define("PHPGRID_LIBPATH",dirname(__FILE__).DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR);