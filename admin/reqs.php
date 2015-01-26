<?php

include_once 'config.php';

// Create connection
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());

	exit();
}  else {
	$tableCheck = $mysql_link->query('SELECT 1 from `setup_config`');

	if ($tableCheck === TRUE) {
			echo "tables exist!";
	} else {
		$setup_config = "CREATE TABLE setup_config (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			attribute VARCHAR(30) NOT NULL,
			value VARCHAR(30) NOT NULL,
			reg_date TIMESTAMP
		);";

		$installQ = "INSERT INTO setup_config (attribute, value) VALUES ('init', '1');";

		// UCID = Unique Company ID
		$setupUsers = "CREATE TABLE users_table (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			UUID VARCHAR(30),
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			phone_number VARCHAR(20),
			user_assets BLOB,
			user_roles TINYBLOB,
			reg_date TIMESTAMP
		);";

		// UCID = Unique Company ID
		$setupClientTable = "CREATE TABLE clients_table (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			UCID VARCHAR(30),
			company_name VARCHAR(100) NOT NULL,
			first_name VARCHAR(30) NOT NULL,
			last_name VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			phone_number VARCHAR(20),
			fax_number VARCHAR(20),
			user_assets BLOB,
			client_roles TINYBLOB,
			reg_date TIMESTAMP
		);";

		// $mysql_link->query($setupUsers);

		$setup_config .= $installQ;
		$setup_config .= $setupUsers;
		$setup_config .= $setupClientTable;

		if (mysqli_multi_query($mysql_link, $setup_config)){
			do {
				/* store first result set */
				if ($result = mysqli_store_result($mysql_link)) {
					while ($row = mysqli_fetch_row($result)) {
						printf("%s\n", $row[0]);
					}
					mysqli_free_result($result);
				}
				/* print divider */
				if (mysqli_more_results($mysql_link)) {
					printf("Created");
				}
			} while (mysqli_next_result($mysql_link));
		}
	}
}

// function mysql_insert($table, $inserts) {
// 	$values = array_map('mysql_real_escape_string', array_values($inserts));
// 	$keys = array_keys($inserts);

// 	return mysql_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
// }
// mysql_insert(
// 	'cars', //table
// 	array( //key value pair
// 		'make' => 'Aston Martin',
// 		'model' => 'DB9',
// 		'year' => '2009',
// 	)
// );

//is ajax

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// if (isset($_POST['submit'])){

	if ($_POST['update_user']=='add') {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['e_mail'];
		$phone_1 = $_POST['phone_1'];

		$sql = "INSERT INTO users_table (first_name, last_name, email, phone_number) VALUES ('$first_name','$last_name','$email','$phone_1');";
	}

	// $mysql_link->query($sql);

	// $result = $mysql_link->query("SELECT * from users_table;");

	// Perform Query
	if ($sql) {
		if ($mysql_link->query($sql) === TRUE) {
		    echo "New record created successfully ". $result;
		} else {
			die('Error: ' . mysqli_error($mysql_link) . mysql_affected_rows());
		    echo "Error: " . $sql . "<br>" . $mysql_link->error;
		}
	}

	// Perform Multiple Queries
	if ($multi_sql) {
		if (mysqli_multi_query($mysql_link, $multi_sql)){
			do {
				/* store first result set */
				if ($result = mysqli_store_result($mysql_link)) {
					while ($row = mysqli_fetch_row($result)) {
						// printf("%s\n", $row[0]);
					}

					mysqli_free_result($result);
				}
				/* print divider */
				if (mysqli_more_results($mysql_link)) {
					// printf("-----------------\n");
				}
			} while (mysqli_next_result($mysql_link));
		}
	}
}

$mysql_link->close();
?>