<?php if (!$loggedIn) { ?>

<form id="login_form" action="core/login_reqs.php" method="post" name="login">
	<input type="hidden" name="redirurl" value="<?php echo $_SESSION['url']; ?>" />
	<input type="hidden" name="login_process" value="true">
	<input class="form-control" required type="text" name="username" placeholder="Username">
	<input class="form-control" required type="password" name="password" placeholder="Password">
	<input type="Submit" class="btn btn-primary" value="Login <?php echo $_SESSION['login_tries']; ?>">
	<?php if ($_SESSION['login_tries'] > 0) { ?>
		<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>Couldn&apos;t log you in. Please check your credentials.</div>
	<?php } ?>
</form>

<?php } ?>