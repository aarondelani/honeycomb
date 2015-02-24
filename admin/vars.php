<?php

include_once 'config.php';

	echo $prefs;

	session_start();

	if($_SESSION['siteuser'] !=0){
		$loggedIn = TRUE;

		if ($login_page){
			header("Location: index.php");
		}
	} else {
		$loggedIn = FALSE;

		if (!$login_page){
			header("Location: login.php");
		}
	}

$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

$users_table = $mysql_link->query('SELECT * FROM `users_table`');

$mysql_link->close();

?>