<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	include_once '../admin/vars.php';

	// Create connection
	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());

		exit();
	} else {
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

		if ($sql) {
			if ($mysql_link->query($sql) === TRUE) {
			    // echo "New record created successfully ". $result;
				echo "{result: TRUE}";
			} else {
				die('Error: ' . mysqli_error($mysql_link) . mysql_affected_rows());
			    echo "Error: " . $sql . "<br>" . $mysql_link->error;
			}
		}
	}

	$mysql_link->close();
}
?>