<?php
	// Need page preferences here

	$page_short_title = "Add Customers";
	$page_title = $page_short_title;
	$customer_page_active = TRUE;
	$add_customer_page_active = TRUE;

	include '../admin/vars.php';
	include '../admin/headers.php';

	include '../navigation.php';
?>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<?php include 'customer_navigation.php' ?>

		<h1>Add Customer</h1>

		<p>(Functionality is still under construction)</p>

		<form name="submitUser" method="post" action="<?php echo $host; ?>/admin/reqs.php" id="submitUser">
			<input type="hidden" name="update_user" value="add_user">

			<fieldset>
				<legend>Name:</legend>

				<div class="input-group">
					<label class="input-group-addon" for="first_name">First Name:</label><input id="first_name" type="text" name="first_name" placeholder="First Name" value="" class="form-control" required>
				</div>
				<div class="input-group">
					<label class="input-group-addon" for="last_name">Last Name:</label><input id="last_name" type="text" name="last_name" placeholder="Last Name" value="" class="form-control">
				</div>
			</fieldset>
			<fieldset>
				<legend>Contact Information:</legend>

				<div class="input-group">
					<label class="input-group-addon" for="email">Email:</label><input id="email" type="email" name="e_mail" placeholder="your@email-address.com" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-group-addon" for="phone_1">Mobile Phone Number:</label><input id="phone_number" name="phone_1" type="tel" class="form-control">
				</div>
			</fieldset>

			<input class="btn btn-primary" id="addUserBtn" type="submit" name="submit" value="Add Entry">
		</form>

		<h2>List of Current Users</h2>

		<table id="user_table" class="table">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Phone Number</th>
				</tr>
			</thead>
			<?php
				if ($users_table->num_rows > 0) {
					// output data of each row
					while($row = $users_table->fetch_assoc()) {
						echo "<tr><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone_number"]. "</td></tr>";
					}
				} else {
					echo "<tr><td colspan=\"100%\" class=\"empty-row\">0 results</td></tr>";
				}
			?>
		</table>
	</div>
</div>

<?php include '../admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
	var subUser = $('#submitUser'),
		addUserBtn = $('#addUserBtn');

	new ajaxifyForm(
		subUser,
		function (form,data) {
			var data = data;
			console.log(data);

			new buildRow(
				form,
				[data.first_name, data.last_name, escape(data.e_mail), data.phone_1],
				$("#user_table")
			);
		},
		true //clear form
	);
});
</script>