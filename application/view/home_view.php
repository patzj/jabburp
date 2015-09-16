<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="home_main">
	<aside>
		<section id="user">
			<?php extract($data); ?>
			<article>
				<figure>
					<img src="" style="width: 75px; height: 75px"/>
				</figure>
				<h3><?= $_SESSION['username'] ?></h3>
				<p><small><?= $name ?></small></p>
				<select>
					<option disabled></option>
					<option value="active">active</option>
					<option value="away">away</option>
					<option value="busy">busy</option>
					<option value="offline">appear offline</option>
				</select>
			</article>
		</section>
		<section id="contact_list">
			<?php foreach ($contact_list as $contact): ?>
			<a href="">
				<article class="contact">
					<figure>
						<img src="" style="width: 50px; height: 50px"/>
					</figure>
					<h4><?= $contact['username'] ?></h4>
					<p><small><?= $contact['name'] ?></small></p>
				</article>
			</a>
			<?php endforeach; ?>
		</section>
	</aside>
	<section id="chat_space">
		<h4></h4>
		<article id="chat_output">
		</article>
		<form id="form_chat" action="" method="post">
			<textarea id="txt_msg" max-length="255"></textarea>
			<button id="btn_send">Send</button>
		</form>
	</section>
</section>
<script src="<?= BASEPATH ?>public/js/chat_client_controller.js"></script>

