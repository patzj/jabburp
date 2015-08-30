"use strict";
var url = 'http://localhost/jabburp/search/user'; // destination url for ajax/post

function searchUser(search_key) {
	var data = { data: search_key }; // set data for ajax/post
	$.post(url, data, function(data, status) {
		if(status == 'success') { // if success
			var response = eval('(' + data + ')'); // get encoded result
			console.log(data); // display result
		} else {
			console.log('error'); // display status if err
		}
	});
}

$(document).ready(function() { // main method
	$('#search_key').keyup(function() { // exec if something is written
		searchUser($(this).val()); // pass search_key to function
		//console.log($(this).val());
	});
});