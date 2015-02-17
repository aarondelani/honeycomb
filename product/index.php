<?php
	// Need page preferences here

	$product_page_active = TRUE;
	$body_class .= " product-page";
	$bootstrapWYSIWYG = TRUE;

	include '../admin/headers.php';
	include '../admin/vars.php';

	include '../navigation.php';
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
			<div class="catalog-header">
				<h2>Product Catalog</h2>
			</div>
			<div class="product-list list-group">
			<?php
				$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

				$product_types = $mysql_link->query("SELECT * from product_types;");

				if ($product_types->num_rows > 0) {
					// output data of each row
					while($product_type = $product_types->fetch_assoc()) {
						echo "<a data=\"id:".$product_type["_product_primary_type"]."\" class=\"list-group-item\" href=\"index.php?ptid=" . $product_type["id"] . "\"><span class=\"name\">". $product_type["proper_name"]. "</span> <span class=\"label label-default\">".$product_type["prodCount"]."</span></a>";
					}
				} else {
					echo "<a>Sorry, couldn&apos;t find any categories, you should add one.</a>";
				}

				// $catalog_table = $mysql_link->query("SELECT * from products;");

				// if ($catalog_table->num_rows > 0) {
				// 	// output data of each row
				// 	while($row = $catalog_table->fetch_assoc()) {
				// 		echo "<a data=\"".$row["_product_primary_type"]."\" class=\"list-group-item\" href=\"product.php?id=" . $row["id_product"] . "\"><span class=\"name\">". $row["_product_name"]. "</span> <span class=\"label label-default\">".$row["product_primary_type_name"]."</span></a>";
				// 	}
				// } else {
				// 	echo "<a>Sorry, couldn&apos;t find any categories, you should add one.</a>";
				// }

				$mysql_link->close();
			?>
			</div>
		</div>
	</div>
</div>

<?php include '../admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
	var addCategoryForm = $('#addProdCategory');
	$('#prod_description').wysiwyg();
	var nodeObj = $('');

	console.log($('#honeycomb_icon').offset().top);

	new ajaxifyForm(
		addCategoryForm,
		function (form,data) {
			var data = data;
		},
		true //clear form
	);
});
</script>