<?php
	// Need page preferences here

	$home_page_active = TRUE;
	$login_page = TRUE;

	include 'admin/vars.php';

	$page_title = "Login to Honeycomb";
	$body_class = " login_page";

	include 'admin/headers.php';
?>

<!DOCTYPE html>

<div id="welcome">
	<div class="container">
		<div class="jumbotron">
			<h1><img src="images/honeycomb-ico-grad.svg" alt="Honeycomb Logo" width="200" height="200"><span class="sr-only">Honeycomb</span></h1>
			<p><img src="images/honeycomb-wordmark-wht.svg" alt="Honeycomb Wordmark" width="200" height="auto"></p>

			<?php if (!$loggedIn) { ?>

			<form id="login_form" action="core/login_reqs.php" method="post" name="login">
				<?php if ($_SESSION['login_tries'] > 0) { ?>
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						Whoops, you&apos;ve tried to log in
						<?php
							if ($_SESSION['login_tries'] == 1) {
								echo "twice";
							} else {
								echo $_SESSION['login_tries'] + 1 . " times";
							}
						?>
						... and still couldn&apos;t log in. Please check your credentials, or ask IT for help.
					</div>
				<?php } ?>
				<input type="hidden" name="redirurl" value="<?php echo $_SERVER['url']; ?>" />
				<input type="hidden" name="login_process" value="true">
				<input class="form-control" required type="text" name="username" placeholder="Username">
				<input class="form-control" required type="password" name="password" placeholder="Password">
				<input type="Submit" class="btn btn-primary" value="Login">
			</form>

			<?php } else { header("Location: index.php"); } ?>

		</div>
	</div>
</div>

<?php include 'admin/footer.php'; ?>
