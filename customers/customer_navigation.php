<nav class="navbar navbar-default anti-aliased">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">Customers</a>
	</div>

	<div class="collapse navbar-collapse" id="client_bar">
		<form class="navbar-form navbar-right" action="index.php" method="get" name="id" id="searchCustomers" role="search">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" id="company_name_input" name="company_name" placeholder="Search for Company">
					<!-- <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span> -->
					<span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Submit</span></button></span>
				</div>
			</div>
		</form>

		<ul class="nav navbar-nav">
			<li<?php if ($lead_page_active) {echo " class=\"active\"";} ?>><a href="leads.php"><span class="fa fa-compass" aria-hidden="true"></span> Leads</a></li>
			<li<?php if ($show_all) {echo " class=\"active\"";} ?>><a href="index.php?q=all"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Customer List</a></li>
			<li<?php if ($add_customer_page_active) {echo " class=\"active\"";} ?>><a href="add.php"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add A Customer</a></li>
			<li<?php if ($import_customer_page_active) {echo " class=\"active\"";} ?>><a href="import_customers.php"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Import Customers (CSV)</a></li>
		</ul>
	</div>
</nav>