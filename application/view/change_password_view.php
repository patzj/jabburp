<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="change_password_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Change Password</h2>
		</div>
		<div class="panel-body">
			<form id="form_change_password" class="form" role="form"
				action="<?= BASEPATH ?>edit/update_password" method="post">
				<div class="form-group has-feedback">
					<label for="o_password" class="control-label">Old password:</label>
					<input type="password" id="o_password" name="o_password" class="form-control"
						maxlength="32" data-toggle="popover" data-placement="bottom"
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="password" class="control-label">New password:</label>
					<input type="password" id="password" name="password" class="form-control"
						maxlength="32" data-toggle="popover" data-placement="bottom"
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="c_password" class="control-label">Confirm password:</label>
					<input type="password" id="c_password" name="c_password" class="form-control"
						maxlength="32" data-toggle="popover" data-placement="bottom"
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="clearfix"></div>
				<div class="form-group has-feedback">
					<button type="submit" id="btn_change_password" name="btn_change_password" 
						class="btn btn-default">
						Save
					</button>
					<a href="<?= BASEPATH ?>profile/view/<?= $_SESSION['username'] ?>"
						class="btn btn-default">
						Cancel
					</a>
				</div>
			</form>
		</div>
		<div class="panel-footer">
			<span class="server_error"><?= @$data['error'] ?></span>
		</div>
	</section>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>