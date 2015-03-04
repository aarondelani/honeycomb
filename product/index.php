<?php
	// Need page preferences here

	include '../admin/vars.php';
	include '../admin/headers.php';

	$page_title = "Products";
	$product_page_active = TRUE;
	$body_class .= " product-page";
	$searching = FALSE;
	$autocomplete = TRUE;

	$ptid = NULL;

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	include 'display_product_reqs.php';

	$product_types = $mysql_link->query("SELECT * from product_types;");

	$products = $mysql_link->query("SELECT id_product, _product_style, _product_name FROM products;");

	$productsList = "";

	if ($products->num_rows > 0) {
		// output data of each row
		while($product = $products->fetch_assoc()) {
			// print_r($product);

			$productsList .= "{id: \"" . mysql_escape_string($product["id_product"]) . "\", name: \"" . mysql_escape_string($product["_product_style"]) . " " . mysql_escape_string($product["_product_name"]) . "\", styleNumber: \"" . mysql_escape_string($product["_product_style"]) . "\"},";
		}
	}

	$searchValue = "";
	if (isset($_GET["search"])) {
		$searchQuery = htmlspecialchars($_GET["search"]);

		if ($searchQuery != NULL) {
			$searching = TRUE;
			$searchValue = htmlspecialchars($_GET["search"]);
		}

		if (strpos($searchQuery, ' ') !== TRUE) {
			$searchQuery = "REGEXP \"". str_replace(" ", "|", $searchQuery) . "\"";
		} else {
			$searchQuery = "LIKE \"%" . $searchQuery . "%\"";
		}
	}

	if (isset($_GET['ptid'])) {
		$foundProduct_type = TRUE;

		$ptid = $_GET['ptid'];
	}

	include '../navigation.php';
