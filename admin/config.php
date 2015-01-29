<?php

$mysql_server = '127.0.0.1:3306';
$mysql_user = 'honeycomb';
$mysql_password = 'password';
$honeycomb_db = "HONEYCOMB";


$host = "http://192.168.0.144/~aaron/honeycomb";
// $host = "http://localhost/~aaron/HONEYCOMB";

// $site_location = "/Users/~aaron/Sites/HONEYCOMB";
$site_location = "/Users/~aaron/Sites/HONEYCOMB";

//PARADOX SERVER LEGACY
$paradox_mysql_server = '192.168.0.118:3306';
$paradox_mysql_user = 'lesliejordan';
$paradox_mysql_password = '8L5w2V5';
$paradox_db = "paradox";

// $paradox_mysql_server = '127.0.0.1:3306';
// $paradox_mysql_user = 'root';
// $paradox_mysql_password = '';
// $paradox_db = "paradox";

// Check Honeycomb Install
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());

	exit();
}  else {
	$tableCheck = $mysql_link->query('SELECT 1 from `setup_config`');

	if ($tableCheck === TRUE) {
			echo "tables exist!";
	} else {
		include 'setup_config.php';
	}
}

$mysql_link->close();
?>