<?php

$mysql_server = '127.0.0.1:3306';
$mysql_user = 'honeycomb';
$mysql_password = 'password';
$honeycomb_db = "_honeycomb";

$host = "http://192.168.0.144/~aaron/honeycomb";
// $host = "http://localhost/~aaron/HONEYCOMB";

// $site_location = "/Users/~aaron/Sites/HONEYCOMB";
$site_location = "/Users/~aaron/Sites/honeycomb";

//PARADOX SERVER LEGACY
$paradox_mysql_server = '192.168.0.118:3306';
$paradox_mysql_user = 'lesliejordan';
$paradox_mysql_password = '8L5w2V5';
$paradox_db = "paradox";

// For Leads
$sugar_mysql_server = '127.0.0.1:3306';
$sugar_mysql_user = 'honeycomb';
$sugar_mysql_password = 'password';
$sugar_db = "_sugar";

// Check Honeycomb Install
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);
$sugar_link = new mysqli($sugar_mysql_server, $sugar_mysql_user, $sugar_mysql_password, $sugar_db);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());

	exit();
}  else {
}

$mysql_link->close();

?>