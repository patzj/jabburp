'use strict';
var basepath = 'http://192.168.1.4/jabburp/';

$(document).ready(function() {
	$.ajaxSetup({
		type: 'POST',
		async: true,
		cache: false,
		global: false
	});
});