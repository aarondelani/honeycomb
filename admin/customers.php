<?php
	// Need page preferences here
	$page_short_title = "Customers";
	$page_title = $page_short_title;
	$customer_page_active = TRUE;

	$show_all = FALSE;

	if (isset($_GET["ass"])) {
		$show_all = TRUE;
	}

	include 'vars.php';
	include 'headers.php';

	include '../navigation.php';

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
?>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<?php
			include 'customer_navigation.php';

			if ($show_all) {
			?>
			<table id="customer_table" class="table blues">
				<thead>
					<tr>
						<th>Customer</th>
						<th>Contact First Name</th>
						<th>Contact Last Name</th>
						<th>Contact Email</th>
					</tr>
				</thead>
				<?php
					$customers_table = $paradox_mysql_link->query("SELECT * from customers;");

					if ($customers_table->num_rows > 0) {
						// output data of each row
						while($row = $customers_table->fetch_assoc()) {
							echo "<tr><td>" . $row["cust_name"]. "</td><td>". $row["cust_cont_firstname"]. "</td><td>". $row["cust_cont_lastname"]. "</td><td>" . $row["cust_cont_email"] . "</td></tr>";
						}
					} else {
						echo "<tr><td colspan=\"100%\" class=\"empty-row\">0 results</td></tr>";
					}
				?>
			</table>
			<?php } ?>

		<!-- End Content Div -->
	</div>

</div>

<?php

$paradox_mysql_link->close();
$dataTables = TRUE;
include '../admin/footer.php';

?>
<script type="text/javascript">
$(document).ready(function(){
	var customer_table = $('#customer_table').DataTable({
		"pageLength": 25,
		"search": {
			"regex": true,
			"smart": true,
		}
	});
});
</script>
