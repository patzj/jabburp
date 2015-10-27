<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="home_main">
	<aside class="col-md-4">
		<section id="user" class="panel panel-default">
			<?php extract($data); ?>
			<article class="panel-heading">
				<h2 class="panel-title"><?= $_SESSION['username'] ?></h2>
			</article>
			<article>
				<table class="table">
					<tr>
						<td>
							<figure>
								<img src="" style="width: 75px; height: 75px"/>
							</figure>
						</td>
						<td>
							<article>
								<small><?= $name ?></small>
								<select class="form-control">
									<option disabled></option>
									<option value="active">active</option>
									<option value="away">away</option>
									<option value="busy">busy</option>
									<option value="offline">offline</option>
								</select>
							</article>
						</td>
					</tr>
				</table>
			</article>
		</section>
		<section class="panel panel-default">
			<article class="panel-heading">
				<h2 class="panel-title">Contacts</h2>
			</article>
			<article id="contact_list">
				<table class="table table-hover">
				<?php foreach ($contact_list as $contact): ?>
					<a href="">
						<tr class="contact">
							<td>
								<figure>
									<img src="" style="width: 60px; height: 60px"/>
								</figure>
							</td>
							<td>
								<article>
									<h5 style="display:inline;"><?= $contact['username'] ?></h5>
									<small class="contact_status badge"></small><br/>
									<small><?= $contact['name'] ?></small>
								</article>
							</td>
						</tr>
					</a>
				<?php endforeach; ?>
				</table>
			</article>
		</section>
	</aside>
	<section id="chat_space" class="col-md-8 hidden-xs hidden-sm">
		<a href="#" id="close_chat" class="close visible-xs visible-sm">&times;</a>
		<section class="panel panel-default">
			<article class="panel-heading">
				<h4 class="panel-title">&nbsp;</h4>
			</article>
			<article id="chat_output" class="panel-body">
				<article class="well">Click a contact and jabber up!</article>
			</article>
		</section>
		<section id="chat_control" class="row col-xs-12">
			<form id="form_chat" class="form-horizontal" role="form" action="" method="post">
				<span class="col-xs-8 col-sm-9 col-md-10">
				<input type="text" id="txt_msg" class="form-control" max-length="255">
				</span>
				<span class="col-xs-4 col-sm-3 col-md-2">
				<button id="btn_send" class="btn btn-default btn-block">
					Send
				</button>
				</span>
			</form>
		</section>
	</section>
</section>
<script src="<?= BASEPATH ?>public/js/chat_client_controller.js"></script>
<script src="<?= BASEPATH ?>public/js/login_status_controller.js"></script>
<script>
	$(document).ready(function() {
		$('#chat_output').css({
			'min-height': ((screen.height / 2)) + 'px',
			'max-height': ((screen.height / 2)) + 'px'
		});

		$('#contact_list').css({
			'max-height': (screen.height / 3) + 'px'
		});
	});
</script>
