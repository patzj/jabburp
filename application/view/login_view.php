<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="login_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Log In</h2>
		</div>
		<div class="panel-body">
			<form id="form_login" class="form" role="form" action="<?= BASEPATH ?>login/submit" method="post">
				<div class="form-group">
					<label for="username">Username:&nbsp;</label>
					<input type="text" id="username" class="form-control" name="username" maxlength="20">
				</div>
				<div class="form-group">
					<label for="password">Password:&nbsp;</label>
					<input type="password" id="password" class="form-control" name="password" maxlength="32">
				</div>
				<div class="form-group pull-right">
					<button type="submit" id="btn_login" class='btn btn-default'
						name="btn_login">
						Log In
					</button>
						&nbsp;<span>|</span>&nbsp;
					<a href="<?= BASEPATH ?>signup" id="link_signup" class='btn btn-default'>
						Sign Up
					</a>
				</div>
			</form>
		</div>
		<div class="panel-footer">
			<span class="text-danger"><?= @$data['error'] ?></span>
		</div>
	</section><!-- end panel -->
</section><!-- end login_main -->
