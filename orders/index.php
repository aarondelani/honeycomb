<?php
	// Need page preferences here

	$order_page_active = TRUE;
	$body_class .= " order-page";
	$page_title = "Orders";
	$bootstrapWYSIWYG = TRUE;

	include '../admin/vars.php';
	include '../admin/headers.php';
	include '../navigation.php';

	$osid = NULL;
	$add_order = FALSE;

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$order_states = $mysql_link->query("SELECT * from order_state;");
	$orders = $mysql_link->query("SELECT * from _orders;");

	if (isset($_GET["order"])) {
		if ($_GET["order"] == "add_order") {
			$add_order = TRUE;
			$autocomplete = TRUE;

			$products = $mysql_link->query("SELECT id_product, _product_style, _product_name, _product_primary_type FROM products;");

			$productsList = "";

			if ($products->num_rows > 0) {
				// output data of each row
				while($product = $products->fetch_assoc()) {
					// print_r($product);

					$productsList .= "{id: \"" . mysql_escape_string($product["id_product"]) . "\", name: \"" . mysql_escape_string($product["_product_style"]) . " " . mysql_escape_string($product["_product_name"]) . "\", styleNumber: \"" . mysql_escape_string($product["_product_style"]) . "\", productType: \"" . mysql_escape_string($product["_product_primary_type"]) . "\"},";
				}
			}
		}

		if ($_GET["oipid"]) {
			
		}
	}

	if (isset($_GET['ordst'])) {
		$ordst = $_GET['ordst'];
	}
