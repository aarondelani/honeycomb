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
	$ordst = "";
	$add_order = FALSE;
	$manage_order = FALSE;
	$get_by_hash = FALSE;
	$browsing_order = FALSE;

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$order_states = $mysql_link->query("SELECT * from order_state;");
	$orders = $mysql_link->query("SELECT * from _orders;");

	if (isset($_GET["ordst"])) {
		$ordst = $_GET["ordst"];
	}

	if (isset($_GET["action"])) {
		if ($_GET["action"] == "add_order") {
			$add_order = TRUE;

			// Creating a unique order hash number for callback on new order submit via Datetime
			$new_order_hash = new DateTime();
			$new_order_hash = $new_order_hash->format('Y-m-d-H-i-s');
			$new_order_hash = explode('-', $new_order_hash);
			$new_order_hash = implode("", $new_order_hash);
			$new_order_hash = md5($new_order_hash);
		}

		if ($_GET["action"] == "manage") {
			$manage_order = TRUE;
		}
	}

	if (isset($_GET["hash"])) {
		$get_by_hash = TRUE;
		$browsing_order = TRUE;
	}

	if (isset($_GET["orderId"]) OR $browsing_order) {
		$browsing_order = TRUE;
		$company_id = "";
		$purchase_order = "";
		$job_name = "";
		$company_name = "";
		$order_hash = "";

		if (!$get_by_hash) {
			$order_id = $_GET["orderId"];
			$order = $mysql_link->query("SELECT * from _orders WHERE id = $order_id LIMIT 1;");
		} else {
			$hash = $_GET["hash"];
			$order_id = "";

			$orQuery = "SELECT * from _orders WHERE order_hash = \"" . $hash . "\" LIMIT 1;";

			$order = $mysql_link->query($orQuery);
		}

		if ($order->num_rows > 0) {
			// output data of each row
			while($row = $order->fetch_assoc()) {
				// print_r($row);
				$order_id = $row["id"];
				$company_id = $row["company_id"];
				$company_name = $row["company"];
				$purchase_order = $row["purchase_order"];
				$job_name = $row["job_name"];
				$order_status = $row["order_status"];
				$order_hash = $row["order_hash"];
				$order_timestamp = $row["timestamp"];
				$english_timestamp = date('D, F jS, Y, g:i:sa T', strtotime($order_timestamp));
				$created_by = $row["created_by"];
			}
		}
	}

	if ($_GET["page"] == "order_info") {
		$cust_info = TRUE;
		$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
		$cQuery = "SELECT * FROM customers WHERE cust_id = $company_id LIMIT 1";
		$company_info = $paradox_mysql_link->query($cQuery);

		if ($company_info->num_rows > 0) {
					// output data of each row
			while($row = $company_info->fetch_assoc()) {
				// print_r($row);
				$comp_contact = $row["cust_cont_firstname"] . " " . $row["cust_cont_lastname"];
				$comp_contact_email = $row["cust_cont_email"];
				$comp_address = $row["cust_address1"];
				$comp_address_cont = $row["cust_address2"];
				$comp_address_city = $row["cust_city"];
				$comp_address_state = $row["cust_state"];
				$comp_address_zip = $row["cust_zip"];

			}
		}

		$paradox_mysql_link->close();
	}

	if ($_GET["page"] == "items") {
		$add_order_item = TRUE;
	}

	// Building Navbar for Orders
	$pr_int = 0;
	$order_navs = "";
	if ($order_states->num_rows > 0) {
		// output data of each row
		while($order_state = $order_states->fetch_assoc()) {
			if ($ordst == $order_state["id"] || $order_status == $order_state["id"]) {
				$itemClass = " class=\"active\"";

				$order_title = $order_state["proper_name"];
			} else {
				$itemClass = "";
			}

			if ($order_state["stateCount"] == NULL) {
				$order_state_count = 0;
			} else {
				$order_state_count = $order_state["stateCount"];
			}

			$pr_int = $pr_int+1;

			$order_navs .= "<li". $itemClass ."><a data=\"id:" . $order_state["id"] . "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . $order_state["description"] . "\" href=\"index.php?ordst=" . $order_state["id"] . "\"><span class=\"name\">". $order_state["proper_name"] . "</span> <span class=\"badge\">".$order_state_count."</span></a></li>";
		}
	} else {

	}
	// End Building Nav Bar
