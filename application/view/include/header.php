<?php
if(!defined('BASEPATH')) die('Direct script access not allowed.');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $data['title']; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="<?= BASEPATH ?>public/css/master_layout_style.css" rel="stylesheet" type="text/css"/>
	<link href="<?= BASEPATH ?>public/css/profile_layout_style.css" rel="stylesheet" type="text/css"/>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
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
