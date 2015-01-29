<?php
	// Need page preferences here
	$page_short_title = "Customers";
	$page_title = $page_short_title;
	$customer_page_active = TRUE;

	include 'headers.php';
	include 'vars.php';

	include '../navigation.php';

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
?>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<h1 class="hidden-accessible sr-only">Customers</h1>

		<?php include 'customer_navigation.php' ?>

		<!-- End Content Div -->
	</div>

</div>

<?php

$paradox_mysql_link->close();

include 'footer.php';

?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>