?>
<div id="wrapper">
	<div id="content" class="" role="main">
		<?php include 'order_navbar.php'; ?>
		<?php if (isset($_GET["ordst"])) { ?>
			<h1><?php echo $order_title; ?></h1>

			<div class="list-group">
			<?php $order = $mysql_link->query("SELECT * from _orders WHERE order_status = $ordst;");
				if ($order->num_rows > 0) {
					// output data of each row
					while($row = $order->fetch_assoc()) {
						// print_r($row);
						$order_id = $row["id"];
						$purchase_order = $row["purchase_order"];
						$company_id = $row["company_id"];
						$company_name = $row["company"];
						$purchase_order = $row["purchase_order"];
						$job_name = $row["job_name"];
						$order_status = $row["order_status"];
						$order_hash = $row["order_hash"];
						$order_timestamp = $row["timestamp"];
						$english_timestamp = date('D, F jS, Y', strtotime($order_timestamp));
						$created_by = $row["created_by"];
			?>
				<a href="index.php?orderId=<?php echo $order_id; ?>&page=order_info" class="list-group-item"><strong><?php echo $job_name; ?></strong> | <?php echo $company_name; ?> <span class="label anti-aliased label-info">Date: <?php echo $english_timestamp; ?></span></a>

			<?php } } // Ending Order List loop here ?>
			</div>
		<?php } else { ?>
			<div class="container">
				<div class="alert alert-danger">
					<h3>STOP</h3>
					<strong>Whoa... wait right there...</strong> This is not the order page you are looking for.
				</div>
				<p>This is a testing page/research for possible upcoming features.</p>
			</div>
		<?php }; ?>
		<?php if ($add_order) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Add Order</h3>
				</div>

				<form id="stage_1_order_form" action="<?php echo $host; ?>/admin/reqs.php" method="post">
					<input type="hidden" name="action" value="new_order">
					<input type="hidden" name="id" value="0">
					<input type="hidden" name="new_order_hash" value="<?php echo $new_order_hash; ?>">
					<input type="hidden" name="created_by" value="<?php echo $_SESSION['user_full_name']; ?>">
					<input type="hidden" name="userId" value="<?php echo $_SESSION['siteuser']; ?>">

					<div class="panel-body">
						<input type="text" class="form-control" id="company_name_input" name="company_name" placeholder="Company">
						<input type="text" class="form-control" name="job_name" placeholder="Job Name" required>
						<p>
							By saving, you&apos;re creating a quote, you&apos;ll be able to add items and modify contact information in the next step.
						</p>
					</div>

					<div class="panel-footer">
						<button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Proceed to Next Step">Save <span class="glyphicon glyphicon-save"></span></button>
						<span> <strong>Next:</strong> Add Items to the Order</span>
					</div>
				</form>
			</div>
		<?php } ?>

		<?php if ($browsing_order) { ?>
		<div class="container">
			<div class="panel order-panel panel-default">
				<div class="panel-heading">
					<div class="row">

						<div class="col-md-6">
							<h2><?php echo $job_name; ?></h2>
							<p>
								<a href="#<?php echo $company_id; ?>"></a><?php echo $company_name; ?>
							</p>
						</div>
						<div class="col-md-6">
							<div class="btn-group fl-right">
								<a href="index.php?orderId=<?php echo $order_id; ?>&page=order_info&action=manage" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Edit Order</a>
							</div>
							<h4>Info</h4>
							<p><strong>Created</strong> <?php echo $english_timestamp; ?> <br>
							<strong>by</strong> <?php echo $created_by; ?></p>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs nav-justified" id="order_page_nav">
						<li role="presentation" <?php if ($cust_info) { echo " class=\"active\"";} ?>><a href="index.php?orderId=<?php echo $order_id; ?>&action=manage&page=order_info">Order Information</a></li>
						<li role="presentation" <?php if ($add_order_item) { echo " class=\"active\"";} ?>><a href="index.php?orderId=<?php echo $order_id; ?>&action=manage&page=items">Ordered Items</a></li>
						<li role="presentation"><a href="#">Other</a></li>
					</ul>

					<?php print_r($_SESSION["URL"]) ?>
						<?php if ($cust_info): ?>
							<div class="row">
								<div class="col-md-4">
									<p>The following information comes from the customer database.</p>

									<ul class="list-group">
										<li class="list-group-item"><strong>Company Contact:</strong> <?php echo $comp_contact; ?></li>
										<li class="list-group-item"><strong>Email:</strong> <?php echo $comp_contact_email; ?></li>
										<li class="list-group-item">
											<strong>Address:</strong><br>
											<?php
												echo $comp_address . "<br>";
												if ($comp_address_cont != "") {
													echo $comp_address_cont . "<br>";
												}

												echo $comp_address_city . ", " . $comp_address_state . ", " .  $comp_address_zip;
											 ?>
										</li>
									</ul>
								</div>
								<div class="col-md-4">Shipping Information</div>
								<div class="col-md-4"></div>
							</div>

							<?php 
								// echo $comp_contact . "<br>";
								// echo $comp_address . "<br>";
								// echo $comp_address_cont . "<br>";
								// echo $comp_address_city . "<br>";
								// echo $comp_address_state . "<br>";
								// echo $comp_address_zip . "<br>";
							 ?>
						<?php endif; ?>

					<?php if ($manage_order) { ?>
						<?php if ($add_order_item) { ?>
						<form class="add-order-form" action="" method="get" id="add_order_item_form">
							<input type="hidden">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span> Add an Item</span>
								<input type="text" class="form-control" id="add_product_input" autocomplete="off" name="order_item_style" placeholder="Search Style Number or Product Name">
							</div>
						</form>

						<?php } //include 'wysiwyg.php' ?>
					<?php } else {; ?>

					<?php 

					} ?>
				</div>

				<?php if ($manage_order): ?>
					<div class="panel-footer">
						<button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Save Order as Quote">Save Order <span class="glyphicon glyphicon-save"></span></button>
						<button class="btn btn-default disabled" disabled data-toggle="tooltip" data-placement="top" title="Send to Production">Place Order <span class="glyphicon glyphicon-send"></span></button>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<?php
	// print_r($_SESSION['url']);
	$autocomplete = TRUE;

	include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){

<?php
if($add_order) {
	// Begin Customer Page JS
?>

	var stage1Form = $('#stage_1_order_form');

	if (stage1Form.length == 1) {
		new ajaxifyForm(
				stage1Form,
				function(resp) {
					console.log(resp);
					if (resp.success) {
						window.location = '<?php echo $host; ?>/orders/index.php?hash=<?php echo $new_order_hash ?>&action=manage&page=order_info';
					}
				},
				true
			);
	}

// Declaring Input
	var companyNameInput = $('#company_name_input');

	// Prefetch and get JSON Object for Companies
	var companies = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '<?php echo $host; ?>/admin/reqs.php?from=customers&query=all',
			remote: '<?php echo $host; ?>/admin/reqs.php?from=customers&query=%QUERY',
			limit: 10 // also set in reqs.php for speed
		});

	companies.initialize();

	companyNameInput.typeahead({
		source: companies.ttAdapter(),
		autoSelect: false
	});

	companyNameInput.change(function(event) {
		var current = companyNameInput.typeahead("getActive");
			console.log(current);

		if (current) {
			// Some item from your model is active!
			if (current.name == companyNameInput.val()) {
				// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
				new createInputProperty('company_id', current.id , stage1Form);
				new createInputProperty('company', current.name , stage1Form);
			} else {
				// This means it is only a partial match, you can either add a new item
				// or take the active if you don't want new items
			}
		} else {
			// Nothing is active so it is a new value (or maybe empty value)
		}
	});

