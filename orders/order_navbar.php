<nav class="navbar navbar-default product-navbar">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo $host; ?>/orders">Orders</a>
	</div>

	<div class="collapse navbar-collapse" id="client_bar">
		<ul class="nav navbar-nav">
			<?php echo $order_navs; ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="index.php?action=add_order" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add Order</a>
			</li>
			<li>
				<form class="navbar-form" action="index.php" method="get" name="id" id="searchProducts" role="search">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" name="style" placeholder="Search">

							<span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Submit</span></button></span>
						</div>
					</div>
				</form>
			</li>
		</ul>
	</div>
</nav>
