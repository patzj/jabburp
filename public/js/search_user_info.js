"use strict";
var basepath = 'http://localhost/jabburp/';	
var url = basepath + 'search/user'; // destination url for ajax/post

function searchUser(search_key) {
	if(search_key == '') { 
		$('#search_output').children().empty();
		return false;
	} // no ajax will fire

	$.ajax({
		url: basepath + 'search/user',
		data: { data: search_key },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response.length > 0) {
				$('#search_output').children().empty(); // clear prev results
				for(var i in response) { // loop on response elements
					$('#search_output').children().append('<tr><td>' +
						'<a href="http://localhost/jabburp/profile/view/' + response[i].username + 
						'">' + response[i].username + '</a></td><td>' + response[i].name + 
						'</td><tr>'); // create an interface for results
				}
			} else {
				$('#search_output').children().empty(); // clear prev results
				$('#search_output').children().append('<tr><td>No results found.</td></tr>');
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
		}
	});
}

$(document).ready(function() { // main method
	$.ajaxSetup({
		type: 'POST',
		async: true,
		cache: false,
		global: false
	});

	$('#search_key').keyup(function() { // exec if something is written
		searchUser($(this).val()); // pass search_key to function
	});
});