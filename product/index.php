<?php
	// Need page preferences here

	$product_page_active = TRUE;
	$body_class .= " product-page";
	$bootstrapWYSIWYG = TRUE;

	include '../admin/headers.php';
	include '../admin/vars.php';

	include '../navigation.php';

	$ptid = NULL;

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$product_types = $mysql_link->query("SELECT * from product_types;");
	$products_types_arr = "[";

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$foundProduct = TRUE;
		$id_product = NULL;
		$_product_style = NULL;
		$_product_name = NULL;
		$product_primary_type_name = NULL;
		$_product_description = NULL;
		$prod_attr_count = NULL;

		$product = $mysql_link->query("SELECT * from products where (id_product = $id) LIMIT 1;");

		if ($product->num_rows > 0) {
			// output data of each row
			while($row = $product->fetch_assoc()) {
				$id_product = $row["id_product"];
				$_product_style = $row["_product_style"];
				$_product_name = $row["_product_name"];
				$product_primary_type_name = $row["product_primary_type_name"];
				$_product_description = $row["_description"];
				$ptid = $row["_product_primary_type"];
				$prod_attr_count = $row["attr_count"];
			}
		} else {
			$foundProduct = FALSE;
		}
	}
?>
<div id="wrapper">
	<div id="content" class="container" role="main">
	<nav class="navbar navbar-default">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $host; ?>/product">Products</a>
		</div>

		<div class="collapse navbar-collapse" id="client_bar">
			<ul class="nav navbar-nav">
				<li><a href="manage"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a></li>
				<li><a href="manage"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
			</ul>
		</div>
	</nav>
		<div class="catalog-wrapper">
		<div class="row">
			<div class="col-md-8 col-md-push-4">
				<?php
				if ($foundProduct) { ?>
					<div class="panel panel-default product-info">
						<div class="panel-heading">
							<h2 class="heading"><?php echo $_product_name; ?> <small class="label label-primary">Style: <?php echo $_product_style; ?></small></h2>
						</div>
						<div class="panel-body" data="">
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
											) AS attribute_name
										FROM _prod_attrs
										WHERE _prod_attrs._product_id = $id_product
									;");

									$attrs_images = array();
									$attrs_regular = array();

									if ($product_attrs->num_rows > 0) {
										// output data of each row
										while($attr = $product_attrs->fetch_assoc()) {
											if ($attr["attribute_name"] == "Image") {
												array_push($attrs_images, $attr["val"]);
											} else {
												array_push($attrs_regular, $attr["val"]);
											}
										}
									}

									if (count($attrs_regular) > 0) {
										echo "<h4>Attributes</h4>";
										echo "<table class=\"table\">";
										echo "<thead><tr><th>Attribute</th><th>Value</th></tr></thead>";

										foreach ($attrs_regular as $attr_reg => $value) {
											echo "<tr class=\"\"><td>".$attr["attribute_name"]."</td><td>".$attr["val"]."</td></tr>";
										}
										echo "</table>";
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
							 ?>
						</div>
					</div>
				<?php } if (isset($_GET['id']) && !$foundProduct) { ?>
					<div class="alert alert-danger" role="alert">Whoops, couldn&apos;t find the product you were looking for.</div>
				<?php
					} ?>
				<?php
				if ($foundProduct){
					$similar_products = $mysql_link->query("SELECT * FROM products WHERE _product_style LIKE '%$_product_style%' AND '$_product_style' != products._product_style;");

					if ($similar_products->num_rows > 0) {
				 ?>

				<div class="panel panel-default">
					<div class="panel-heading">Similar Items:</div>
					<div class="list-group">
						<?php
							// output data of each row
							while($sim_prod = $similar_products->fetch_assoc()) {
								echo "<a data=\"".$sim_prod["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $sim_prod["id_product"] . "\"><span class=\"name\">". $sim_prod["_product_name"]. "</span> <span class=\"label label-info\">".$sim_prod["_product_style"]."</span></a>";
							}
						 ?>
					</div>
				</div>

				<?php } } ?>


				<?php
				if (isset($_GET['ptid'])) {
					$foundProduct_type = TRUE;
					$ptid = $_GET['ptid'];

					if ($ptid === "all") {
						$prod_cat_by_type = $mysql_link->query("SELECT * FROM products;");
					} else {
						$prod_cat_by_type = $mysql_link->query("SELECT * FROM products WHERE $ptid = products._product_primary_type;");
					}

					$catalog_title = $products_types_arr[$ptid];
				?>

				<div class="list-group">
					<?php
						if ($prod_cat_by_type->num_rows > 0) {
							// output data of each row
							while($row = $prod_cat_by_type->fetch_assoc()) {
								echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span class=\"label label-info\">".$row["_product_style"]."</span></a>";
							}
						} else {
							echo "<div class=\"alert alert-warning\">Sorry, couldn&apos;t find any items in the category you&apos;re browsing.</div>";
						}
					?>
				</div>

				<?php
				} else {
					if (!$foundProduct){
				?>
					<h1>Products</h1>
					<canvas id="productChart" width="400" height="400"></canvas>
					<div id="productChartLegend"></div>
				<?php 
					}
				}
				 ?>

				<?php
					if (isset($_GET['search'])) {

						$searchQuery = $_GET['search'];

						$prod_cat_by_type = $mysql_link->query("SELECT * FROM products WHERE $searchQuery = products._product_primary_type;");
				?>
				<div class="list-group">
					<?php
						if ($prod_cat_by_type->num_rows > 0) {
							// output data of each row
							while($row = $prod_cat_by_type->fetch_assoc()) {
								echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span class=\"label label-info\">".$row["_product_style"]."</span></a>";
							}
						} else {
							echo "<a>Sorry, couldn&apos;t find any categories, you should add one.</a>";
						}
					?>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-4 col-md-pull-8">
				<ul class="list-group">
				<?php
				$pr_int = 0;
				if ($product_types->num_rows > 0) {
					// output data of each row
					while($product_type = $product_types->fetch_assoc()) {
						if ($ptid == $product_type["id"]) {
							$itemClass = "active";
						} else {
							$itemClass = "";
						}

						if ($pr_int != 0) {
							$products_types_arr .= ",{id:".$product_type["id"].",color:\"#F7464A\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
						} else {
							$products_types_arr .= "{id:".$product_type["id"].",color:\"#335599\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
						}

						$pr_int = $pr_int+1;

						echo "<a data=\"id:".$product_type["id"]."\" class=\"list-group-item ". $itemClass ."\" href=\"index.php?ptid=" . $product_type["id"] . "\"><span class=\"name\">". $product_type["proper_name"] . "</span> <span class=\"badge\">".$product_type["prodCount"]."</span></a>";
					}
				} else {
					echo "<a class=\"list-group-item \">Sorry, couldn&apos;t find any categories, you should add one.</a>";
				}
				?>

				</ul>
			</div>
		</div>

		</div>
	</div>
</div>
<?php
	$mysql_link->close();
	$charts = TRUE;
	include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){
	var ctx = $("#productChart").get(0).getContext("2d");

	var product_types = <?php echo $products_types_arr; ?>];

	var options = {
		//Boolean - Whether we should show a stroke on each segment
		segmentShowStroke : true,

		//String - The colour of each segment stroke
		segmentStrokeColor : "#FFF",

		//Number - The width of each segment stroke
		segmentStrokeWidth: 1,

		//Number - The percentage of the chart that we cut out of the middle
		percentageInnerCutout: 80, // This is 0 for Pie charts

		responsive: true,

		//Number - Amount of animation steps
		animationSteps : 100,

		//String - Animation easing effect
		animationEasing : "easeOutBounce",

		//Boolean - Whether we animate the rotation of the Doughnut
		animateRotate : true,

		//Boolean - Whether we animate scaling the Doughnut from the centre
		animateScale : false,

		//String - A legend template
		legendTemplate : "<ul class=\"list-group <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li class=\"list-group-item\"><span class=\"badge\" style=\"background-color:<%=segments[i].fillColor%>\"><%=segments[i].value%></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

		};

	var productChart = new Chart(ctx).Pie(product_types,options);

	console.log(productChart.generateLegend());

	$('#productChartLegend').html(productChart.generateLegend());

	var addCategoryForm = $('#addProdCategory');
	$('#prod_description').wysiwyg();

	new ajaxifyForm(
		addCategoryForm,
		function (form,data) {
			var data = data;
		},
		true //clear form
	);
});
</script>