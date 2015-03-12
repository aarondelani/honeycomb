<?php
include_once 'config.php';

$dataTables = FALSE;
$charts = FALSE;
$autocomplete = FALSE;
$bootstrapWYSIWYG = FALSE;
$errs = TRUE;

if ($errs) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
}

session_start();

// if ($_SERVER['HTTP_REFERER'] != "") {
// 	$_SESSION['url'] = $_SERVER['HTTP_REFERER'];
// }

if($_SESSION['siteuser'] !=0){
	$loggedIn = TRUE;

	// if(isset($_REQUEST['redirurl'])) {
	// 	$url = $_REQUEST['redirurl']; // holds url for last page visited.

	// 	header("Location: $url");
	// } else {
		// header("Location: index.php");
	// }

	$_SESSION['login_tries'] = 0;
} else {
	$loggedIn = FALSE;

	if (!$login_page){
		header("Location: ".$host."/login.php");
	}
}

$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

$users_table = $mysql_link->query('SELECT * FROM `users_table`');

$mysql_link->close();

?>