<?php
	// Need page preferences here

	include '../admin/vars.php';
	include '../admin/headers.php';

	$page_title = "Products";

	$ptid = NULL;

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$product_types = $mysql_link->query("SELECT * from product_types;");
	$searching = FALSE;

	$autocomplete = TRUE;
	$charts = TRUE;

	$products_types_arr = "[";

	$products = $mysql_link->query("SELECT id_product, _product_style, _product_name FROM products;");

	$productsList = "";

	if ($products->num_rows > 0) {
		// output data of each row
		while($product = $products->fetch_assoc()) {
			// print_r($product);

			$productsList .= "{id: \"" . mysql_escape_string($product["id_product"]) . "\", name: \"" . mysql_escape_string($product["_product_style"]) . " " . mysql_escape_string($product["_product_name"]) . "\", styleNumber: \"" . mysql_escape_string($product["_product_style"]) . "\"},";
		}
	}

	if (isset($_GET['id']) || isset($_GET['style'])) {
		if (isset($_GET['style'])) {
			$style = "`".mysql_real_escape_string($_GET['style'])."`";
			$product = $mysql_link->query("SELECT * from products where (_product_style = $style) LIMIT 1;");
		}

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$product = $mysql_link->query("SELECT * from products where (id_product = $id) LIMIT 1;");
		}

		$foundProduct = TRUE;
		$id_product = NULL;
		$_product_style = NULL;
		$_product_name = NULL;
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

	$product_page_active = TRUE;
	$body_class .= " product-page";
	// $bootstrapWYSIWYG = TRUE;

	include '../navigation.php';
