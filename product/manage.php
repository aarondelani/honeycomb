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
				<li><a href="manage.php"><span class="glyphicon glyphicon-pencil"></span> Manage</a></li>
			</ul>
		</div>
	</nav>
		<div class="catalog-wrapper">
		<?php if (isset($_GET['add_product_type'])) { ?>
			<div class="panel panel-default" id="add_category">
				<div class="panel-heading"><h3 class="panel-title">Add Category</h3></div>
				<form class="panel-body" name="addProdCategory_form" method="post" action="<?php echo $host; ?>/admin/reqs.php" id="addProdCategory">
					<input type="hidden" name="addProdCategory" value="addProdCategory">
					<input id="categoryName" type="text" name="categoryName" placeholder="Category Name" value="" class="form-control" required>
					<input id="categoryDescription" type="text" name="categoryDescription" placeholder="Description" value="" class="form-control">

					<input class="btn btn-primary" id="addProdCatBtn" type="submit" name="submit" value="Add Category">
				</form>
			</div>
		<?php } ?>
			<div class="panel panel-default" id="add_product">
				<div class="panel-heading"><h3 class="panel-title">Add Product</h3></div>
				<form class="panel-body" name="addProd_form" method="post" action="<?php echo $host; ?>/admin/reqs.php" id="addProd">
					<input type="hidden" name="addProd" value="addProd">
					<input id="prod_name" type="text" name="prod_name" placeholder="Product Name" value="" class="form-control" required>
					<input id="prod_style" type="text" name="prod_style" placeholder="Product Style" value="" class="form-control">
					<input id="prod_material" type="text" name="prod_material" placeholder="Product Material" value="" class="form-control">
					<div id="prod_description" class="form-control">Product Description</div>

					<input class="btn btn-primary" id="addProdBtn" type="submit" name="submit" value="Add Product">
				</form>
			</div>
		</div>
	</div>
</div>

<?php include '../admin/footer.php'; ?>

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
