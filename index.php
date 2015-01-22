<!DOCTYPE html>
<?php
	// Need page preferences here

	include 'admin/headers.php';
?>

<div id="wrapper" class="container theme-showcase" role="main">

<form name="submitUser" method="POST" action="admin/config.php" id="submitUser">
	<fieldset>
		<legend>Name:</legend>
		<div class="input-group">
			<label class="input-group-addon" for="first_name">First Name:</label><input type="text" name="first_name" placeholder="First Name" value="" class="form-control">
		</div>
		<div class="input-group">
			<label class="input-group-addon" for="last_name">Last Name:</label><input type="text" name="last_name" placeholder="Last Name" value="" class="form-control">
		</div>
	</fieldset>
	<fieldset>
		<legend>Contact Information:</legend>
		<div class="input-group">
			<label class="input-group-addon" for="email">Email:</label><input type="text" name="e_mail" placeholder="your@email-address.com" class="form-control">
		</div>
		<div class="input-group">
			<label class="input-group-addon" for="phone_1">Mobile Phone Number:</label><input name="phone_1" type="number" class="form-control">
		</div>
	</fieldset>
	<input class="btn btn-primary" type="submit" name="submit" value="Add Entry">
</form>

<table class="table greens">
	<thead>
		<tr>
			<th>#</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone Number</th>
			<th>Fax</th>
			<th>User Assets</th>
			<th>User Roles</th>
		</tr>
	</thead>
	<?php
		if ($users_table->num_rows > 0) {
		    // output data of each row
		    while($row = $users_table->fetch_assoc()) {
		        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone_number"]. "</td><td>" . $row["fax_number"]. "</td><td>" . $row["user_assets"]."</td><td>" . $row["user_roles"].   "</td></tr>";
		    }
		} else {
		    echo "<tr><td colspan=\"100%\">0 results</td></tr>";
		}
	?>
</table>
</div>
<script type="text/javascript">
    var frm = $('#submitUser');
    // frm.submit(
    // 	function (event) {
    // 	form_data = frm.serialize();
    //     $.ajax({
    //         type: frm.attr('method'),
    //         url: frm.attr('action'),
    //         data: form_data,
    //         dataType: 'text',
    //         processData: false,
    //         contentType: 'application/x-www-form-urlencoded',
    //         success: function (data) {
		  //       console.log(data);
    //             // alert('ok');
    //         }
    //     });
	   //  return false; // avoid to execute the actual submit of the form.
    // });

	frm.submit(
		function (event) {
			$.post(
				frm.attr('action'),
				frm.serialize(),
				function (data, textStatus, jQxhr) {
					// body...
				},
				'text'
			)

			return false;
		}
	);

// $('#submitUser').submit(
// 	function (event) {
// 		var url = "admin/config.php";

// 		$.ajax({
// 			type: "POST",
// 			url: url,
// 			data: $("#submitUser").serialize(), // serializes the form's elements.
//            success: function(data)
// 			{
// 				alert(data); // show response from the php script.
//            }
//          });

// 	    return false; // avoid to execute the actual submit of the form.
// 	}
// )
</script>
<?php
	include 'admin/footer.php';
?>