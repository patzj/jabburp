"use strict";
var basepath = 'http://localhost/jabburp/';
var xhr = [];

function displayChat(other) { // other user param
	var message = '';

	$.ajax({
		url: basepath + 'chat/display',
		data: { data: other },
		success: function(data) { // if success
			var response = eval('(' + data + ')'); // decode response from target url
			var len = response.length;
			var last_msg_id = 0;
			$('#chat_output').empty(); // empty output; other user transition
			$('#chat_space').find('h4').text(other);
			if(len > 0) { // check if response from ajax is not blank
				for(var i in response) { // loop on response
					if(response[i]['username'] == other) { 
						message = '<article class="well"><p><small>[' + 
						response[i]['date_time'] + ']</small></p>' + 
						'<strong>' + response[i]['username'] + ':</strong> ' +
						response[i]['content'] + '</article>'; 
					} else { 
						message = '<article class="well site-color" style="text-align: right;"><p><small>[' + 
						response[i]['date_time'] + ']</small></p>' + 
						response[i]['content'] + ' <strong>:' +
						response[i]['username'] + '</strong></article>';
					}
					$('#chat_output').append(message); // display each msg response
					last_msg_id = response[i]['msg_id']; // wil be set to the last msg_id thru loop
				}
			} else console.log('null response.'); 

			$('#chat_output').scrollTop(9999);
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
			$('#chat_output').append('<article>Unable to deliver message. ' + 
				'Please refresh append try again.</article>');
		}
	});
}

function getNew(other, last_msg_id) {
	var message = '';

	$.ajax({
		url: basepath + 'chat/recent',
		data: { data: [other, last_msg_id] },
		beforeSend: function(jqXHR) {
			xhr.push(jqXHR);
		},
		success: function(data) {
			var response = eval('(' + data + ')');
			var len = response.length;
			if(len > 0) {
				for(var i in response) { // loop on response
					if(response[i]['username'] == other) { 
						message = '<article class="well"><p><small>[' + 
						response[i]['date_time'] + ']</small></p>' + 
						'<strong>' + response[i]['username'] + ':</strong> ' +
						response[i]['content'] + '</article>'; 
					} else { 
						message = '<article class="well site-color" style="text-align: right;"><p><small>[' + 
						response[i]['date_time'] + ']</small></p>' + 
						response[i]['content'] + ' <strong>:' +
						response[i]['username'] + '</strong></article>';
					}
					$('#chat_output').append(message); // display each msg response
					last_msg_id = response[i]['msg_id']; // wil be set to the last msg_id thru loop
				}
			}
			setTimeout(getNew(other, last_msg_id), 1000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
			// setTimeout(getNew(other, last_msg_id), 5000);
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
	});

	$('.contact').click(function() { // if one on contact list is clicked/selected
		var i = $(this).index(); // get index of clicked element
		var other = $('h5').eq(i).text(); // get text/content of clicked element

		if(xhr.length > 0) {
			xhr[0].abort();
			xhr.shift();
		} // abort current chat ajax request

		displayChat(other); // call display chat method

		return false; // prevent page from loading
	});

	$('#btn_send').click(function() {
		var other = $('#chat_space').find('h4').text();
		var message = $('#txt_msg').val();
		if(other != '' && message != '') {
			sendMessage(other, message);
		} return false;
	});
});