<?php
	// Need page preferences here

	$product_page_active = TRUE;
	$body_class .= " product-page";
	$bootstrapWYSIWYG = TRUE;

	include '../admin/headers.php';
	include '../admin/vars.php';

	include '../navigation.php';

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$product_types = $mysql_link->query("SELECT * from product_types;");
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
				<li><a href="add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a></li>
				<li><a href="manage"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
			</ul>
		</div>
	</nav>
		<div class="catalog-wrapper">
		<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-body" data="">
						<?php
						if (isset($_GET['id'])) {
							$foundProduct = TRUE;
							$id = $_GET['id'];

							$product = $mysql_link->query("SELECT * from products where (id_product = $id);");
							$product_attrs = $mysql_link->query("SELECT * from _prod_attrs where _prod_attrs._product_id = $id;");
							// $product = $mysql_link->query("SELECT * from products Left join (_prod_attrs) on (_prod_attrs._product_id = products.id_product) where products.id_product = $id;");

							if ($product->num_rows > 0) {
								// output data of each row
								while($row = $product->fetch_assoc()) {
									$id_product = $row["id_product"];
									$_product_style = $row["_product_style"];
									$_product_name = $row["_product_name"];
									$product_primary_type_name = $row["product_primary_type_name"];
									$_product_description = $row["_description"];
								}
							} else {
								$foundProduct = FALSE;
							}
						if ($foundProduct) { ?>
							<h2><?php echo $_product_name; ?></h2>

							<?php echo $_product_description; ?>
							<?php
								$attrs_images = array();
								if ($product_attrs->num_rows > 0) {
									// output data of each row
									while($attr = $product_attrs->fetch_assoc()) {
										echo "<li class=\"list-group-item\">".$attr["val"]."</li>";
									}
								} else {}
							 ?>

						<?php } else { ?>
							<div class="alert alert-danger" role="alert">Whoops, couldn&apos;t find the product you were looking for.</div>
						<?php
							}
						}
						// End GET PRODID
						?>
						<?php
						if (isset($_GET['ptid'])) {
							$foundProduct_type = TRUE;
							$ptid = $_GET['ptid'];

							$product_types = $mysql_link->query("SELECT * FROM products WHERE $ptid = products._product_primary_type;");

							if ($product_types->num_rows > 0) {
								// output data of each row
								while($row = $product_types->fetch_assoc()) {
									echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"product.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span class=\"label label-default\">".$row["product_primary_type_name"]."</span></a>";
								}
							} else {
								echo "<a>Sorry, couldn&apos;t find any categories, you should add one.</a>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<ul class="list-group">
				<?php
				if ($product_types->num_rows > 0) {
					// output data of each row
					while($product_type = $product_types->fetch_assoc()) {
						echo "<a data=\"id:".$product_type["_product_primary_type"]."\" class=\"list-group-item\" href=\"product.php?ptid=" . $product_type["id"] . "\"><span class=\"name\">". $product_type["proper_name"]. "</span> <span class=\"label label-default\">".$product_type["prodCount"]."</span></a>";
					}
				} else {
					echo "<a>Sorry, couldn&apos;t find any categories, you should add one.</a>";
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

include '../admin/footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){
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