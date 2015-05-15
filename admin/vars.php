<?php
include_once 'config.php';

$loggedIn = FALSE;

$dataTables = FALSE;
$charts = FALSE;
$autocomplete = FALSE;
$bootstrapWYSIWYG = FALSE;
$errs = FALSE;
$home_page_active = FALSE;
$inventory_page_active = FALSE;
$customer_page_active = FALSE;
$import_customer_page_active = FALSE;
$lead_page_active = FALSE;
$product_page_active = FALSE;

$page_title = "";
$body_class = "";

if ($errs) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
}

session_start();
// print_r($_SERVER);

if ($_SERVER['HTTP_REFERER'] != "" && isset($_SESSION['url'])) {
	$_SESSION['url'] = $_SERVER['HTTP_REFERER'];
} else {
	$_SESSION['url'] = $host;
}

if (!isset($_SESSION['login_tries'])) {
	$_SESSION['login_tries'] = 0;
}

if(isset($_SESSION['siteuser'])) {
	if($_SESSION['siteuser'] !=0){
		$loggedIn = TRUE;

		$_SESSION['login_tries'] = 0;
	}
} else {
	$loggedIn = FALSE;

	if (!$login_page){
		header("Location: ".$host."/login.php");
	}
}
?>