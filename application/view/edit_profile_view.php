<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="edit_profile_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Edit Profile</h2>
		</div>
		<div class="panel-body">
			<form id="form_edit_profile" class="form" role="form"
				action="<?= BASEPATH ?>edit/update_profile" method="post">
				<div class="form-group has-feedback">
					<label for="firstname" class="control-label">Firstname:</label>
					<input type="text" id="firstname" name="firstname" class="form-control"
						maxlength="32" value="<?= @$data['firstname'] ?>" data-toggle="popover"
						data-placement="bottom" title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="lastname" class="control-label">Lastname:</label>
					<input type="text" id="lastname" name="lastname" class="form-control"
					maxlength="32" value="<?= @$data['lastname'] ?>" data-toggle="popover"
					data-placement="bottom" title="" data-content="" data-trigger="focus"/>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="gender" class="control-label">Gender:</label><br/>
					<label class="radio-inline">
						<input type="radio" id="male" name="gender" value="male"
						<?php if($data['gender'] == 'male') echo 'checked'; ?>/>Male
					</label>
					<label class="radio-inline">
						<input type="radio" id="female" name="gender" value="female"
						<?php if($data['gender'] == 'female') echo 'checked'; ?>/>Female
					</label>
					<span class="form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<label for="about" class="control-label">About:</label>
					<textarea id="about" name="about"
						class="form-control" rows="5" maxlength="255"><?= @$data['about'] ?></textarea>
					<div class="pull-right">
					<small>characters left:
						<input type="text" id="about_counter" class="form-control input-sm" size="1" 
							style="background: none;" readonly/>
					</small>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group">
					<input type="submit" id="btn_save_profile" name="btn_save_profile"
						class="btn btn-default" value="Save"/>
					<a href="<?= BASEPATH ?>profile/view/<?= $_SESSION['username']?>"
						class="btn btn-default">Cancel</a>
					</div>
			</form>
		</div>
		<div class="panel-footer">
			<span class="text-danger"><?= @$data['error'] ?></span>
		</div>
	</section>
</section>
<script src="<?= BASEPATH ?>public/js/validate_form_input.js"></script>