<?php
if(!defined('BASEPATH')) die('Direct script access not allowed.');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= @$data['title'] ?></title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="<?= BASEPATH ?>public/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= BASEPATH ?>public/css/master_layout_style.css" rel="stylesheet" type="text/css"/>
	<link href="<?= BASEPATH ?>public/css/home_layout_style.css" rel="stylesheet" type="text/css"/>
	<link href="<?= BASEPATH ?>public/css/profile_layout_style.css" rel="stylesheet" type="text/css"/>
	<!--[if lt IE 9]>
		<script src="<?= BASEPATH ?>public/js/html5shiv.min.js"></script>
	<![endif]-->
	<script src="<?= BASEPATH ?>public/js/jquery-1.11.3.min.js"></script>
	<script src="<?= BASEPATH ?>public/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
	<script src="<?= BASEPATH ?>public/js/config.js"></script>
	<script src="<?= BASEPATH ?>public/js/nav_behavior.js"></script>
</head>
<body>
<header>
	<section class="container">
		<a href="<?= BASEPATH ?>"><h1>jabburp</h1></a>
	</section><!-- end container -->
</header><!-- end header -->

<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="80"
	style="border: none; border-radius: 0">
	<section class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target="#menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="nav navbar-nav navbar-right">
				<?php if(isset($_SESSION['username'])): ?>
				<li><a href="<?= BASEPATH ?>"><span class="glyphicon glyphicon-home"></span>
					&nbsp;Home
				</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-user"></span>
						&nbsp;<?= @$_SESSION['username'] ?>&nbsp;
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= BASEPATH ?>profile/view/<?= @$_SESSION['username'] ?>">
						Profile</a></li>
						<li><a href="<?= BASEPATH ?>logout">Log Out</a></li>
					</ul>
				</li>
				<li><a href="<?= BASEPATH ?>contact/requests">
					<span class="glyphicon glyphicon-th-list"></span>&nbsp;Requests
				</a></li>
				<li><a href="<?= BASEPATH ?>search"><span class="glyphicon glyphicon-search">
					</span>&nbsp;Search
				</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</section><!-- end container -->
</nav><!-- end nav -->

<main>
	<section class="container">
