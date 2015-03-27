<?php
include_once 'config.php';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	// Create connection
	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);
	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());

		exit();
	} else {
		if ($_GET['from']=='customers') {
			$query = "WHERE cust_name LIKE '%" . $_GET['query'] . "%' LIMIT 10";
			$customers_results = array();

			if ($_GET['query'] == 'all') {
				$customers_table = $paradox_mysql_link->query("SELECT * FROM customers;");
			} else {
				$customers_table = $paradox_mysql_link->query("SELECT cust_id, cust_name FROM customers $query;");
			}

			if ($customers_table->num_rows > 0) {
				// output data of each row
				while($row = $customers_table->fetch_assoc()) {
					$mstrng = "/(\*DO NOT SELL\*|\*DO NOT QUOTE\*|\*DO NOT QTE\*|ACS\-|ZZB|S2L|ZZJ|ZZK|SCRN|ASI\-|ZZV|ZZE|RUN|RETAIL\-|NYRR\-|MAR\-|ZZDL|EM\-|BTL|BIKE\-|ALA\-|WA\-|TRI\-|CA|ZZSHOW|ZZS|ZZQ|ZZO|ATS|RRCA\-|ZZM|ZZMMAP|ZZLN|ZZLM|ZZLDR|ZZLDN|AHA\-|NY|ZZJFU|SHOW|SCRN\-A|RRCA\-|RRCA\-TX\-|RRCA\-VT\-|RRM|RSM|RRCA\-OH\-|RRCA\-NJ\-|RRCA\-NY|RFC\-WA\-|RFC|PROD\-|PRO\-|PRO|PARK\-|LLS\-WA)(.*)/";
					$custName_parsed = mysql_escape_string($row["cust_name"]);

					// $replacement = '$2","$1';
					$replacement = '$2';

					$custName_parsed = preg_replace($mstrng, $replacement, $custName_parsed);;
					$custName_parsed = strtolower($custName_parsed);

					// $customers_results .= '{id: \"' . mysql_escape_string($row["cust_id"]) . '\", name:"' . ucwords($custName_parsed) . '"},';

					array_push($customers_results, array("id" => $row["cust_id"], "name" => ucwords($custName_parsed)));
				}
			}

			echo utf8_encode(json_encode($customers_results));
		}

		if ($_GET['from']=='products') {
			$query = "WHERE _product_name LIKE '%" . $_GET['query'] . "%' OR _product_style LIKE '%" . $_GET['query'] . "%' LIMIT 10";
			$product_results = array();

			if ($_GET['query'] == 'all') {
				$products_table = $mysql_link->query("SELECT * FROM products;");
			} else {
				$products_table = $mysql_link->query("SELECT id_product, _product_style, _product_name FROM products $query;");
			}

			if ($products_table->num_rows > 0) {
				// output data of each row
				while($row = $products_table->fetch_assoc()) {
					array_push($product_results, array("id" => $row["id_product"], "name" => $row["_product_style"] . " " . $row["_product_name"], "prodName" => $row["_product_name"], "style" => $row["_product_style"]));
				}
			}

			echo utf8_encode(json_encode($product_results));
		}

		$sql = '';
		$multi_sql = '';

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

		if ($_POST['add_attr']==TRUE) {
			$prod_id = $_POST['prod_id'];
			$attr = $_POST['attr'];
			$val = $_POST['val'];
			$val_large = $_POST['val_large'];

			$sql = "INSERT INTO _prod_attrs (_product_id, attr, val) VALUES ($prod_id, $attr, $val);";
		}

		if ($_POST['add_image']==TRUE) {
			$prod_id = $_POST['prod_id'];
			$attr = $_POST['attr'];
			$val_large = $_POST['val_large'];

			$sql = "$prod_id, $attr, NULL, $val_large";
		}

		// $sql = "INSERT INTO `_honeycomb`.`_prod_attrs` (_product_id, attr, val, val_large) VALUES ($sql);";

		if($_POST['action'] == "update") {
			$new_prod_desc = mysql_escape_string($_POST['prod_description_edit']);
			$new_prod_desc = "\"" . $new_prod_desc . "\"";
			$post_prod = $_POST['id_product'];

			$sql = "UPDATE _product SET _description = $new_prod_desc WHERE id_product = $post_prod;";
		}

		// Generates a JSON Response for New Orders
		if($_POST['action'] == "new_order") {
			$id = "\"" . mysql_escape_string($_POST['id']) . "\"";
			$company_id = "\"" . mysql_escape_string($_POST['company_id']) . "\"";
			$company = "\"" . mysql_escape_string($_POST['company']) . "\"";
			$job_name = "\"" . mysql_escape_string($_POST['job_name']) . "\"";
			$new_order_hash = "\"" . mysql_escape_string($_POST['new_order_hash']) . "\"";
			$created_by = "\"" . mysql_escape_string($_POST['created_by']) . "\"";
			$userId = "\"" . mysql_escape_string($_POST['userId']) . "\"";

			$addNewOrderQ = "INSERT INTO _orders (id, company_id, job_name, company, order_hash, user_id, created_by) VALUES ($id, $company_id, $job_name, $company, $new_order_hash, $userId, $created_by);";

			if ($mysql_link->query($addNewOrderQ) === TRUE) {
				$new_order = $mysql_link->query("SELECT * FROM _orders WHERE order_hash = $new_order_hash LIMIT 1;");

				$new_order_results = array();

				if ($new_order->num_rows > 0) {
					// output data of each row
					while($row = $new_order->fetch_assoc()) {
						array_push($new_order_results, array("id" => $row["id"], "job_name" => $row["job_name"]));
					}
				}

				echo utf8_encode(json_encode($new_order_results));
			} else {
				die('Error: ' . mysqli_error($mysql_link) . mysql_affected_rows());
			    echo "Error: " . $sql . "<br>" . $mysql_link->error;
			}
		}

		// Perform Query
		if ($sql) {
			if ($mysql_link->query($sql) === TRUE) {
			    // echo "New record created successfully ". $result;

				echo json_encode($result, mysql_affected_rows());
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

}

$paradox_mysql_link->close();
$mysql_link->close();
die();
?>
