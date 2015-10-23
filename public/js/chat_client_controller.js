"use strict";
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
			setTimeout(function() {
				getNew(other, last_msg_id)
			}, 1000);
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
					if(other == response[i]['username'] && 
						$('#user').find('h2').text() == response[i]['username']) {
						$('#chat_output').append(message); // display each msg response
					}
					last_msg_id = response[i]['msg_id']; // wil be set to the last msg_id thru loop
				}
			}
			setTimeout(function() {
				$('#chat_output').scrollTop(9999);
				getNew(other, last_msg_id)
			}, 1000);
		},
		complete: function() {
			setReadMessageIndicator(other);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
			// setTimeout(getNew(other, last_msg_id), 5000);
		}
	});
}

function displayChatBox() {
	$('#chat_space').removeClass('hidden-xs hidden-sm');
	$('aside').addClass('hidden-xs hidden-sm');
}

function getContactStatus() {
	var contactPool = $('.contact').find('h5');
	var contactPoolStatus = $('.contact_status');
	var len = contactPool.length;
	var data = [];

	for(var i = 0; i < len; i++) {
		data.push(contactPool[i].innerHTML);
	}

	$.ajax({
		url: basepath + 'home/contact_status',
		data: { data: data },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response != '') {
				for(var i = 0; i < len; i++) {
					contactPoolStatus[i].innerHTML = response[i];
				}
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});	
}

function updateContactStatus() {
	var contactPool = $('.contact').find('h5');
	var contactPoolStatus = $('.contact_status');
	var len = contactPool.length;
	var data = [];

	for(var i = 0; i < len; i++) {
		data.push(contactPool[i].innerHTML);
	}

	$.ajax({
		url: basepath + 'home/update_contact_status',
		data: { data: data },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response != '') {
				for(var i = 0; i < len; i++) {
					contactPoolStatus[i].innerHTML = response[i];
				}
			}
			setTimeout(updateContactStatus, 1000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

function setUnreadMessageIndicator() {
	var contactPool = $('.contact').find('h5');
	var contactPoolStatus = $('.contact_status');
	var len = contactPool.length;
	var data = [];

	for(var i = 0; i < len; i++) {
		data.push(contactPool[i].innerHTML);
	}

	$.ajax({
		url: basepath + 'home/unread',
		data: { data: data },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response != '') {
				for(var i = 0; i < len; i++) {
					if(response[i] == true) {
						$('.contact').eq(i).css('font-weight', 'bold');
					}
				}
			console.log(response);
			}
			setTimeout(setUnreadMessageIndicator, 2000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

function setReadMessageIndicator(other) {
	$.ajax({
		url: basepath + 'home/read',
		data: { data: other },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response == true) {
				console.log('read');
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
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

		displayChatBox();
		displayChat(other); // call display chat method
		setReadMessageIndicator(other);

		return false; // prevent page from loading
	});

	$('#btn_send').click(function() {
		var other = $('#chat_space').find('h4').text();
		var message = $('#txt_msg').val();
		if(other != '' && message != '') {
			sendMessage(other, message);
		} return false;
	});

	$('#close_chat').click(function() {
		$('#chat_space').addClass('hidden-xs hidden-sm');
		$('aside').removeClass('hidden-xs hidden-sm');
		return false;
	});

	getContactStatus();
	updateContactStatus();
	setUnreadMessageIndicator();
});