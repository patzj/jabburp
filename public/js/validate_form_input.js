"use strict";
var basepath = 'http://localhost/jabburp/';

// validation functions
function validateUsername() { // var assignment not working on callback.. I wonder why
	$('#username').next().text('');
	if(isEmpty('#username')) { // check if empty
		$('#username').next().text('*');
	} else { // username is not empty but...
		if(isTooShort('#username', 4)) { // check if too short
			$('#username').next().text('too short');
		} else if(isIndexNumeric('#username', 0) || // check first char if numeric
			hasSpecialChars('#username') || hasWhiteSpace('#username')) { // or if contains special chars and spaces
			$('#username').next().text('invalid');
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { username: $('#username').val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					$('#username').next().text(response); // display result
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}
}

function validatePassword() {
	var result = '';
	if(isEmpty('#password')) { // check if empty
		result = '*';
	} else if(isTooShort('#password', 6)) { // check if too short
		result = 'too short';
	} else if(hasWhiteSpace('#password')) { // check for spaces
		result = 'invalid'
	}
	$('#password').next().text(result);
}

function validateCPassword() {
	var result = '';
	if(isEmpty('#c_password')) { // check if empty
		result = '*';
	} else if($('#c_password').val() != $('#password').val()) { // check password mismatch
		result = 'password mismatch';
	}
	$('#c_password').next().text(result);
}

function validateOPassword() {
	var result = '';
	if(isEmpty('#o_password')) result = '*';
	$('#o_password').next().text(result);
}

function validateEmail() {
	$('#email').next().text('');
	if(isEmpty('#email')) { // check if empty
		$('#email').next().text('*');
	} else { // email is not empty but...
		var validEmail = /\S+@\S+\.\S+/g.test($('#email').val()); // temp checker just to patch things up
		if(!validEmail || hasWhiteSpace('#email')) { // check...
			$('#email').next().text('invalid');
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { email: $('#email').val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					$('#email').next().text(response);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}
}

function validateEmailNoChanges() { // if input email if same with current on db
	// $('#email').next().text('');
	if(isEmpty('#email')) {
		$('#email').next().text('*');
	} else {
		var validEmail = /\S+@\S+\.\S+/g.test($('#email').val()); // temp checker just to patch things up
		if(!validEmail || hasWhiteSpace('#email')) {
			$('#email').next().text('invalid');
		} else {
			$.ajax({
				url: basepath + 'edit/validate',
				data: { email: $('#email').val() },
				success: function(data) {
					var response = eval('(' + data + ')');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}
}

function validateCEmail() {
	var result = '';
	if(isEmpty('#c_email')) { // check if empty
		result = '*';
	} else if($('#c_email').val() != $('#email').val()) { // check email mismatch
			result = 'email mismatch';
	}
	$('#c_email').next().text(result);
}

function validateFirstname() {
	var result = '';
	if(isEmpty('#firstname')) { // check if empty
		result = '*';
	} else if (isTooShort('#firstname', 2)) { // check if too short
		result = 'too short';
	} else if (hasSpecialCharsV2('#firstname')) { // check for specia chars
		result = 'invalid';
	}
	$('#firstname').next().text(result); 
}

function validateLastname() {
	var result = '';
	if(isEmpty('#lastname')) { // check if empty
		result = '*';
	} else if (isTooShort('#lastname', 2)) { // check if too short
		result = 'too short';
	} else if (hasSpecialCharsV2('#lastname')) { // check for special chars
		result = 'invalid';
	}
	$('#lastname').next().text(result);
}

function validateGender() {
	var result = '';
	var gender = $('input[type=radio]:checked').val(); // get checked radio button
	if(gender == null) { // if no radio button is checked
		result = '*';
	}
	$('label[for=gender]').nextAll('span.error').text(result);
}

function counterAbout() {
	var len = $('#about').val().length;
	$('#about_counter').val(255 - len);
}

function validateAll() { // all in one validation
	validateUsername();
	validatePassword();
	validateCPassword();
	validateEmail();
	validateCEmail();
	validateFirstname();
	validateLastname();
	validateGender();	
}

// helper functions
function isEmpty(selector) { // for checking empty input
	if($(selector).val() == '') return true;
	else return false;
}

function isTooShort(selector, limit) { // for checking too short input length
	if($(selector).val().length < limit) return true;
	else return false;
}

function isIndexNumeric(selector, index) { // for checking for numeric char
	if(!isNaN($(selector).val().charAt(index) / 1)) return true;
	else return false;
}

function hasWhiteSpace(selector) { // for checking white spaces(spaces, tabs, ...)
	return /\s+/.test($(selector).val());
}

function hasSpecialChars(selector) { // for checking special chars
	return /[`~!@#$%^&*()\-\+=\[{\]}\\\|;:\'\",<>?]/.test($(selector).val());
}

function hasSpecialCharsV2(selector) { // for checking special chars; dash, single quote allowed
	return /[`~!@#$%^&*()_\+=\[{\]}\\\|;:\",<>?]/.test($(selector).val());
}

// main method
$(document).ready(function() {
	$.ajaxSetup({
		type: 'POST',
		async: true,
		cache: false,
		global: false
	});

	$('#about_counter').val(255);

	$('input').blur(function() { // run function depending on input blurred
		switch($(this).attr('name')) {
			case 'username':
				validateUsername();
				break;
			case 'password':
				validatePassword();
				break;
			case 'c_password':
				validateCPassword();
				break;
			case 'o_password':
				validateOPassword();
				break;
			case 'email':
				validateEmail();
				if($('#form_change_email') == 1) validateEmailNoChanges(); // if on change email page
				break;
			case 'c_email':
				validateCEmail();
				break;
			case 'firstname':
				validateFirstname();
				break;
			case 'lastname':
				validateLastname();
				break
			case 'gender':
				validateGender();
				break;
			default:
				console.log('no command yet.');
				break;
		}
	});

	$('#about').keyup(function() {
		counterAbout();
	});

	$('#form_signup').submit(function() {
		if($('span.error').text() != '') return false; // restrict submit
	});

	$('#form_edit_profile').submit(function() {
		validateFirstname();
		validateLastname();
		validateGender(); // some validations
		if($('span.error').text() != '') return false; // restrict submit
	});

	$('#form_change_email').submit(function() {
		validateEmailNoChanges();
		validateEmail();
		validateCEmail();
		if($('span.error').text() != '') return false; // restrict submit
	});

	$('#form_change_password').submit(function() {
		validateOPassword();
		validatePassword();
		validateCPassword();
		if($('span.error').text() != '') return false; // restrict submit
	});

});