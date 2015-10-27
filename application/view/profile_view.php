<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="profile_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><strong><?= @$data['username'] ?></strong></h2>
	</div>
	<div class="panel-body">
		<table class="table table-condensed borderless">
			<tr>
				<td class="borderless">
					<figure id="avatar_container">
						<img id="avatar" src="" style="height: 150px; width: 150px;"/>
					</figure><!-- end avatar_container -->
				</td>
			<td class="borderless">
				<article id="user_controls">
					<?php
					if(@$_SESSION['username'] == @$data['username']):
					?>
					<a href="<?= BASEPATH ?>edit/profile" class="btn btn-default btn-block">
						Edit
					</a>
					<?php else: ?>
					<div class="contact_status">
						<button id="btn_cs" class="btn btn-default btn-block"
							value="<?= @$data['button'][0] ?>"><?= @$data['button'][0] ?></button>
						<button id="btn_null_cs" class="btn btn-default btn-block"
							value="<?= @$data['button'][1] ?>"><?= @$data['button'][1] ?></button>
					</div><!-- end contact_status -->
				<?php endif; ?>
				</article>
				</td>
			</tr>
		</table>
		<article id="user_info" class="row">
			<table class="table">
				<tr>
					<td><strong>Name:</strong></td>
					<td><?= @$data['firstname'] ?>&nbsp;<?= @$data['lastname'] ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Gender:</strong></td>
					<td><?= ucfirst(@$data['gender']) ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>About:</strong></td>
					<td class="hidden-xs"><?= @$data['about'] ?>
					</td>
					<td class="visible-xs-block">
						<button class="btn btn-default btn-xs" data-toggle="collapse"
							data-target="#collapse_about">
							<span class="glyphicon glyphicon-chevron-down">
						</button>
					</td>
					<td></td>
				</tr>
				<tr id="collapse_about" class="collapse">
					<td colspan="3"><small><?= @$data['about'] ?></small></td>
				</tr>
			<?php
			if(@$_SESSION['username'] == $data['username']):
			?>
				<tr>
					<td><strong>Email:</strong></td>
					<td class="hidden-xs"><?= @$data['email'] ?></td>
					<td class="visible-xs-block">
						<button class="btn btn-default btn-xs" data-toggle="collapse"
							data-target="#collapse_email">
							<span class="glyphicon glyphicon-chevron-down">
						</button>
					</td>
					<td><a href="<?= BASEPATH ?>edit/email"
						class="btn btn-default btn-xs">
						Edit
					</a>
					</td>
				</tr>
				<tr id="collapse_email" class="collapse">
					<td colspan="3"><small><?= @$data['email'] ?></small></td>
				</tr>
				<tr>
					<td><strong>Password:</strong></td>
					<td>****</td>
					<td><a href="<?= BASEPATH ?>edit/password"
						class="btn btn-default btn-xs">
						Edit
						</a>
					</td>
				</tr>
			<?php endif; ?>
			</table>
		</article><!-- end user_info -->
	</div>
	</section>
</section><!-- end profile_main -->
<section class="col-sm-3 col-md-3 col-lg-4"></section>	
<script src="<?= BASEPATH ?>public/js/user_contact_status.js"></script>
<script>
	$(document).ready(function() {
		$('[class*="glyphicon"]').click(function() {
			if($(this).hasClass('glyphicon-chevron-down') == true) {
				$(this).removeClass('glyphicon-chevron-down');
				$(this).addClass('glyphicon-chevron-up');
			} else {
				$(this).removeClass('glyphicon-chevron-up');
				$(this).addClass('glyphicon-chevron-down');	
			}
		});
	});
</script>