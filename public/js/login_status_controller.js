"use strict";
var basepath = "http://localhost/jabburp/";

function setLastClientPing() { // ping server to flag online status
	$.ajax({
		url: basepath + 'login/client',
		success: function(data) {
			var response = eval('(' + data + ')');
			console.log(response);
			setTimeout(setLastClientPing, 300000); // will run every 5 mins
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	})
}

function setLastUserActivity() { // update last user activity
	$.ajax({
		url: basepath + 'login/activity',
		success: function(data) {
			var response = eval('(' + data + ')');
			console.log(response);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

function setIdle() {
	$.ajax({
		url: basepath + 'login/idle',
		success: function(data) {
			var response = eval('(' + data + ')');
			console.log(response);
			setTimeout(setIdle, 300000); // will run every 5 mins
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	})
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
		setIdle();
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

	$('textarea').focus(function() {
		setLastUserActivity();
	});
});