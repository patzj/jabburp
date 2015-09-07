"use strict";
var basepath = 'http://localhost/jabburp/';

function display_chat(other) { // other user param
	var url = basepath + 'chat/display'; // target url
	var data = { data: other }; // other user; selected h4 of current user
	$.post(url, data, function(data, status) { // ajax/post
		if(status == 'success') { // if success
			var response = eval('(' + data + ')'); // decode response from target url
			var len = response.length;
			var last_msg_id = 0;
			$('#chat_output').empty(); // empty output; other user transition
			$('#chat_space').children('h4').text(other);
			if(len > 0) { // check if response from ajax is not blank
				for(var i in response) { // loop on response
					$('#chat_output').append('<p>[' + response[i]['date_time'] + ']' + 
						response[i]['username'] + ' says: ' +
						response[i]['content'] + '</p>'); // display each msg response
					last_msg_id = response[i]['msg_id']; // wil be set to the last msg_id thru loop
				}
			} else console.log('null response.'); 

			setTimeout(get_new(other, last_msg_id), 1000);
		} else console.log('something went wrong.');
	});
}

function send_message(other, message) {
	var url = basepath + 'chat/send';
	var data = { data: [other, message] };
	$.post(url, data, function(data, status) {
		if(status == 'success') {
			var response = eval('(' + data + ')'); // got nothing to do with this
			$('#txt_msg').val('');
		} else {
			$('#chat_output').append('<p>Unable to deliver message. ' + 
				'Please refresh and try again.</p>');
		}
	});	
}

function get_new(other, last_msg_id) {
	var url = basepath + 'chat/recent';
	var data = { data: [other, last_msg_id] };
	$.post(url, data, function(data, status) {
		if(status == 'success') {
			var response = eval('(' + data + ')');
			var len = response.length;
			if(len > 0) {
				console.log(response);
			} else console.log('null');
		} else console.log('error');
	});
}

// main method
$(document).ready(function() {
	$('#contact_list a').click(function() { // if one on contact list is clicked/selected
		var i = $(this).index(); // get index of clicked element
		var other = $('h4').eq(i).text(); // get text/content of clicked element
		var last_msg_id = $('#chat_output').children('h4').text();

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