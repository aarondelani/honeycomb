<?php
	// Need page preferences here

	$home_page_active = TRUE;
	$autocomplete = TRUE;

	include 'admin/vars.php';

	include 'admin/headers.php';

	include 'navigation.php';

	$productCount = $mysql_link->query("SELECT id_product, _product_style, _product_name FROM products;");
?>
<div id="wrapper">
	<div id="content" class="container" role="main">
		<div id="welcome" class="jumbotron">
			<img src="images/honeycomb-ico-grad.svg" alt="Honey Comb Icon" class="honeycomb-icon">
			<h1>Welcome <?php echo ucfirst($_SESSION["username"]);?>,</h1>
			<p>Honeycomb is an experimental lab...</p>
			<a class="btn btn-lg btn-primary" href="about.php">Learn More</a>
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