?>
<div id="wrapper">
	<div id="content" class="container-fluid" role="main">
		<?php include 'navbar.php'; ?>
		<?php
			if ($foundProduct) {
				include 'display_product.php';
			}
		?>
		<div class="catalog-wrapper">
			<?php
				if ($foundProduct && !$manage_product){
					$similar_products = $mysql_link->query("SELECT * FROM products WHERE _product_style LIKE '%$_product_style%' AND '$_product_style' != products._product_style;");

					if ($similar_products->num_rows > 0) {
			?>
					<div class="panel panel-default">
						<div class="panel-heading">Similar Items:</div>
						<div class="list-group">
							<?php
								// output data of each row
								while($sim_prod = $similar_products->fetch_assoc()) {
									echo "<a data=\"".$sim_prod["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $sim_prod["id_product"] . "\"><span class=\"name\">". $sim_prod["_product_name"]. "</span> <span  style=\"background-color: " . $row["primary_type_color"] . ";\" class=\"label label-info\">".$sim_prod["_product_style"]."</span></a>";
								}
							 ?>
						</div>
					</div>
			<?php
					}
				}

			if ($foundProduct_type || $searching) {
				$query = NULL;

				if ($ptid === "all") {
					$catalog_title = "Showing All Products";

					$query .= "SELECT * FROM products;";
				} else {
					$query .="SELECT * FROM products WHERE $ptid = products._product_primary_type;";
				}

				if ($searching) {
					$catalog_title = "Searching for: " . $searchValue;

					$query = "SELECT id_product, _product_style, _product_name, _description, primary_type_color, _prod_image, product_primary_type_name FROM products WHERE _product_style $searchQuery OR _product_name $searchQuery OR _description $searchQuery;";
				}

				$prod_cat_by_type = $mysql_link->query($query);
			?>
				<h1><?php echo $catalog_title; ?></h1>

				<div class="list-group list-products">
					<?php
						if ($prod_cat_by_type->num_rows > 0) {
							// output data of each row
							while($row = $prod_cat_by_type->fetch_assoc()) {
								$label = $row["_product_style"];

								if ($searching) {
									$label = $row["product_primary_type_name"] . ": Style " . $label;
								}

								if ($row["_prod_image"] != NULL) {
									echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item media\" href=\"index.php?id=" . $row["id_product"] . "\"><div class=\"media-left\"><img class=\"media-object\" src=\"images/". $row["_prod_image"] . "\" alt=\"\"></div><div class=\"media-body\"><span class=\"name\">". $row["_product_name"]. "</span> <span style=\"background-color: " . $row["primary_type_color"] . ";\" class=\"label label-info\">".$label."</span></div></a>";
								} else {
									echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span style=\"background-color: " . $row["primary_type_color"] . ";\" class=\"label label-info\">".$label."</span></a>";
								}
							}
						} else {
							echo "<div class=\"alert alert-warning\">Sorry, couldn&apos;t find any items in the query you&apos;ve searched.</div>";
						}
					?>
				</div>
			<?php
			} else {
				if (!$foundProduct){
			?>
				<div class="row">
					<div class="col-md-6">
						<h1>Products</h1>
						<p>Welcome to the unified product catalog.</p>
					</div>
					<div class="col-md-6">
					<h2>Statistics:</h2>
						<p>Here&apos;s a quick view of our product statistics.</p>
						<canvas id="productChart" width="300" height="300"></canvas>
					</div>
				</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php
	$mysql_link->close();
	include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){
	<?php if($manage_product) { ?>

		var save_product_info_button = $('#save_product_info');
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
	<?php } ?>

	<?php if($charts) { ?>
	var productChart = $("#productChart");

	if (productChart.length > 0) {
		var ctx = productChart.get(0).getContext("2d");

		var product_types = <?php echo $products_types_arr; ?>];

		var options = {
			//Boolean - Whether we should show a stroke on each segment
			segmentShowStroke : false,

			//String - The colour of each segment stroke
			segmentStrokeColor : "#FFF",

			//Number - The width of each segment stroke
			segmentStrokeWidth: 0,

			//Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 20, // This is 0 for Pie charts

			// responsive: true,

			//Number - Amount of animation steps
			animationSteps : 100,

			//String - Animation easing effect
			animationEasing : "easeOutBounce",

			//Boolean - Whether we animate the rotation of the Doughnut
			animateRotate : true,

			//Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale : true,

			//String - A legend template
			legendTemplate : "<ul class=\"list-group <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li href=\"<%=segments[i].id%>\" class=\"list-group-item\"><span class=\"badge\" style=\"background-color:<%=segments[i].fillColor%>\"><%=segments[i].value%></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

			};

		var productChart = new Chart(ctx).Pie(product_types,options);

		console.log(productChart.segments[0]);
	}
	<?php } //end Charts ?>
	var productList = [<?php echo $productsList; ?>];

	var $searchProducts = $('#search_products');

	$searchProducts.typeahead({
		source: productList,
		autoSelect: false
		});

	$searchProducts.change(function() {
		var current = $searchProducts.typeahead("getActive");
		if (current) {
			// Some item from your model is active!
			console.log(current.id, current.styleNumber);
			if (current.name == $searchProducts.val()) {
				// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
				window.location = "index.php?id=" + current.id;
			} else {
				// This means it is only a partial match, you can either add a new item 
				// or take the active if you don't want new items
			}
		} else {
			// Nothing is active so it is a new value (or maybe empty value)
		}
	});

	var addCategoryForm = $('#addProdCategory');
	var attribute_table = $('#attribute_table');

	var add_attr_form = $('#add_attr_form'),
		add_attr_button = $('#add_attr_button');

	new ajaxifyForm(
		add_attr_form,
		function (form,data) {
			var data = data;
			console.log(data);

			if (!attribute_table) {
				new buildTable(
				{
					table_id: 'attribute_table'
				}, $("#product_contents"));
			}

			new buildRow(
				form,
				[data.attr, data.val],
				$("#attribute_table")
			);
		},
		true //clear form
	);
});
</script>