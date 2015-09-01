<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="login_main">
	<form id="form_login" action="<?= BASEPATH ?>login/submit" method="post">
		<label for="username">Username:&nbsp;</label>
		<input type="text" id="username" name="username" maxlength="20"><br/>
		<label for="password">Password:&nbsp;</label>
		<input type="password" id="password" name="password" maxlength="32"><br/>
		<input type="submit" id="btn_login" name="btn_login" value="Log In">&nbsp;<span>or</span>&nbsp;
		<a href="<?= BASEPATH ?>signup" id="link_signup">Sign Up</a>
	</form>
	<p class='error'><?= @$data['error_msg'] ?></p>
</section><!-- end login_main -->