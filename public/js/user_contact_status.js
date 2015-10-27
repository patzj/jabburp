"use strict";

function addRequest() {
	$.ajax({
		url: basepath + 'contact/add',
		data: { data: $('h2').text() },
		success: function(data) {
			var response = eval('(' + data + ')'); // decode call back data
			if(response) { // if data is true
				$('#btn_cs').val('pending').text('pending'); // change btn val
				$('#btn_cs').prop({disabled: true}); // disable pending btn
				$('#btn_cs').next().show(); // show null sibling btn
				$('#btn_cs').next().val('cancel').text('cancel'); // set sibling val
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
		}
	})
}

function removeStatus() { // this function will exec the pending stat removal
	$.ajax({
		url: basepath + 'contact/cancel',
		data: { data: $('h2').text() },
		success: function(data) {
			var response = eval('(' + data + ')'); // decode callback data
			if(response == true) { // if true
				$('#btn_cs').val('add').text('add'); // change btn val
				$('#btn_cs').prop({disabled: false}); // re-enable btn
				$('#btn_cs').next().hide(); // hide sibling btn
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
		}
	});
}

function confirmRequest() { // this function will confirm the request
	$.ajax({
		url: basepath + 'contact/confirm',
		data: { data: $('h2').text() },
		success: function(data) {
			var response = eval('(' + data + ')'); // decode callback data
			if(response == true) { // if true
				$('#btn_cs').val('remove').text('remove'); // change btn val
				$('#btn_cs').next().hide(); // hide sibling btn

				$('#btn_cs').prop({disabled: true}); // disable btn; prevent immediate confirm-remove
				setTimeout(function() { 
					$('#btn_cs').prop({disabled: false});
				}, 3000); // re-enable after 3 sec
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

	switch($('#btn_cs').val()) {
		case 'add': // hide sibling btn if status is add/no rel
			$('#btn_cs').next().hide();
			break;
		case 'remove': // hide sibling; no block feat. yet
			$('#btn_cs').next().hide();
			break;
		case 'pending': // disable pending btn
			$('#btn_cs').prop({disabled: true});
			break;
		default:
			console.log('no command yet.');
			break;
	}

	$('button').click(function() {
		switch($(this).attr('id')) { // run command depending on the button clicked
			case 'btn_cs':
				switch($(this).val()) {
					case 'add': // contact request
						addRequest();
						break;
					case 'confirm': // confirm request
						confirmRequest();
						break;
					case 'remove': // cancel/reject
						removeStatus();
						break;
					default: 
						console.log($(this).val());
						break;
				}
				break;
			case 'btn_null_cs':
				removeStatus(); // removal of pending request bet. 2 users
				break;
			default:
				console.log('no command yet.');
				break;
		}

		return false;
	});
});