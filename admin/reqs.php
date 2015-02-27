<?php

include_once 'config.php';

// Create connection
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}  else {
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

	if ($_POST['update_user']=='add_user') {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['e_mail'];
		$phone_1 = $_POST['phone_1'];

		$sql = "INSERT INTO users_table (first_name, last_name, email, phone_number) VALUES ('$first_name','$last_name','$email','$phone_1');";
	}

	if ($_POST['addProdCategory']=='addProdCategory') {
		$categoryName = $_POST['categoryName'];
		$categoryDescription = $_POST['categoryDescription'];

		$sql = "INSERT INTO _catalogId (catalog_name, catalog_description) VALUES ('$categoryName', '$categoryDescription');";
	}

	if ($_POST['addProd']=='addProd') {
		$prod_name = $_POST['prod_name'];
		$categoryDescription = $_POST['categoryDescription'];

		$sql = "INSERT INTO _prod_table (prod_name, prod_style, prod_material, prod_description) VALUES ('$prod_name', '$prod_style', '$prod_material', '$prod_description');";
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