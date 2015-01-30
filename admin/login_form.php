<?php if (!$loggedIn) { ?>

<form id="login_form" action="core/login_reqs.php" method="post" name="login">
	<input type="hidden" name="login_process" value="true">
	<input class="form-control" required type="text" name="username" placeholder="Username">
	<input class="form-control" required type="password" name="password" placeholder="Password">
	<input type="Submit" class="btn btn-primary" value="Login">
</form>

<?php } ?>