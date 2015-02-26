<?php
	// Need page preferences here

	$home_page_active = TRUE;
	$autocomplete = TRUE;

	include 'admin/vars.php';

	include 'admin/headers.php';

	include 'navigation.php';
?>
<div id="wrapper">
	<div id="content" class="container" role="main">
		<h1>Hey <?php echo ucfirst($_SESSION["username"]);?>,</h1>
		<p>Here&apos;s what&apos;s been going on:</p>
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