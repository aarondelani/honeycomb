<?php
if (isset($_GET['id'])) {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$product = $mysql_link->query("SELECT * from products where (id_product = $id) LIMIT 1;");
	}

	$foundProduct = TRUE;
	$id_product = NULL;
	$_product_style = NULL;
	$_product_name = NULL;
	$product_primary_type = NULL;
	$product_primary_type_name = NULL;
	$_product_description = NULL;
	$prod_attr_count = NULL;

	if ($product->num_rows > 0) {
		// output data of each row
		while($row = $product->fetch_assoc()) {
			$id_product = $row["id_product"];

			if (isset($_GET['style'])) {
				$id = $id_product;
			}

			$_product_style = $row["_product_style"];
			$_product_name = $row["_product_name"];
			$product_primary_type = $row["_product_primary_type"];
			$product_primary_type_name = $row["product_primary_type_name"];
			$_product_description = $row["_description"];
			$ptid = $row["_product_primary_type"];
			$prod_attr_count = $row["attr_count"];
			$primary_type_color = $row["primary_type_color"];
		}
	} else {
		$foundProduct = FALSE;
	}

	if ($foundProduct) {
		$page_title = $_product_name . $_product_style . " | ";
	}
} else {
	if (!$foundProduct) {
		$charts = TRUE;
	}
}

$manage_product = FALSE;
$manage_product_link = "index.php?id=". $id . "&manage=" . TRUE;

if (isset($_GET['manage'])) {
	$manage_product = $_GET['manage'];
	$manage_product_link = "index.php?id=". $id;
	$bootstrapWYSIWYG = TRUE;
}
?>