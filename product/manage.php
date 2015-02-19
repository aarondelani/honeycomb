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

						<!-- <nav class="navbar anti-aliased navbar-default" data-role="editor-toolbar" data-target="#prod_description">
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="glyphicon glyphicon-font"></i><b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li>
								</ul>
							</div>
							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="glyphicon glyphicon-text-height"></i> <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
									<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
									<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
								</ul>
							</div>
							<div class="btn-group">
								<a class="btn btn-default" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><stong style="font-weight: bold">B</stong></a>
								<a class="btn btn-default" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="glyphicon glyphicon-italic"></i></a>
								<a class="btn btn-default" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough" style="text-decoration: line-through">S</i></a>
								<a class="btn btn-default" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline" style="text-decoration: underline">U</i></a>
							</div>
							<div class="btn-group">
								<a class="btn btn-default" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="glyphicon glyphicon-list"></i></a>
								<a class="btn btn-default" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="glyphicon glyphicon-list-ul"></i></a>
								<a class="btn btn-default" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="glyphicon glyphicon-indent-left"></i></a>
								<a class="btn btn-default" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="glyphicon glyphicon-indent-right"></i></a>
							</div>

							<div class="btn-group">
								<a class="btn btn-default btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="glyphicon glyphicon-align-left"></i></a>
								<a class="btn btn-default" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="glyphicon glyphicon-align-center"></i></a>
								<a class="btn btn-default" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="glyphicon glyphicon-align-right"></i></a>
								<a class="btn btn-default" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="glyphicon glyphicon-align-justify"></i></a>
							</div>

							<div class="btn-group">
								<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="glyphicon glyphicon-link"></i></a>
								<div class="dropdown-menu input-append">
									<input class="span2 form-control" placeholder="URL" type="text" data-edit="createLink">
									<button class="btn btn-primary" type="button">Add</button>
								</div>
								<a class="btn btn-default" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="glyphicon glyphicon-scissors"></i></a>
							</div>

							<div class="btn-group">
								<a class="btn btn-default" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="glyphicon glyphicon-picture"></i></a>
								<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 36px; height: 30px;">
							</div>

							<div class="btn-group">
								<a class="btn btn-default" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
								<a class="btn btn-default" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
							</div>
							<input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none;">
						</nav> -->
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