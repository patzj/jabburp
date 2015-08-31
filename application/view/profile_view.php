<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<div id="profile_main">
	<div id="avatar_container">
		<img id="avatar" src="" alt="<?= @$data['username'] ?>'s avatar"/>
	</div><!-- end avatar_container -->
	<div id="info_container">
		<h3><?= @$data['username'] ?></h3>
		<?php
		if(@$_SESSION['username'] == @$data['username']):
		?>
		<a href="<?= BASEPATH ?>profile/edit/<?= @$_SESSION['username'] ?>">Edit</a>
		<?php else: ?>
		<div id="contact_stat_container">
		<?php
			if(@$data['contact_stat']) {
				extract(@$data['contact_stat']);
				if(@$_SESSION['uid'] == $user1) { 
					$btn_val[] = $status; // if current user added the profile owner
					$btn_val[] = 'cancel';
				} else {
					$btn_val[] = 'confirm'; // if profile owner added the current user
					$btn_val[] = 'reject';
				}
			} else {
				$btn_val[] = 'add'; // if no rows found on contact table
			}
		?>
			<button id="contact_stat" value="<?= @$btn_val[0] ?>"><?= @$btn_val[0] ?></button>
			<button id="negate_contact_stat" value="<?= @$btn_val[1] ?>"><?= @$btn_val[1] ?></button>
		</div><!-- end contact_stat_container -->
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
	</div><!-- end info_container -->
</div><!-- end profile_main -->
<script src="<?= BASEPATH ?>public/js/user_contact_stat.js"></script>