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
		<a href="#">Add Contact</a>
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