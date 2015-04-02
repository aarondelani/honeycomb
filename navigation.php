<nav class="navbar navbar-fixed-top" id="navigation">
  <div class="container-fluid">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="<?php echo "$host";?>">
	  	<img id="honeycomb_icon" src="<?php echo "$host";?>/images/honeycomb-ico-grad.svg" alt="Honeycomb Icon" height="20" width="20">
	  </a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li class="<?php if ($home_page_active) {echo " active";} ?>"><a href="<?php echo "$host"; ?>">Home</a></li>
			<li class="<?php if ($order_page_active) {echo " active";} ?>"><a href="<?php echo "$host"; ?>/orders">Orders</a></li>
			<li class="<?php if ($inventory_page_active) {echo " active";} ?>"><a href="<?php echo "$host"; ?>/inventory">Inventory</a></li>
			<li class="dropdown<?php if ($customer_page_active||$import_customer_page_active) {echo " active";} ?>">
				<a href="<?php echo "$host"; ?>/admin/customers" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Customers<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo "$host"; ?>/admin/customers">View Customer List</a></li>
					<li class="divider"></li>
					<li class="dropdown-header">Tools</li>
					<li><a href="<?php echo "$host"; ?>/admin/add">Add Contact or Customer</a></li>
					<li><a href="<?php echo "$host"; ?>/admin/import_customers">Import and Compare Customer Lists</a></li>
				</ul>
			</li>
			<li class="<?php if ($product_page_active) {echo " active";} ?>"><a href="<?php echo "$host"; ?>/product">Product Catalog</a></li>
		</ul>
		<div class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="<?php echo "$host"; ?>/user" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo ucfirst($_SESSION["username"]); ?> <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo "$host"; ?>/user">Account</a></li>
					<li class="divider"></li>
					<li>
						<form action="<?php echo $host ?>/core/login_reqs.php" method="POST" id="log_out_form">
							<input type="hidden" name="log_out" value="TRUE">
							<button id="logOutButton" class="btn btn-default form-controls" type="submit" name="log_out" value="Log Out"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> <span class="">Log Out</span></button>
						</form>
					</li>
				</ul>
			</li>
		</div>
	</div>
  </div>
</nav>