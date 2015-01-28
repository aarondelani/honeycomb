<!DOCTYPE html>
<?php
	// Need page preferences here

	$home_page_active = TRUE;

	include 'admin/headers.php';
	include 'admin/vars.php';

	include 'navigation.php';
?>
<div id="welcome">
	<div class="container">
		<div class="jumbotron">
			<h1><img src="images/honeycomb-logo-line-wht.svg" alt="Honeycomb Logo"><span class="sr-only">Honeycomb</span></h1>
			<p>The customer relationship management app</p>
		</div>
	</div>
</div>
<div id="wrapper">
	<div id="content" class="container" role="main">
		<div class="row">
			<div class="col-md-8">
				<h2>Welcome</h2>
				<p>Thanks for taking a look at Honeycomb. It&apos;s currently still in development. So don&apos;t be surprised if a few things break.</p>
				<h3>Features:</h3>
				<ul>
					<li>Coolcat Integration for Viewing Customer List</li>
					<li>Compare a CSV to current Customer Database (Coolcat)</li>
					<li>Mobile Web App ready</li>
				</ul>
				<h3>Upcoming Features:</h3>
				<ul>
					<li>Customer Company Hierarchy Table (to be used for any queries related to our customers) <br> This will improve sales, inventory, and updates with our customers.</li>
					<li>Customer Contact List</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4>Requests:</h4>
				<p>If you have any feature requests, please let <a href="mailto:aaron@lesliejordan.com">Aaron Delani</a> know.</p>
			</div>
		</div>
	</div>
</div>

<?php include 'admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
	var subUser = $('#submitUser'),
		addUserBtn = $('#addUserBtn');

	new ajaxifyForm(
		subUser,
		function (form,data) {
			var data = data;

			new buildRow(
				form,
				[data.first_name, data.last_name, data.e_mail, data.phone_1],
				$("#user_table")
			);
		},
		true //clear form
	);
});
</script>