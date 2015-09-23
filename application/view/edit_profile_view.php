<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section id="edit_profile_main">
	<form id="form_edit_profile" action="<?= BASEPATH ?>edit/update_profile" method="post">
		<label for="firstname">Firstname:</label>
		<input type="text" id="firstname" name="firstname" maxlength="32" value="<?= @$data['firstname'] ?>"/>
		<span class="error"></span><br/>

		<label for="lastname">Lastname:</label>
		<input type="text" id="lastname" name="lastname" maxlength="32" value="<?= @$data['lastname'] ?>"/>
		<span class="error"></span><br/>

		<label for="gender">Gender:</label>
		<input type="radio" id="male" class="gender" name="gender" value="male"
		<?php
			if($data['gender'] == 'male') echo 'checked';
		?>/><span>Male</span>
		<input type="radio" id="female" class="gender" name="gender" value="female"
		<?php
			if($data['gender'] == 'female') echo 'checked';
		?>/><span>Female</span>
		<span class="error"></span><br/>

		<label for="about">About:</label><br/>
		<textarea id="about" name="about" maxlength="255"><?= @$data['about'] ?></textarea>
		<input type="text" id="about_counter" size="3" maxlength="3" readonly/><br/>

		<input type="submit" id="btn_save_profile" name="btn_save_profile" value="Save"/>
	</form>
	<span class="server_error"><?= @$data['error'] ?></span>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>