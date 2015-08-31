"use strict";
var basepath = 'http://localhost/jabburp/';	
var url = basepath + 'search/user'; // destination url for ajax/post

function searchUser(search_key) {
	var data = { data: search_key }; // set data for ajax/post
	$.post(url, data, function(data, status) {
		if(status == 'success') { // if success
			var response = eval('(' + data + ')'); // get encoded result
			var len = response.length;
			if(len > 0) {
				$('#search_output').empty(); // clear prev results
				for(var i in response) { // loop on response elements
					$('#search_output').append('<p class="result" <img src="" alt="avatar"/>&nbsp;' +
						'<a href="http://localhost/jabburp/profile/view/' + response[i].username + 
						'">' + response[i].username + '</a>&nbsp;' + response[i].name + 
						'<p>'); // create an interface for results
				}
			} else {
				$('#search_output').empty(); // clear prev results
				$('#search_output').append('<p class="result">No results found.</p>') // no results found
			}
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