<?php



$host = $_SERVER['SERVER_NAME'];  

if ( $host === 'localhost' )   {   

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS","");
define("DB_NAME", "blog");

} else {
	die($_SERVER['SERVER_NAME']);
define("DB_HOST", "89.46.111.69");
define("DB_USER", "Sql1234437");
define("DB_PASS","28b1z587ce");
define("DB_NAME", "Sql1234437_1");

}
