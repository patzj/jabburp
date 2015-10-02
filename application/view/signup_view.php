<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section class="col-md-1 col-lg-1"></section>
<section id="signup_main" class="col-md-10 col-lg-10">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Sign Up</h2>
		</div>
		<div class="panel-body">
			<form id="form_signup" class="form" role="form" action="<?= BASEPATH ?>signup/submit"
				autocomplete="off" method="post">
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="username" class="control-label">Username:</label>
					<input type="text" id="username" class="form-control" name="username" maxlength="20" 
						value="<?= @$data['username'] ?>" data-toggle="popover" data-placement="bottom" 
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
				<div class="clearfix"></div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="password" class="control-label">Password:</label>
					<input type="password" id="password" name="password" class="form-control" maxlength="32"
						data-toggle="popover" data-placement="bottom" title="" data-content="" 
						data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="c_password" class="control-label">Confirm Password:</label>
					<input type="password" id="c_password" name="c_password" class="form-control" maxlength="32" 
						data-toggle="popover" data-placement="bottom" title="" data-content="" 
						data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="email" class="control-label">Email:</label>
					<input type="email" id="email" name="email" maxlength="64" class="form-control" 
						value="<?= @$data['email'] ?>" data-toggle="popover" data-placement="bottom" 
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="c_email" class="control-label">Confirm Email:</label>
					<input type="email" id="c_email" name="c_email" maxlength="64" class="form-control" 
						value="<?= @$data['email'] ?>" data-toggle="popover" data-placement="bottom" 
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="firstname" class="control-label">Firstname:</label>
					<input type="text" id="firstname" name="firstname" maxlength="32" class="form-control" 
						value="<?= @$data['firstname'] ?>" data-toggle="popover" data-placement="bottom" 
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group has-feedback">
					<label for="lastname" class="control-label">Lastname:</label>
					<input type="text" id="lastname" name="lastname" maxlength="32" class="form-control" 
						value="<?= @$data['lastname'] ?>" data-toggle="popover" data-placement="bottom" 
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group"> 
					<label for="gender" class="control-label">Gender:</label><br/>
					<label class="radio-inline">
						<input type="radio" id="male" name="gender" value="male"/>Male
					</label>
					<label class="radio-inline">
						<input type="radio" id="female" name="gender" value="female"/>Female
					</label>
					<span class="form-control-feedback"></span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6">
				<div class="form-group">
					<input type="submit" id="btn_signup" class="btn btn-default" name="btn_signup" 
						value="Sign Up"/>
					<a href="<?= BASEPATH ?>" class="btn btn-default">Cancel</a>
				</div>
			</div>
			</form>
		</div>
		<div class="panel-footer">
			<span class="text-danger"><?= @$data['error'] ?></span>
		</div>
	</section><!-- end panel -->
</section><!-- end signup_main -->
<script>
</script>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>
