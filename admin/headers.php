<?php
	include 'config.php';

	echo $prefs;

	if ($page_title == "") {
		$page_title = "Honeycomb App";
	} else {
		$page_title .= " | Honeycomb App";
	}

	$body_class = "loading";
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

	<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, width=device-width" />

	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $host; ?>/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $host; ?>/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $host; ?>/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $host; ?>/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo $host; ?>/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $host; ?>/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $host; ?>/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $host; ?>/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="<?php echo $host; ?>/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php echo $host; ?>/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo $host; ?>/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo $host; ?>/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo $host; ?>/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="Honeycomb App"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?php echo $host; ?>/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo $host; ?>/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo $host; ?>/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo $host; ?>/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo $host; ?>/mstile-310x310.png" />

</head>

<body class="<?php echo $body_class; ?>">