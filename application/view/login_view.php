<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section class="col-xs-0 col-sm-1 col-md-2 col-lg-4"></section>
<section id="login_main" class="col-xs-12 col-sm-10 col-md-8 col-lg-4">
	<form id="form_login" role="form" action="<?= BASEPATH ?>login/submit" method="post">
		<div class="form-group">
			<label for="username">Username:&nbsp;</label>
			<input type="text" id="username" class="form-control" name="username" maxlength="20">
		</div>
		<div class="form-group">
			<label for="password">Password:&nbsp;</label>
			<input type="password" id="password" class="form-control" name="password" maxlength="32">
		</div>
		<div class="form-group pull-right">
			<input type="submit" id="btn_login" class='btn' name="btn_login" value="Log In">&nbsp;<span>or</span>&nbsp;
			<a href="<?= BASEPATH ?>signup" id="link_signup">Sign Up</a>
		</div>
	</form>
	<div class="clearfix"></div>
	<span class="server_error text-danger col-xs-12 col-sm-12 col-md-12 col-lg-12" 
		style="text-align:center;"><?= @$data['error'] ?></span>
</section><!-- end login_main -->
<section class="col-xs-0 col-sm-1 col-md-2 col-lg-4"></section>