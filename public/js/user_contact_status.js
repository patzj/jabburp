"use strict";
var basepath = 'http://localhost/jabburp/';

function addRequest() {
	var url = basepath + 'contact/add'; // destination url
	var data = { data: $('h3').text() }; // get h3 for ajax
	$.post(url, data, function(data, status) { // ajax
		if(status == 'success') { // if success
			var json = eval('(' + data + ')'); // decode callback
			if(json == true) { // if decoded is true
				$('#btn_cs').val('pending').text('pending'); // change btn val
				$('#btn_cs').prop({disabled: true}); // disable pending btn
				$('#btn_cs').next().show(); // show null sibling btn
				$('#btn_cs').next().val('cancel').text('cancel'); // set sibling val
			} else console.log('error');
		} else console.log(status);
	});
}

function removeStatus() { // this function will exec the pending stat removal
	var url = basepath + 'contact/cancel'; // destination url
	var data = { data: $('h3').text() }; // get the h3 tag; need for identifying w/c to remove
	$.post(url, data, function(data, status) { // ajax 
		if(status == 'success') { // if success
			var json = eval('(' + data + ')'); // decode callback data
			if(json == true) { // if decoded is true
				$('#btn_cs').val('add').text('add'); // change btn val
				$('#btn_cs').prop({disabled: false}); // re-enable btn
				$('#btn_cs').next().hide(); // hide sibling btn
			} else console.log('error');
		} else console.log(status);
	});
}

function confirmRequest() { // this function will confirm the request
	var url = basepath + 'contact/confirm'; // destination url
	var data = { data: $('h3').text() }; // get h3 for post
	$.post(url, data, function(data, status) { // ajax
		if(status == 'success') { // if success
			var json = eval('(' + data + ')'); // decode callback data
			if(json == true) { // if true
				$('#btn_cs').val('remove').text('remove'); // change btn val
				$('#btn_cs').next().hide(); // hide sibling btn

				$('#btn_cs').prop({disabled: true}); // disable btn; prevent immediate confirm-remove
				setTimeout(function() { 
					$('#btn_cs').prop({disabled: false});
				}, 3000); // re-enable after 3 sec
			} else console.log('error');
		} else console.log(status);
	});
}

$(document).ready(function() { // main method
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
	});
});