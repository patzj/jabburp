<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="change_email_main">
	<form id="form_change_email" action="<?= BASEPATH ?>edit/update_email" method="post">
		<label for="email">New Email:</label>
		<input type="email" id="email" name="email" maxlength="64"/>
		<span class="error"></span><br/>

		<label for="c_email">Confirm Email:</label>
		<input type="email" id="c_email" name="c_email" maxlength="64"/>
		<span class="error"></span><br/>

		<input type="submit" id="btn_change_email" name="btn_change_email" value="Submit">
		<a href="<?= BASEPATH ?>profile/view/<?= $_SESSION['username'] ?>">Cancel</a>
	</form>
	<span class="server_error"><?= @$data['error'] ?></span>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>