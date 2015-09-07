"use strict";
var basepath = 'http://localhost/jabburp/';

function display_chat(other) { // other user param
	var url = basepath + 'chat/display'; // target url
	var data = { data: other }; // other user; selected h4 of current user
	$.post(url, data, function(data, status) { // ajax/post
		if(status == 'success') { // if success
			var response = eval('(' + data + ')'); // decode response from target url
			var len = response.length; 
			$('#chat_output').empty(); // empty output; other user transition
			$('#chat_space').children('h4').text(other);
			if(len > 0) { // check if response from ajax is not blank
				for(var i in response) { // loop on response
					$('#chat_output').append('<p>[' + response[i]['date_time'] + ']' + 
						'uid' + response[i]['user'] + ' says: ' +
						response[i]['content'] +
					'</p>'); // display each msg response
				}
			} else console.log('null response.'); 
		} else console.log('something went wrong.');
	});
}

function send_message(other, message) {
	var url = basepath + 'chat/send';
	var data = { data: [other, message] };
	$.post(url, data, function(data, status) {
		if(status == 'success') {
			console.log(data);
		} else console.log('failed');
	});
}

// main method
$(document).ready(function() {
	$('#contact_list a').click(function() { // if one on contact list is clicked/selected
		var i = $(this).index(); // get index of clicked element
		var other = $('h4').eq(i).text(); // get text/content of clicked element
		display_chat(other); // call display chat method
		return false; // prevent page from loading
	});

	$('#btn_send').click(function() {
		var other = $('#chat_space').children('h4').text();
		var message = $('#txt_msg').val();
		if(other != '' && message != '') {
			send_message(other, message);
		} return false;
	});
});