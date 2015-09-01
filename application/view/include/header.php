<?php
if(!defined('BASEPATH')) die('Direct script access not allowed.');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $data['title']; ?></title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="<?= BASEPATH ?>public/css/master_layout_style.css" rel="stylesheet" type="text/css"/>
	<link href="<?= BASEPATH ?>public/css/profile_layout_style.css" rel="stylesheet" type="text/css"/>
	<!--[if lt IE 9]>
		<script src="<?= BASEPATH ?>public/js/html5shiv.min.js"></script>
	<![endif]-->
	<script src="<?= BASEPATH ?>public/js/jquery-1.11.3.min.js"></script>
</head>
<body>
<header>
	<section class="container">
		<h1>jabburp</h1>
		<h2>jabber up!</h2>
	</section><!-- end container -->
</header><!-- end header -->

<nav>
	<section class="container">
		<ul>
			<li><a href="<?= BASEPATH ?>">Home</a></li>
			<li><a href="<?= BASEPATH ?>profile/view/<?= @$_SESSION['username'] ?>">Profile</a><li>
		</ul>
	</section><!-- end container -->
</nav><!-- end nav -->

<main>
	<section class="container">
