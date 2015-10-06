<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section class="col-sm-3 col-md-3 col-lg-4"></section>
<section id="search_main" class="col-sm-6 col-md-6 col-lg-4">
	<section class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">Search</h2>
		</div>
		<div class="panel-body">
			<form id="form_search" class="form" action="#" method="post">
				<div class="form-group">
					<input type="text" id="search_key" class="form-control" name="search_key" maxlength="64"/>
				</div>
			</form>
		</article><!-- end search_input -->
		<article id="search_output" class="table-responsive">
			<table class="table table-hover">
			</table>
		</article><!-- end search_output -->
	</div>
	</section>
</section><!-- end search_main -->
<script src="<?= BASEPATH ?>public/js/search_user_info.js"></script>