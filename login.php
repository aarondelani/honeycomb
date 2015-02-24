<!DOCTYPE html>
<?php
	// Need page preferences here

	$home_page_active = TRUE;
	$login_page = TRUE;
	$page_title = "Login to Honeycomb";
	$body_class = " login_page";

	include 'admin/vars.php';
	include 'admin/headers.php';
?>
<div id="welcome">
	<div class="container">
		<div class="jumbotron">
			<h1><img src="images/honeycomb-ico-grad.svg" alt="Honeycomb Logo" width="200" height="200"><span class="sr-only">Honeycomb</span></h1>
			<p><img src="images/honeycomb-wordmark-wht.svg" alt="Honeycomb Wordmark" width="200" height="auto"></p>

			<?php include 'admin/login_form.php'; ?>
		</div>
	</div>
</div>

<?php include 'admin/footer.php'; ?>