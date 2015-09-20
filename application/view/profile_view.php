<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section id="profile_main">
	<figure id="avatar_container">
		<img id="avatar" src="" alt="<?= @$data['username'] ?>'s avatar"/>
	</figure><!-- end avatar_container -->
	<article class="user_info">
		<h3><?= @$data['username'] ?></h3>
		<?php
		if(@$_SESSION['username'] == @$data['username']):
		?>
		<a href="<?= BASEPATH ?>edit/profile">Edit</a>
		<?php else: ?>
		<div class="contact_status">
			<button id="btn_cs" value="<?= @$data['button'][0] ?>"><?= @$data['button'][0] ?></button>
			<button id="btn_null_cs" value="<?= @$data['button'][1] ?>"><?= @$data['button'][1] ?></button>
		</div><!-- end contact_status -->
		<?php endif; ?>
		<table>
			<tr>
				<td>Name:</td>
				<td><?= @$data['firstname'] ?>&nbsp;<?= @$data['lastname'] ?></td>
			</tr>
			<tr>
				<td>Gender:</td>
				<td><?= ucfirst(@$data['gender']) ?></td>
			</tr>
			<tr>
				<td>About:</td>
				<td><?= @$data['about'] ?></td>
			</tr>
		</table>
		<?php
		if(@$_SESSION['username'] == $data['username']):
		?>
		<a href="<?= BASEPATH ?>edit/email">Change email</a><br/>
		<a href="<?= BASEPATH ?>edit/password">Change password</a>
		<?php endif; ?>
	</article><!-- end user_info -->
</section><!-- end profile_main -->
<script src="<?= BASEPATH ?>public/js/user_contact_status.js"></script>