?>
<div id="wrapper">
	<div id="content" class="container" role="main">
	<nav class="navbar navbar-default product-navbar">
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
				<!-- <li><a href="manage"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a></li>
				<li><a href="manage"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li> -->
				<?php
				$pr_int = 0;
				if ($product_types->num_rows > 0) {
					// output data of each row
					while($product_type = $product_types->fetch_assoc()) {
						if ($ptid == $product_type["id"]) {
							$itemClass = " class=\"active\"";

							$catalog_title = $product_type["proper_name"];
						} else {
							$itemClass = "";
						}

						$chart_color = $product_type["chart_color"];
						if ($charts) {
							if ($pr_int != 0) {
								$products_types_arr .= ",{id:".$product_type["id"].",color:\"".$chart_color."\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
							} else {
								$products_types_arr .= "{id:".$product_type["id"].",color:\"".$chart_color."\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
							}
						}

						$pr_int = $pr_int+1;

						echo "<li". $itemClass ."><a data=\"id:".$product_type["id"]."\" href=\"index.php?ptid=" . $product_type["id"] . "\"><span class=\"name\">". $product_type["proper_name"] . "</span> <span class=\"badge\">".$product_type["prodCount"]."</span></a></li>";
					}
				} else {

				}
					echo $row["chart_color"];
				?>

				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> Manage <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><a href="#">Categores</a></li>
					<li><a href="#">Products</a></li>
					<li><a href="#">Product Attributes</a></li>
					<li class="divider"></li>
					<li><a href="#"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
				  </ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right" action="index.php" method="get" name="id" id="searchProducts" role="search">
				<div class="form-group">
					<div class="input-group">
						<input type="text" id="search_products" autocomplete="off" class="form-control" name="search" placeholder="Search" value="<?php echo $searchValue; ?>">
						<!-- <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span> -->
						<span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Submit</span></button></span>
					</div>
				</div>
			</form>
		</div>
	</nav>
		<div class="catalog-wrapper">
			<?php
				if ($foundProduct) { ?>
					<div class="panel panel-default product-info">
						<div class="panel-heading">
							<h2 class="heading"><?php echo $_product_name; ?> <small style="background: <?php echo $primary_type_color; ?>" class="label label-primary">Style: <?php echo $_product_style; ?></small></h2>
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

							<div class="list-group">
								<?php
									$materials = $mysql_link->query("SELECT * FROM _product_attr_library WHERE _product_type = $ptid and _prod_attr_option = 0;");

									// print_r($materials);
									if ($materials->num_rows > 0) {
										// output data of each row
										while($material = $materials->fetch_assoc()) {
											// print_r($product);

											echo "<div class=\"list-group-item\" data=\"" . mysql_escape_string($material["id"]) . "\">" . mysql_escape_string($material["name"]). mysql_escape_string($material["val"]) . "</div>";
										}
									}

									$product_attr_options = $mysql_link->query("SELECT * FROM _prod_attributes_options WHERE _product_type = $ptid and _prod_attr_option = 0;");

									if ($product_attr_options->num_rows > 0) {
										// output data of each row
										while($options = $product_attr_options->fetch_assoc()) {
											// print_r($product);

											echo "<div class=\"list-group-item\" data=\"" . mysql_escape_string($material["id"]) . "\">" . mysql_escape_string($material["name"]). mysql_escape_string($material["val"]) . "</div>";
										}
									}
								?>
							</div>
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
								echo "<a data=\"".$sim_prod["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $sim_prod["id_product"] . "\"><span class=\"name\">". $sim_prod["_product_name"]. "</span> <span  style=\"background-color: " . $row["primary_type_color"] . ";\" class=\"label label-info\">".$sim_prod["_product_style"]."</span></a>";
							}
						 ?>
					</div>
				</div>

				<?php } } ?>


				<?php
				if ($foundProduct_type || $searching) {
					$query = NULL;

					if ($ptid === "all") {
						$query .= "SELECT * FROM products;";

						$catalog_title = "Showing All Products";
					} else {
						$query .="SELECT * FROM products WHERE $ptid = products._product_primary_type;";
					}

					if ($searching) {
						$catalog_title = "Searching for: " . $searchValue;

						$query = "SELECT id_product, _product_style, _product_name, _description, primary_type_color, product_primary_type_name FROM products WHERE _product_style $searchQuery OR _product_name $searchQuery OR _description $searchQuery;";
					}

					$prod_cat_by_type = $mysql_link->query($query);
				?>

				<h1><?php echo $catalog_title; ?></h1>

				<div class="list-group">
					<?php
						if ($prod_cat_by_type->num_rows > 0) {
							// output data of each row
							while($row = $prod_cat_by_type->fetch_assoc()) {

								$label = $row["_product_style"];

								if ($searching) {
									$label = $row["product_primary_type_name"] . ": Style " . $label;
								}

								echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span style=\"background-color: " . $row["primary_type_color"] . ";\" class=\"label label-info\">".$label."</span></a>";
							}
						} else {
							echo "<div class=\"alert alert-warning\">Sorry, couldn&apos;t find any items in the query you&apos;re browsing.</div>";
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
						<div id="productChartLegend"></div>
						<p>Here&apos;s a quick view of our product statistics.</p>
					</div>
					<div class="col-md-6">
						<h3>Product Chart</h3>
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
</div>
<?php
	$mysql_link->close();
	include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){

		var productChart = $("#productChart");

		if (productChart.length > 0) {
			var ctx = productChart.get(0).getContext("2d");

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

				// responsive: true,

				//Number - Amount of animation steps
				animationSteps : 100,

				//String - Animation easing effect
				animationEasing : "easeOutBounce",

				//Boolean - Whether we animate the rotation of the Doughnut
				animateRotate : true,

				//Boolean - Whether we animate scaling the Doughnut from the centre
				animateScale : false,

				//String - A legend template
				legendTemplate : "<div class=\"list-group <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><a href=\"<%=segments[i].id%>\" class=\"list-group-item\"><span class=\"badge\" style=\"background-color:<%=segments[i].fillColor%>\"><%=segments[i].value%></span><%if(segments[i].label){%><%=segments[i].label%><%}%></a><%}%></div>"

				};

			var productChart = new Chart(ctx).Pie(product_types,options);

			console.log(productChart);

			$('#productChartLegend').html(productChart.generateLegend());
		}

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
	// $('#prod_description').wysiwyg();

	new ajaxifyForm(
		addCategoryForm,
		function (form,data) {
			var data = data;
		},
		true //clear form
	);
});
</script>