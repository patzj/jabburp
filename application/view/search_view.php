<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<section id="search_main">
	<article id="search_input">
		<form id="form_search" action="" method="post">
			<label for="search_key">Search</label>
			<input type="text" id="search_key" name="search_key" maxlength="64"/>
		</form>
	</article><!-- end search_input -->
	<article id="search_output">
	</article><!-- end search_output -->
</section><!-- end search_main -->
<script src="<?= BASEPATH ?>public/js/search_user_info.js"></script>