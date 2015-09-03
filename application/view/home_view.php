<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="home_main">
	<aside>
		<section id="user">
			<?php extract($data); ?>
			<article>
				<figure>
					<img src="" style="width: 75px; height: 75px"/>
				</figure>
				<p><strong><?= $_SESSION['username'] ?></strong></p>
				<p><small><?= $name ?></small></p>
			</article>
		</section>
		<section id="contact_list">
			<?php foreach ($contact_list as $contact): ?>
			<article class="contact">
				<figure>
					<img src="" style="width: 50px; height: 50px"/>
				</figure>
				<p><strong><?= $contact['username'] ?></strong><p>
				<p><small><?= $contact['name'] ?></small></p>
			</p>
			<?php endforeach; ?>
		</section>
	</aside>
	<section id="chat_space">
		<article id="chat_output">
		</article>
		<form id="form_chat" action="" method="post">
			<textarea id="txt_msg" max-length="255"></textarea>
			<button id="btn_send">Send</button>
		</form>
	</section>
</section>