<?php
 // End Customer Page JS
}
	// Begin Order Items JS
	if ($add_order_item) {
?>
	var addProductForm = $('#add_order_item_form');
	var addProductInput = $('#add_product_input');
	var temp_items_node = $('<div class="temp-order-items list-group">');
	var add_temp_items_btn = $('<button class="btn btn-primary" name="add_vals">Add Selected Items <span class="glyphicon glyphicon-plus"></span></button>')
	var added_temps_node = false;

	var newOrderItem = function (params) {
		// {id, style, name, node}
		var order_item_node = $('<label class="order-item list-group-item checkbox">');
		var checkbox = $('<input type="checkbox" name="' + params.id + '-add' + '">');
		var stuff = ' <strong>' + params.name + '</strong> <span class="label label-info">' + params.style + '</span> <a class="arv-right" data-toggle="tooltip" data-placement="top" title="Preview ' + params.name + " " + params.style + ' (Opens in new window)" href="../product/index.php?id=' + params.id + '" target="_blank">Preview <span class="fa fa-eye"></span></a>';

		checkbox.attr('data-prod-id', params.id);
		checkbox.attr('data-order-id', <?php echo $order_id ?>);

		order_item_node.append(checkbox);
		order_item_node.append(stuff);

		checkbox.on(
			'change',
			function(event) {
				console.log(event.currentTarget.checked);
			});

		$(params.node).append(order_item_node);
		$('[data-toggle="tooltip"]').tooltip();
	};

	var addOrderItems = function () {
		var items = temp_items_node.children('.order-item');

		// Checking to see the value of the item's children .val() does not work.
		// Jquery return's the value of a checkbox as "checked" with the true or false
		console.log(items.children('input[type=checkbox]').checked);
	};

	console.l

	add_temp_items_btn.on(
		'click',
		function (event) {
			event.preventDefault();
			addOrderItems();
		}
	);

	// Prefetch and get JSON Object for Products
	var products = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '<?php echo $host; ?>/admin/reqs.php?from=products&query=all',
			remote: '<?php echo $host; ?>/admin/reqs.php?from=products&query=%QUERY',
			limit: 10 // also set in reqs.php for speed
		});

	products.initialize();

	addProductInput.typeahead({
		source: products.ttAdapter(),
		autoSelect: true
		});

	addProductInput.change(function() {
		var current = addProductInput.typeahead("getActive");

		if (current) {
			// Some item from your model is active!
			if (current.name == addProductInput.val()) {
				console.log(current.id, current.style, current.name);

				if (!added_temps_node) {
					addProductForm.append(temp_items_node);
					addProductForm.after(add_temp_items_btn);

					added_temps_node = true;
				}

				new newOrderItem({
						id: current.id,
						style: current.style,
						name: current.name,
						node: temp_items_node
					});

				addProductInput.val('');
				// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
			} else {
				// This means it is only a partial match, you can either add a new item
				// or take the active if you don't want new items
			}
		} else {
			// Nothing is active so it is a new value (or maybe empty value)
		}
	});

	var prod_description = $('#prod_description_edit');
	var prod_description_val = $('#prod_description_edit_val');

	var traverseProd = function (i) {
		prod_description_val.html(i);
	};

	prod_description.on('blur', function () {
		traverseProd(this.innerHTML);
		// console.log(prod_description_val.innerHTML);
	}).wysiwyg();

	new ajaxifyForm(
		$('#modify_product'),
		function (form,data) {
			var data = data;
		},
		false
	);

<?php
	}

?>

});
</script>
<?php
	$mysql_link->close();
?>
