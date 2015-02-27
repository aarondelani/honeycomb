<div class="panel panel-default product-info">
	<div class="panel-heading">
		<h2 class="heading">
			<?php echo $_product_name; ?> <small style="background: <?php echo $primary_type_color; ?>" class="label label-primary">Style: <?php echo $_product_style; ?></small>
			<a class="btn btn-default <?php if($manage_product) {echo "active";} ?>" href="<?php echo $manage_product_link; ?>"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Manage <?php echo $_product_name; ?></span></a>
		</h2>
	</div>
	<?php if ($manage_product) { ?>
		<nav class="navbar navbar-default" id="manage_product_bar">
			<div class="container-fluid">
				<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#addMaterial">Add Material Attribute</button>
				<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#addOption">Add Option</button>
			</div>
		</nav>
	<?php } ?>
	<div class="panel-body" id="product_contents">
		<?php
			if ($_product_description != NULL) {
				echo "<h3>Description</h3>";
				echo $_product_description; 
			}

			if ($prod_attr_count != NULL) {

				echo "<hr>";

				$product_attrs = $mysql_link->query("
					SELECT
						_prod_attrs.id,
						_prod_attrs._product_id,
						_prod_attrs.attr,
						_prod_attrs.val,
						_prod_attrs.val_large,
						(
						SELECT
						_prod_attributes_options._attr_name AS attribute_name
						FROM _prod_attributes_options
						WHERE _prod_attrs.attr = _prod_attributes_options.id
						GROUP BY id
						) AS attribute_name,
						(
						SELECT
						product_option_library.name AS attribute_name_proper
						FROM product_option_library
						WHERE _prod_attrs.val = product_option_library.id
						GROUP BY id
						) AS attribute_name_proper
					FROM _prod_attrs
					WHERE _prod_attrs._product_id = $id_product
				;");

				$attrs_images = array();
				$attrs_regular = "";

				if ($product_attrs->num_rows > 0) {
					// output data of each row
					while($attr = $product_attrs->fetch_assoc()) {
						if ($attr["attribute_name"] == "Image") {
							array_push($attrs_images, $attr["val"]);
						} else {
							// print_r($attr[0]);
							$attrs_regular .= "<tr><td>" . $attr["attribute_name"] . "</td><td>" . $attr["attribute_name_proper"] . "</td></tr>";
							if ($attr["val"] == NULL) {
								array_push($attrs_regular, $attr["val_large"]);
							} else {
							}
						}
					}
				}

				if ($attrs_regular != "") {
					echo
						"<h4>Attributes</h4>" .
						"<table class=\"table\" id=\"attribute_table\">" .
						"<thead><tr><th>Attribute</th><th>Value</th></tr></thead>" .
						$attrs_regular .
						"</table>";
				}

				if (count($attrs_images) > 0) {
					echo "<h4>Images</h4>";

					foreach ($attrs_images as $cat_image => $value) {
						echo "<div class=\"catalog-image img-thumbnail\"><img class=\"\" src=\"images/".$value."\"></div>";
					}
				}
			} else {
				echo "<hr><div class=\"alert alert-warning\" role=\"alert\">Couldn&apos;t find any attributes for ".$_product_name.".</div>";
			}

			$product_options = $mysql_link->query("SELECT * FROM _prod_attributes_options;");
			$product_option_library = $mysql_link->query("SELECT * FROM product_option_library WHERE _product_type = $product_primary_type;");

			$print_opt = FALSE;
			$print_list = NULL;
			$pre_prnt_temp = "<option class=\"\" value=\"";
			$post_prnt_temp = "</option>\n";
			$print_list_options = "";

			if ($product_options->num_rows > 0) {
				while($prod_option = $product_options->fetch_assoc()) {
					$print_list_options .= $pre_prnt_temp . mysql_escape_string($prod_option["id"]) . "\">" . mysql_escape_string($prod_option["_attr_name"]) . $post_prnt_temp;

					if ($product_option_library->num_rows > 0) {
						while($options = $product_option_library->fetch_assoc()) {
							if ($options["_prod_attr_option"] == $prod_option["id"]) {
								$print_opt = TRUE;
								$print_list .= $pre_prnt_temp . mysql_escape_string($options["id"]) . "\">" . mysql_escape_string($options["name"]) . " " . mysql_escape_string($options["val"]) . $post_prnt_temp;
							}
						}
					}
				}
			}
		?>


		<?php if (isset($_GET['id']) && !$foundProduct) { ?>
			<div class="alert alert-danger" role="alert">Whoops, couldn&apos;t find the product you were looking for.</div>
		<?php } ?>
	</div>
</div>

<div class="modal anti-aliased fade" id="addMaterial">
	<div class="modal-dialog">
		<form class="modal-content" id="add_attr_form" action="index.php" method="post" name="add_attribute">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Material</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="add_attr" value="TRUE">
				<input type="hidden" name="prod_id" value="<?php echo $id_product; ?>">
				<input type="hidden" name="attr" value="0">
				<label for="val">Material:</label>
				<?php
					if ($print_opt) {
						echo "<select name=\"val\" class=\"form-control\" data=\"" . mysql_escape_string($prod_option["id"]) . "\">";
						echo $print_list;
						echo "</select>";
					}
				 ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="add_attr_button" name="submit">Save</button>
			</div>
		</form>
	</div>
</div>


<div class="modal anti-aliased fade" id="addOption">
	<div class="modal-dialog">
		<form class="modal-content" id="add_attr_form" action="index.php" method="post" name="add_attribute">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Option</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="add_attr" value="TRUE">
				<input type="hidden" name="prod_id" value="<?php echo $id_product; ?>">
				<input type="hidden" name="attr" value="0">
				<label for="val">Option:</label>
				<?php
					if ($print_opt) {
						echo "<select name=\"val\" class=\"form-control\" data=\"" . mysql_escape_string($prod_option["id"]) . "\">";
						echo $print_list_options;
						echo "</select>";
					}
				 ?>
				 <input type="text" class="form-control" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="add_attr_button" name="submit">Save</button>
			</div>
		</form>
	</div>
</div>