?>
<div id="wrapper">
	<div id="content" class="" role="main">
		<nav class="navbar navbar-default product-navbar">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo $host; ?>/orders">Orders</a>
			</div>

			<div class="collapse navbar-collapse" id="client_bar">
				<ul class="nav navbar-nav">
					<!-- <li><a href="manage"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a></li>
					<li><a href="manage"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li> -->
					<?php
					$pr_int = 0;
					if ($order_states->num_rows > 0) {
						// output data of each row
						while($order_state = $order_states->fetch_assoc()) {
							if ($ordst == $order_state["id"]) {
								$itemClass = " class=\"active\"";

								$catalog_title = $order_state["proper_name"];
							} else {
								$itemClass = "";
							}

							if ($order_state["stateCount"] == NULL) {
								$order_state_count = 0;
							} else {
								$order_state_count = $order_state["stateCount"];
							}

							$pr_int = $pr_int+1;

							echo "<li". $itemClass ."><a data=\"id:".$order_state["id"]."\" href=\"index.php?ordst=" . $order_state["id"] . "\"><span class=\"name\">". $order_state["proper_name"] . "</span> <span class=\"badge\">".$order_state_count."</span></a></li>";
						}
					} else {

					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="index.php?order=add_order" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add</a>
					</li>
					<li>
						<form class="navbar-form" action="index.php" method="get" name="id" id="searchProducts" role="search">
							<div class="form-group">
								<div class="input-group">
									<input type="text" class="form-control" name="style" placeholder="Search">

									<span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Submit</span></button></span>
								</div>
							</div>
						</form>
					</li>
				</ul>
			</div>
		</nav>
		<div class="">
		<?php if ($add_order) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Add Order</h3>
				</div>
				<div class="panel-body">
					<form action="<?php echo $host; ?>/orders/index.php" id="add_order" name="add_order" method="post">
					<div class="row">
						<div class="col-md-6 col-md-push-6">
							<fieldset>
								<legend>Order Information</legend>
								<input class="form-control" type="text" name="purchase_order" value="" placeholder="Purchase Order">
							</fieldset>
							<fieldset>
								<legend>Delivery Window</legend>
								<div class="input-group">
									<input class="form-control" name="delivery_window_start" type="date"><label class="input-group-addon" for="delivery_window_start">Start Date</label>
								</div>
								<div class="input-group">
									<input class="form-control" name="delivery_window_end" type="date"><label class="input-group-addon" for="delivery_window_end">End Date</label>
								</div>
							</fieldset>
						</div>
						<div class="col-md-6 col-md-pull-6">
							<fieldset>
								<legend>Customer Information</legend>
								<input class="form-control" type="text" name="company" value="" placeholder="Company">
								<input class="form-control" type="text" name="company_contact" value="" placeholder="Primary Contact">
							</fieldset>
							<!-- <fieldset>
								<legend>Deliver to:</legend>
								<input class="form-control" type="text" name="address" value="" placeholder="Name (Attention to)">
								<input class="form-control" type="text" name="address" value="" placeholder="Address">
								<input class="form-control" type="text" name="address_extra" value="" placeholder="Address Continued">
								<div class="row">
									<div class="col-md-4"><input type="text" class="form-control" placeholder="City"></div>
									<div class="col-md-4"><input type="text" class="form-control" placeholder="State"></div>
									<div class="col-md-4"><input type="text" class="form-control" placeholder="Zip"></div>
								</div>
							</fieldset> -->
						</div>
						<input type="hidden" value="new">
						<input type="hidden" name="order_state" value="2"> <?php // 2 is in Process ?>
					</form>
					</div>
					<!-- <div class="row">
						<div class="col-md-6">
							<fieldset>
								<legend>Bill to:</legend>
								<input class="form-control" type="text" name="address" value="" placeholder="Name (Attention to)">
								<input class="form-control" type="text" name="address" value="" placeholder="Address">
								<input class="form-control" type="text" name="address_extra" value="" placeholder="Address Continued">
								<div class="row">
									<div class="col-md-4"><input type="text" class="form-control" placeholder="City"></div>
									<div class="col-md-4"><input type="text" class="form-control" placeholder="State"></div>
									<div class="col-md-4"><input type="text" class="form-control" placeholder="Zip"></div>
								</div>
							</fieldset>
						</div>
						<div class="col-md-6"></div>
					</div> -->
				</div>
				<!-- <nav class="navbar navbar-default navbar-static-top">
				<div class="container">
				...
				</div>
				</nav> -->
				<!-- <div class="orders list-group">
					<a href="#" class="list-group-item"><span class="glyphicon glyphicon-plus"></span> Add an Item</a>
				</div> -->
				<form class="panel-body add-order-form" action="index.php" method="post" id="add_order_item_form">
					<h3>Ordered Items</h3>

					<div class="add-order-form row">
						<div class="col-md-6">
							<input type="text" class="form-control" id="add_product_input" name="order_item_style" placeholder="Search Style Number or Product Name">
							<div class="navbar hidden-xs navbar-default btn-toolbar" data-role="editor-toolbar" data-target="#editor">
								<div class="btn-group navbar-left navbar-form">
									<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="glyphicon glyphicon-text-height"></i>&nbsp;<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
										<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
										<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
									</ul>
								</div>
								<div class="btn-group navbar-left navbar-form">
									<a class="btn btn-default" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="glyphicon glyphicon-bold"></i></a>
									<a class="btn btn-default" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="glyphicon glyphicon-italic"></i></a>
								</div>
								<div class="btn-group navbar-left navbar-form anti-aliased">
									<a class="btn btn-default" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="glyphicon glyphicon-list"></i></a>
									<a class="btn btn-default" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="glyphicon glyphicon-indent-left"></i></a>
									<a class="btn btn-default" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="glyphicon glyphicon-indent-right"></i></a>
								</div>
								<div class="btn-group navbar-left navbar-form">
									<a class="btn btn-default btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="glyphicon glyphicon-align-left"></i></a>
									<a class="btn btn-default" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="glyphicon glyphicon-align-center"></i></a>
									<a class="btn btn-default" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="glyphicon glyphicon-align-right"></i></a>
									<a class="btn btn-default" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="glyphicon glyphicon-align-justify"></i></a>
								</div>
							</div>
							<div class="description form-control editor" id="editor">Description</div>
							 
							<select class="form-control" name="material" id="material">
								<option value="material">Material</option>

<?php 
	// $materials = $mysql_link->query("SELECT * FROM _product_attr_library WHERE _product_type = 0;");
	// // print_r($materials);
	// if ($materials->num_rows > 0) {
	// 	// output data of each row
	// 	while($material = $materials->fetch_assoc()) {
	// 		// print_r($product);

	// 		echo "<option value=\"" . mysql_escape_string($material["id"]) . "\">" . mysql_escape_string($material["name"]) . "</option>";
	// 	}
	// }
 ?>


							</select>
								<?php
									$product_options = $mysql_link->query("SELECT * FROM _prod_attributes_options;");
									$product_option_library = $mysql_link->query("SELECT * FROM product_option_library WHERE _product_type = $product_primary_type;");
									// print_r($product_options);

									$other_print_opt = FALSE;
									$other_print_list = NULL;
									if ($product_options->num_rows > 0) {
										// output data of each row
										while($prod_option = $product_options->fetch_assoc()) {
											$print_opt = FALSE;
											$print_list = NULL;

											if ($product_option_library->num_rows > 0) {
												// output data of each row
												while($options = $product_option_library->fetch_assoc()) {
													if ($options["_prod_attr_option"] == $prod_option["id"]) {
														$print_opt = TRUE;
														$print_list .= "<option value=\"" . mysql_escape_string($options["id"]) . "\">" . mysql_escape_string($options["name"]) . " " . mysql_escape_string($options["val"]) . "</option>";
													} else {
														$other_print_opt = TRUE;
														$other_print_list .= "<option value=\"" . mysql_escape_string($options["id"]) . "\">" . mysql_escape_string($options["name"]) . " " . mysql_escape_string($options["val"]) . "</option>";
													}
												}
											}

											if ($print_opt) {
												echo "<select class=\"form-control\" data=\"" . mysql_escape_string($prod_option["id"]) . "\">";
												echo $print_list;
												echo "</select>";
											}

											if ($other_print_opt) {
												echo "<select class=\"form-control\" data=\"" . mysql_escape_string($prod_option["id"]) . "\">";
												echo $other_print_list;
												echo "</select>";
											}

											$print_opt = FALSE;
											$print_list = NULL;
											$other_print_opt = FALSE;
											$other_print_list = NULL;
										}
									}
								?>
						</div>
						<div class="col-md-6">

						</div>
					</div>
				</form>
				<div class="panel-footer">
					<button class="btn btn-primary">Create Order</button>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php

	include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){
<?php
if($add_order) {
?>
	var $addProductInput = $('#add_product_input');
	var productList = [<?php echo $productsList; ?>];
	$('.editor').wysiwyg();

	$addProductInput.typeahead({
		source: productList,
		autoSelect: true
		});
	$addProductInput.change(function() {
		var current = $addProductInput.typeahead("getActive");
		if (current) {
			// Some item from your model is active!
			console.log(current.id, current.styleNumber, current.productType);
			if (current.name == $addProductInput.val()) {
				window.location = "index.php?oipid=" + current.id;
				// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
			} else {
				// This means it is only a partial match, you can either add a new item 
				// or take the active if you don't want new items
			}
		} else {
			// Nothing is active so it is a new value (or maybe empty value)
		}
	});
<?php } ?>

});
<?php 
	$mysql_link->close();
 ?>
</script>