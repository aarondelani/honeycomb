<?php

$mysql_server = '127.0.0.1:3306';
$mysql_user = 'honeycomb';
$mysql_password = 'password';
$honeycomb_db = "HONEYCOMB";

// Create connection
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

// Check connection
if ($mysql_link->connect_error) {
    die("Connection failed: " . $mysql_link->connect_error);
}  else {
	$tableCheck = $mysql_link->query('SELECT 1 from `users_table`');

	if ($tableCheck === TRUE) {
			echo "tables exist!";
	} else {
		$setupUsers = "CREATE TABLE users_table (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			phone_number VARCHAR(20),
			user_assets BLOB,
			user_roles TINYBLOB,
			reg_date TIMESTAMP
		)";

		$setupClientTable = "CREATE TABLE clients_table (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			company_name VARCHAR(100) NOT NULL,
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			phone_number VARCHAR(20),
			fax_number VARCHAR(20),
			user_assets BLOB,
			client_roles TINYBLOB,
			reg_date TIMESTAMP
		)";

		$mysql_link->query($setupUsers);
		$mysql_link->query($setupClientTable);
	}
}

$users_table = $mysql_link->query('SELECT * FROM `users_table`');

if (isset($_POST['submit'])){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['e_mail'];
	$phone_1 = $_POST['phone_1'];

	$sql = "INSERT INTO users_table (first_name, last_name, email, phone_number) VALUES ('$first_name','$last_name','$email','$phone_1')";

	$mysql_link->query($sql);

	if ($mysql_link->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $mysql_link->error;
	}
} else {
	return true;
}

$mysql_link->close();
?>