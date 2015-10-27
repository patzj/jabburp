<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="requests_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<article class="panel-heading">
			<h2 class="panel-title">Contact Requests</h2>
		</article>
		<article class="panel-body">
			<table class="table">
			<?php foreach(@$data['requests'] as $row): ?>
				<tr>
					<td class="borderless">
						<?= $row['username'] ?>
					</td>
					<td class="borderless">
						<?= $row['firstname'] . ' ' . $row['lastname'] ?>
					</td>
					<td class="borderless">
						<a href="<?= BASEPATH ?>/profile/view/<?= @$row['username'] ?>"
							class="btn btn-default btn-sm">View</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		</article>
	</section>
</section>