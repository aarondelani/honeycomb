<div class="panel panel-default product-info">
	<div class="panel-heading">
		<h2 class="heading">
			<?php echo $_product_name; ?> <small style="background: <?php echo $primary_type_color; ?>" class="label label-primary">Style: <?php echo $_product_style; ?></small>
			<a class="btn btn-default <?php if($manage_product) {echo "active";} ?>" href="<?php echo $manage_product_link; ?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
		</h2>
	</div>
	<?php if ($manage_product) {
			if ($_product_description == NULL) {
				echo $_product_description = "Enter Product Description";
			}
		?>
		<form id="modify_product" action="reqs.php" method="post">
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="id_product" value="<?php echo $id_product; ?>">

			<div class="panel-body" id="product_contents">
				<h3>Description</h3>

				<div class="navbar navbar-default btn-toolbar" data-role="editor-toolbar" data-target="#prod_description_edit">
					<div class="btn-group">
						<a class="btn btn-default navbar-btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
					</div>
					<div class="btn-group">
					<a class="btn btn-default navbar-btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
							<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
							<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
						</ul>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="fa fa-outdent"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="fa fa-indent"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
						<div class="dropdown-menu input-append">
							<div class="form-group">
								<div class="input-group">
									<input class="span2 form-control" placeholder="URL" type="text" data-edit="createLink">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Add</button>
									</span>
								</div>
							</div>
						</div>
						<a class="btn btn-default navbar-btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-chain-broken"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn" title="" style="position: relative" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="fa fa-picture-o"></i><input type="file" class="form-control" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; right: 0; bottom: 0;"></a>
					</div>
					<div class="btn-group">
						<a class="btn btn-default navbar-btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
						<a class="btn btn-default navbar-btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
					</div>
				</div>

				<div class="form-control" id="prod_description_edit">
<?php echo $_product_description; ?>
				</div>

				<textarea class="sr-only" name="prod_description_edit" id="prod_description_edit_val"></textarea>
			</div>

			<nav class="navbar navbar-default" id="manage_product_bar">
				<div class="container-fluid">
					<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#addMaterial">Add Material Attribute</button>
					<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#addOption">Add Option</button>
				</div>
			</nav>

			<div class="panel-footer">
				<button type="submit" id="save_product_info" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save Changes</button>
			</div>
		</form>
	<?php } else { ?>
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
	<?php } ?>
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
