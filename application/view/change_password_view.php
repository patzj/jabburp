<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="change_password_main">
	<form id="form_change_password" action="<?= BASEPATH ?>edit/update_password" method="post">
		<label for="o_password">Old password:</label>
		<input type="password" id="o_password" name="o_password" maxlength="32"/>
		<span class="error"></span><br/>

		<label for="password">New password:</label>
		<input type="password" id="password" name="password" maxlength="32"/>
		<span class="error"></span><br/>

		<label for="c_password">Confirm password:</label>
		<input type="password" id="c_password" name="c_password" maxlength="32"/>
		<span class="error"></span><br/>

		<input type="submit" id="btn_change_password" name="btn_change_password" value="Submit">
		<a href="<?= BASEPATH ?>profile/view/<?= $_SESSION['username'] ?>">Cancel</a>
	</form>
	<span class="server_error"><?= @$data['error'] ?></span>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>