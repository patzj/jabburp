<?php if(!defined('BASEPATH')) die('Direct script access not allowed.'); ?>
<section id="home_main">
	<aside class="col-md-4">
		<section id="user" class="panel panel-default">
			<?php extract($data); ?>
			<article class="panel-heading">
				<h2 class="panel-title"><?= $_SESSION['username'] ?></h2>
			</article>
			<article class="panel-body">
				<figure class="col-md-6">
					<img src="" style="width: 75px; height: 75px"/>
				</figure>
				<article class="col-md-6">
					<small><?= $name ?></small>
					<select class="form-control">
						<option disabled></option>
						<option value="active">active</option>
						<option value="away">away</option>
						<option value="busy">busy</option>
						<option value="offline">offline</option>
					</select>
				</article>
			</article>
		</section>
		<section id="contact_list" class="panel panel-default">
			<article class="panel-heading">
				<h2 class="panel-title">Contacts</h2>
			</article>
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
									<h5><?= $contact['username'] ?></h5>
									<small><?= $contact['name'] ?></small>
								</article>
							</td>
						</tr>
					</a>
				<?php endforeach; ?>
				</table>
		</section>
	</aside>
	<section id="chat_space" class="panel panel-default col-md-8">
		<article class="panel-heading">
			<h4 class="panel-title">&nbsp;</h4>
		</article>
		<article id="chat_output" class="panel-body">
		</article>
		<article id="chat_control" class="panel-footer navbar-fixed-bottom">
			<form id="form_chat" class="form" role="form" action="" method="post">
				<textarea id="txt_msg" class="form-control" max-length="255"></textarea>
				<button id="btn_send" class="btn btn-default">Send</button>
			</form>
		</article>
	</section>
</section>
<script src="<?= BASEPATH ?>public/js/chat_client_controller.js"></script>
<script defer="true">
	$(document).ready(function() {
		function setColor(color) {
			$('select').css('color', color);
		}

		function setStatusColor() {
			var status = $('option:checked').val();

			switch(status) {
				case 'active':
					setColor('green');
					break;
				case 'away':
					setColor('orange');
					break;
				case 'busy':
					setColor('red');
					break;
				case 'offline':
				default:
					setColor('gray');
					break;
			}
		}

		$('select').on('change', function() {
			setStatusColor();
		});

		setTimeout(setStatusColor, 250);
	});
</script>
