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
	<form class="navbar-form navbar-right" action="index.php" method="get" name="id" id="searchProducts" role="search">
			<div class="form-group">
				<div class="input-group">
					<input type="text" id="search_products" autocomplete="off" class="form-control" name="search" placeholder="Search for a Product" value="<?php echo $searchValue; ?>">
					<!-- <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span> -->
					<span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Submit</span></button></span>
				</div>
			</div>
		</form>
		<ul class="nav navbar-nav">
			<?php
				$products_types_arr = "[";
				$pr_int = 0;
				if ($product_types->num_rows > 0) {
					// output data of each row
					while($product_type = $product_types->fetch_assoc()) {
						$chart_color = $product_type["chart_color"];

						if ($ptid == $product_type["id"]) {
							$itemClass = " class=\"active\"";

							$catalog_title = $product_type["proper_name"];
						} else {
							$itemClass = "";
						}

						if ($charts) {
							if ($pr_int != 0) {
								$products_types_arr .= ",{id:".$product_type["id"].",color:\"".$chart_color."\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
							} else {
								$products_types_arr .= "{id:".$product_type["id"].",color:\"".$chart_color."\", label:\"".$product_type["proper_name"]."\", value:".$product_type["prodCount"]."}";
							}
						}

						$pr_int = $pr_int + 1;

						echo "<li". $itemClass ."><a data=\"id:".$product_type["id"]."\" href=\"index.php?ptid=" . $product_type["id"] . "\"><span class=\"name\">". $product_type["proper_name"] . "</span> <span class=\"badge\" style=\"background-color: $chart_color\">".$product_type["prodCount"]."</span></a></li>";
					}
				}
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
	</div>
</nav>