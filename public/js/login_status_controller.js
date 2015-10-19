"use strict";
var basepath = "http://localhost/jabburp/";

function setLastClientPing() { // ping server to flag online status
	$.ajax({
		url: basepath + 'login/client',
		success: function(data) {
			setTimeout(setLastClientPing, 300000); // will run every 5 mins
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			setTimeout(setLastClientPing, 5000); // re-attemp after 5 sec
		}
	})
}

function setLastUserActivity() { // update last user activity
	$.ajax({
		url: basepath + 'login/activity',
		success: function(data) {
			getLoginStatus();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

function setAway() { // set away status on certain conditions
	$.ajax({
		url: basepath + 'login/away',
		success: function(data) {
			console.log(data);
			setTimeout(setAway, 300000); // will run every 5 mins
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			setTimeout(setAway, 5000); // re-attemp after 5 sec
		}
	});
}

function setLoginStatus(status) { // set login status of current user
	$.ajax({
		url: basepath + 'login/set_status',
		data: { data: status }, // dropdown value
		success: function(data) {
			var response = eval('(' + data + ')');
			console.log(response);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

function getLoginStatus() { // get login status of current user
	$.ajax({
		url: basepath + 'login/get_status',
		success: function(data) {
			var response = eval('(' + data + ')');
			var opt = 0;
			switch(response) {
				case 'active':
					opt = 1;
					break;
				case 'away':
					opt = 2;
					break;
				case 'busy':
					opt = 3;
					break;
				case 'offline':
					opt = 4;
					break;
				default:
					opt = 0;
					break;
			}
			$('select').children().eq(opt).prop({selected: true});
			setTimeout(getLoginStatus, 300000); // will run every 5 mins
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			setTimeout(getLoginStatus, 5000); // re-attemp after 5 sec
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

	var path = location.pathname;
	var invalidPath = /\S+(login|logout|signup)+/i.test(path);
	if(!invalidPath) { // will run if NOT login, logout and signup page
		setLastClientPing();
		setAway();
		getLoginStatus();
	}
	// run update every input or link interaction
	$('input').click(function() {
		setLastUserActivity();
	});

	$('button').click(function() {
		setLastUserActivity();
	});

	$('a').click(function() {
		setLastUserActivity();
	});

	$('select').change(function() {
		setLoginStatus($(this).val());
	});
});