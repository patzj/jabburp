<?php if(!defined('BASEPATH')) die('Direct script access not allowed'); ?>
<div id="search_main">
	<div id="search_input">
		<form id="form_search" action="" method="post">
			<label for="search_key">Search</label>
			<input type="text" id="search_key" name="search_key" maxlength="64"/>
		</form>
	</div><!-- end search_input -->
	<div id="search_output">
	</div><!-- end search_output -->
</div><!-- end search_main -->
<script src="<?= BASEPATH ?>public/js/search_user_info.js"></script>