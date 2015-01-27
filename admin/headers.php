<?php
	include 'config.php';

	echo $prefs;

	if ($page_title == "") {
		$page_title = "Honeycomb App";
	} else {
		$page_title .= " | Honeycomb App";
	}
?>
<!DOCTYPE HTML>
<head>
	<title><?php echo $page_title; ?></title>
	<link href="<?php echo "$host";?>/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="<?php echo "$host";?>/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
	<!--[if IE]>
	  <link href="<?php echo "$host";?>/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<![endif]-->
	<script src="<?php echo "$host";?>/javascripts/jquery.min.js"></script>
</head>

<body>