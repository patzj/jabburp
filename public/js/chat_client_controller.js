"use strict";
var basepath = 'http://localhost/jabburp/';

function displayChat(other) { // other user param
	$.ajax({
		url: basepath + 'chat/display',
		data: { data: other },
		success: function(data) { // if success
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

			setTimeout(getNew(other, last_msg_id), 1000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log('something went wrong.');
		}
	});
}

function sendMessage(other, message) {
	$.ajax({
		url: basepath + 'chat/send',
		data: { data: [other, message] },
		success: function(data) {
			var response = eval('(' + data + ')'); // got nothing to do with this
			$('#txt_msg').val('');
			console.log('sent');
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$('#chat_output').append('<p>Unable to deliver message. ' + 
				'Please refresh append try again.</p>');
		}
	});
}

function getNew(other, last_msg_id) {
	$.ajax({
		url: basepath + 'chat/recent',
		data: { data: [other, last_msg_id] },
		success: function(data) {
			var response = eval('(' + data + ')');
			var len = response.length;
			if(len > 0) {
				for(var i in response) { // loop on response
					$('#chat_output').append('<p>[' + response[i]['date_time'] + ']' + 
						response[i]['username'] + ' says: ' +
						response[i]['content'] + '</p>'); // display each msg response
					last_msg_id = response[i]['msg_id']; // wil be set to the last msg_id thru loop
				}
			}
			setTimeout(getNew(other, last_msg_id), 1000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
			setTimeout(getNew(other, last_msg_id), 5000);
		}
	});
}

// main method
$(document).ready(function() {

	$.ajaxSetup({
		type: 'POST',
		async: true,
		cache: false,
		global: false
		// beforeSend: function(jqXHR) {
		// 	$('a').click(function() {
		// 		jqXHR.abort();
		// 	});
		// }
	});

	$('#contact_list a').click(function() { // if one on contact list is clicked/selected
		var i = $(this).index(); // get index of clicked element
		var other = $('h4').eq(i).text(); // get text/content of clicked element
		var last_msg_id = $('#chat_output').children('h4').text();

		displayChat(other); // call display chat method
		return false; // prevent page from loading
	});

	$('#btn_send').click(function() {
		var other = $('#chat_space').children('h4').text();
		var message = $('#txt_msg').val();
		if(other != '' && message != '') {
			sendMessage(other, message);
		} return false;
	});
});