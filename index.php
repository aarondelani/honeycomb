<!DOCTYPE html>
<?php
	// Need page preferences here

	include 'admin/headers.php';
	include 'admin/vars.php';

	include 'navigation.php';
?>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<h1>Welcome to Honeycomb</h1>
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