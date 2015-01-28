<nav class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="customers">Customers</a>
	</div>

	<div class="collapse navbar-collapse" id="client_bar">
		<ul class="nav navbar-nav">
			<li<?php if ($add_customer_page_active) {echo " class=\"active\"";} ?>><a href="add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add A Customer</a></li>
			<li<?php if ($import_customer_page_active) {echo " class=\"active\"";} ?>><a href="import_customers"><span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Import Customers (CSV)</a></li>
		</ul>
	</div>
</nav>