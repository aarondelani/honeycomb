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
			$get_cust_info = FALSE;

			$products = $mysql_link->query("SELECT id_product, _product_style, _product_name, _product_primary_type FROM products;");

			$productsList = "";

			if ($products->num_rows > 0) {
				// output data of each row
				while($product = $products->fetch_assoc()) {
					// print_r($product);

					$productsList .= "{id: \"" . mysql_escape_string($product["id_product"]) . "\", name: \"" . mysql_escape_string($product["_product_style"]) . " " . mysql_escape_string($product["_product_name"]) . "\", styleNumber: \"" . mysql_escape_string($product["_product_style"]) . "\", productType: \"" . mysql_escape_string($product["_product_primary_type"]) . "\"},";
				}
			}

			if ($_GET["page"] == "customer_information") {
				$cust_info = TRUE;
			}

			if ($_GET["page"] == "items") {
				$add_order_item = TRUE;
			}
		}

		if ($_GET["oipid"]) {
		}
		http_build_query(array_merge($_GET, array('oipid'=>$_GET["oipid"])));
	}

	if (isset($_GET['ordst'])) {
		$ordst = $_GET['ordst'];
	}
	// Building Navbar for Orders
	$pr_int = 0;
	$order_navs = "";
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

			$order_navs .= "<li". $itemClass ."><a data=\"id:".$order_state["id"]."\" href=\"index.php?ordst=" . $order_state["id"] . "\"><span class=\"name\">". $order_state["proper_name"] . "</span> <span class=\"badge\">".$order_state_count."</span></a></li>";
		}
	} else {

	}
	// End Building Nav Bar
?>
<div id="wrapper">
	<div id="content" class="" role="main">
		<?php include 'order_navbar.php'; ?>
		<div class="">
		<?php if ($add_order) { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Add Order</h3>
				</div>
				<?php if ($cust_info || $add_order_item) { ?>
				<ul class="nav nav-tabs nav-justified" id="order_page_nav">
					<li role="presentation" <?php if ($cust_info) { echo " class=\"active\"";} ?>><a href="index.php?order=add_order&page=customer_information">Customer Information</a></li>
					<li role="presentation" <?php if ($add_order_item) { echo " class=\"active\"";} ?>><a href="index.php?order=add_order&page=items">Ordered Items</a></li>
					<li role="presentation"><a href="#">Other</a></li>
				</ul>
				<?php } ?>

				<?php if ($cust_info) { ?>
				<div class="panel-body">
					<form action="../core/reqs.php" method="POST" id="customer_information_form">
						<input type="hidden" name="action" value="new_order">
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" id="company_name_input" name="company_name" placeholder="Company">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control" name="job_name" placeholder="Job Name">
							</div>
							<div class="col-md-4">

							</div>
						</div>
					</form>
				</div>
				<?php } ?>

				<?php if ($add_order_item) { ?>
				<form class="panel-body add-order-form" action="<?php echo $_SESSION['url']; ?>" method="get" id="add_order_item_form">
					<input type="hidden">
					<div class="input-group">
						<input type="text" class="form-control" id="add_product_input" autocomplete="off" name="order_item_style" placeholder="Search Style Number or Product Name">
						<span class="input-group-btn"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add an Item</button></span>
					</div>
				</form>
				<?php } ?>

				<div class="panel-footer">
					<button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Save Order as Quote">Save Order <span class="glyphicon glyphicon-save"></span></button>
					<button class="btn btn-default disabled" disabled data-toggle="tooltip" data-placement="top" title="Send to Production">Place Order <span class="glyphicon glyphicon-send"></span></button>
				</div>
			</div>
		<?php } ?>
		</div>
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
	if ($cust_info) {
?>

var getQuery = function(from, query) {
	var table = from;
	var query = query;

	$.ajax({
		type: 'GET',
		url: "<?php echo $host; ?>/admin/reqs.php",
		dataType: 'text',
		processData: true,
		data: {
			from: table,
			query: '%' + query + '%'
		},
		contentType: 'application/x-www-form-urlencoded',
		success: function (resp) {
			console.log(resp);
			return resp;
		}
	});
};

var companies = new Bloodhound({
		prefetch: '<?php echo $host; ?>/admin/reqs.php?from=customers&query=all',
		remote: '<?php echo $host; ?>/admin/reqs.php?from=customers&query=%QUERY',
		datumTokenizer: function(d) {
			return Bloodhound.tokenizers.whitespace(d.val);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace
	});

companies.initialize();

console.log(companies);

var companyNameInput = $('#company_name_input');

companyNameInput.typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},{
		name: 'name',
		displayKey: 'name',
		source: companies.ttAdapter(),
		autoSelect: true
	}
);

companyNameInput.change(function() {
	var current = companyNameInput.typeahead("getActive");
	console.log(current);

	if (current) {
		console.log('Text',current, current.name);
		// Some item from your model is active!
		if (current.name == companyNameInput.val()) {
			// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
		} else {
			// This means it is only a partial match, you can either add a new item
			// or take the active if you don't want new items
		}
	} else {
		// Nothing is active so it is a new value (or maybe empty value)
	}
});

<?php
	} // End Customer Page JS

	// Begin Order Items JS
	if ($add_order_item) {
?>
	var addProductForm = $('#add_order_item_form');
	var addProductInput = $('#add_product_input');
	var productList = [<?php echo $productsList; ?>];

	var newOrderItem = function (id, style, prodName) {
		var order_item_node = $('<div class="order-item">');
		var stuff = '<strong>' + prodName + '</strong>';

		order_item_node.append(stuff);

		addProductForm.append(order_item_node);
	};

	$('.editor').wysiwyg();

	addProductInput.typeahead({
		source: productList,
		autoSelect: true
		});

	addProductInput.change(function() {
		var current = addProductInput.typeahead("getActive");

		if (current) {
			// Some item from your model is active!
			if (current.name == addProductInput.val()) {
				console.log(current.id, current.styleNumber, current.name);

				new newOrderItem(current.id, current.styleNumber, current.name);

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
<?php
	}
}
?>

});
<?php
	$mysql_link->close();
 ?>
</script>
