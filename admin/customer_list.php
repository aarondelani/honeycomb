<?php
	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

	$customers_table = $paradox_mysql_link->query("SELECT * from customers;");

	if ($customers_table->num_rows > 0) {
		// output data of each row
		while($row = $customers_table->fetch_assoc()) {
			echo "<tr><td>" . $row["cust_name"]. "</td><td>". $row["cust_cont_firstname"]. "</td><td>". $row["cust_cont_lastname"]. "</td><td>" . $row["cust_cont_email"] . "</td></tr>";
		}
	} else {
		echo "<tr><td colspan=\"100%\" class=\"empty-row\">0 results</td></tr>";
	}

	$paradox_mysql_link->close();
?>