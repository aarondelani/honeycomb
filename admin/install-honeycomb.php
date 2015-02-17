<?php

$setup_config = "CREATE TABLE setup_config (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	attribute VARCHAR(30) NOT NULL,
	value VARCHAR(30) NOT NULL,
	reg_date TIMESTAMP
);";

// $mysql_link->query($setupUsers);

$setup_config .= $installQ;

if (mysqli_multi_query($mysql_link, $setup_config)){
	do {
		/* store first result set */
		if ($result = mysqli_store_result($mysql_link)) {
			while ($row = mysqli_fetch_row($result)) {
				printf("%s\n", $row[0]);
			}
			mysqli_free_result($result);
		}
		/* print divider */
		if (mysqli_more_results($mysql_link)) {
			printf("Created");
		}
	} while (mysqli_next_result($mysql_link));
}

?>