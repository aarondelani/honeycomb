<?php

include_once 'config.php';
$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

$users_table = $mysql_link->query('SELECT * FROM `users_table`');

$mysql_link->close();

?>