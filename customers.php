<!DOCTYPE html>
<?php
	// Need page preferences here

	include 'admin/headers.php';
	include 'admin/vars.php';
	include 'navigation.php';
?>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<h1 class="hidden-accessible sr-only">Customers</h1>

		<nav class="navbar navbar-default" id="client_bar">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="customers.php">Customers</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">Add Customer</a></li>
				<li><a href="#">Link</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tools <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Import</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- <form class="client-search" role="search">
			<input id="search_customer_table_input" type="text" class="form-control" aria-label="Seach customers and contacts" placeholder="Search customers and contacts...">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default">Search</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
				</ul>
				</div>
			</div>
		</form> -->

<?php
$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// if (isset($_POST['submit'])){

	// if ($_POST['update_user']=='add') {
	// 	$first_name = $_POST['first_name'];
	// 	$last_name = $_POST['last_name'];
	// 	$email = $_POST['e_mail'];
	// 	$phone_1 = $_POST['phone_1'];

	// 	$sql = "INSERT INTO users_table (first_name, last_name, email, phone_number) VALUES ('$first_name','$last_name','$email','$phone_1');";
	// }

	// $mysql_link->query($sql);

	// $result = $mysql_link->query("SELECT * from users_table;");

	// Perform Query
	if ($sql) {
		if ($paradox_mysql_link->query($sql) === TRUE) {
		    echo "New record created successfully ". $result;
		} else {
			die('Error: ' . mysqli_error($paradox_mysql_link) . mysql_affected_rows());
		    echo "Error: " . $sql . "<br>" . $paradox_mysql_link->error;
		}
	}

	// Perform Multiple Queries
	if ($multi_sql) {
		if (mysqli_multi_query($paradox_mysql_link, $multi_sql)){
			do {
				/* store first result set */
				if ($result = mysqli_store_result($paradox_mysql_link)) {
					while ($row = mysqli_fetch_row($result)) {
						// printf("%s\n", $row[0]);
					}

					mysqli_free_result($result);
				}
				/* print divider */
				if (mysqli_more_results($paradox_mysql_link)) {
					// printf("-----------------\n");
				}
			} while (mysqli_next_result($paradox_mysql_link));
		}
	}
}

?>

		<table id="customer_table" class="table blues">
			<thead>
				<tr>
					<!-- <th>#</th> -->
					<th>Customer</th>
					<th>Contact First Name</th>
					<th>Contact Last Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<!-- <th>User Assets</th>
					<th>User Roles</th> -->
				</tr>
			</thead>
			<?php
				$customers_table = $paradox_mysql_link->query("SELECT * from customers;");

				if ($customers_table->num_rows > 0) {
					// output data of each row
					while($row = $customers_table->fetch_assoc()) {
						echo "<tr><td>" . $row["cust_name"]. "</td><td>". $row["cust_cont_firstname"]. "</td><td>". $row["cust_cont_lastname"]. "</td><td>" . $row["cust_phone1"]. "</td><td>" . $row["cust_address1"]. "</td><td>" . $row["cust_city"]. "</td><td>" . $row["cust_state"]. "</td></tr>";
					}
				} else {
					echo "<tr><td colspan=\"100%\" class=\"empty-row\">0 results</td></tr>";
				}
			?>
		</table>

	<!-- End Content Div -->
	</div>

</div>

<?php

$mysql_link->close();
include 'admin/footer.php';

?>

<script type="text/javascript">
$(document).ready(function(){
	var customer_table = $('#customer_table').DataTable({
			"search": {
				"regex": true,
				"smart": true
			}
	});
	// 	search_input = $('#search_customer_table_input');

	// $(search_input).on(
	// 	'key-up',
	// 	function (event) {
	// 		console.log($(event.currentTarget()).attr('value'));
	// 		// customer_table.search($(event.currentTarget()).attr('value'));
	// 	}
	// );


});
</script>