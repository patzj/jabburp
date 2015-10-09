<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="change_email_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Change Email</h2>
		</div>
		<div class="panel-body">
			<form id="form_change_email" class="form" role="form"
				action="<?= BASEPATH ?>edit/update_email" method="post">
				<div class="form-group has-feedback">
					<label for="email" class="control-label">New Email:</label>
					<input type="email" id="email" name="email" class="form-control"
						maxlength="64" data-toggle="popover" data-placement="bottom"
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="c_email">Confirm Email:</label>
					<input type="email" id="c_email" name="c_email" class="form-control"
						maxlength="64" data-toggle="popover" data-placement="bottom"
						title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="clearfix"></div>
				<div class="form-group">
					<input type="submit" id="btn_change_email" name="btn_change_email" 
						class="btn btn-default" value="Submit">
					<a href="<?= BASEPATH ?>profile/view/<?= $_SESSION['username'] ?>"
						class="btn btn-default">Cancel</a>
				</div>
			</form>
		</div>
		<div class="panel-footer">
			<span class="text-danger"><?= @$data['error'] ?></span>
		</div>
	</section>
</section>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>