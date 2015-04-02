<nav class="navbar navbar-default product-navbar">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo $host; ?>/product">Inventory</a>
	</div>

	<div class="collapse navbar-collapse" id="client_bar">
	<ul class="nav navbar-nav">
		<li role="presentation" <?php if ($lji_rack_page) {echo " class=\"active\"";} ?>><a href="?rep=rack">LJI Rack Report</a></li>
		<li role="presentation" <?php if ($closeout_page) {echo " class=\"active\"";} ?>><a href="?rep=close">Closeout Report</a></li>
	</ul>
		<form class="navbar-form navbar-right" action="index.php" method="get" name="id" id="searchProducts" role="search">
			<div class="form-group">
				<a href="print.php?rep=<?php echo $_GET["rep"]; ?>" class="btn btn-default" target="_blank" data-toggle="tooltip" data-placement="bottom" title="This will print the Short Sleeve / Long Sleeve <?php echo $current_page; ?> Catalog"><span class="glyphicon glyphicon-print"></span> Print Catalog</a></span>
			</div>
		</form>
	</div>
</nav>