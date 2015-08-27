<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<form id="form_join" action="join/signup" method="post">
	<label for="username">Username:</label>
	<input type="text" id="username" name="username" maxlength="20" value="<?= @$data['username'] ?>">
	<span class="error"></span><br/>

	<label for="password">Password:</label>
	<input type="password" id="password" name="password" maxlength="32">
	<span class="error"></span><br/>

	<label for="c_password">Confirm Password:</label>
	<input type="password" id="c_password" name="c_password" maxlength="32">
	<span class="error"></span><br/>

	<label for="email">Email:</label>
	<input type="email" id="email" name="email" maxlength="64" value="<?= @$data['email'] ?>">
	<span class="error"></span><br/>

	<label for="c_email">Confirm Email:</label>
	<input type="email" id="c_email" name="c_email" maxlength="64" value="<?= @$data['c_email'] ?>">
	<span class="error"></span><br/>

	<label for="firstname">Firstname:</label>
	<input type="text" id="firstname" name="firstname" maxlength="32" value="<?= @$data['firstname'] ?>">
	<span class="error"></span><br>

	<label for="lastname">Lastname:</label>
	<input type="text" id="lastname" name="lastname" maxlength="32" value="<?= @$data['lastname'] ?>">
	<span class="error"></span><br>

	<label for="gender">Gender:</label>
	<input type="radio" id="male" class="gender" name="gender" value="male"><span>Male</span>
	<input type="radio" id="female" class="gender" name="gender" value="female"><span>Female</span>
	<span class="error"></span><br>
	<input type="submit" id="submit" name="submit" value="Join">
</form>
<div class="error">
	<?= @$data['error_msg']; ?>
</div>