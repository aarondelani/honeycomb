<?php

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

?>