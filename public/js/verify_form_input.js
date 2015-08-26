"use strict";
var url = './service/verify_form_input.php'; // destination url for ajax/post

function verifyUsername() { // var assignment not working on callback.. I wonder why
	$('#username').next().text('');
	if(isEmpty('#username')) { // check if empty
		$('#username').next().text('*');
	} else { // username is not empty but...
		if(isTooShort('#username', 4)) { // check if too short
			$('#username').next().text('too short');
		} else if(isIndexNumeric('#username', 0) || // check first char if numeric
			hasSpecialChars('#username')) { // or if contains special chars
			$('#username').next().text('invalid');
		} else {
			var data = {username: $('#username').val()}; // set data for ajax/post
			$.post(url, data, function(data, status) {
				if(status == 'success') { // if success
					var response = eval('(' + data + ')'); // get encoded result
					$('#username').next().text(response); // display result
				} else {
					$('#username').next().text(status); // display status if err
				}
			});
		}
	}
}

function verifyPassword() {
	var result = '';
	if(isEmpty('#password')) { // check if empty
		result = '*';
	} else if(isTooShort('#password', 6)) { // check if too short
		result = 'too short';
	}
	$('#password').next().text(result);
}

function verifyCPassword() {
	var result = '';
	if(isEmpty('#c_password')) { // check if empty
		result = '*';
	} else if($('#c_password').val() != $('#password').val()) { // check password mismatch
		result = 'password mismatch';
	}
	$('#c_password').next().text(result);
}

function verifyEmail() {
	$('#email').next().text('');
	if(isEmpty('#email')) { // check if empty
		$('#email').next().text('*');
	} else { // email is not empty but...
		var validEmail = /\S+@\S+\.\S+/g.test($('#email').val());
		if(!validEmail) { // temp checker just to patch things up
			$('#email').next().text('invalid');
		} else {
			var data = {email: $('#email').val()}; // set data for ajax/post
			$.post(url, data, function(data, status){
				if(status == 'success') { // if success
					var response = eval('(' + data + ')'); // get encoded result
					$('#email').next().text(response); // display result
				} else {
					$('#email').next().text(status); // display status if err
				}
			});
		}
	}
}

function verifyCEmail() {
	var result = '';
	if(isEmpty('#c_email')) { // check if empty
		result = '*';
	} else if($('#c_email').val() != $('#email').val()) { // check email mismatch
			result = 'email mismatch';
	}
	$('#c_email').next().text(result);
}

function verifyFirstname() {
	var result = '';
	if(isEmpty('#firstname')) { // check if empty
		result = '*';
	} else if (isTooShort('#lastname', 2)) { // check if too short
		result = 'too short';
	} else if (hasSpecialCharsV2('#firstname')) { // check for specia chars
		result = 'invalid';
	}
	$('#firstname').next().text(result); 
}

function verifyLastname() {
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

function verifyGender() {
	var result = '';
	var gender = $('input[type=radio]:checked').val(); // get checked radio button
	if(gender == null) { // if no radio button is checked
		result = '*';
	}
	$('label[for=gender]').nextAll('span.error').text(result);
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

function hasSpecialChars(selector) { // for checking special chars
	return /[`~!@#$%^&*()\-\+=\[{\]}\\\|;:\'\",<>?]/.test($(selector).val());
}

function hasSpecialCharsV2(selector) { // for checking special chars; dash allowed
	return /[`~!@#$%^&*()_\+=\[{\]}\\\|;:\'\",<>?]/.test($(selector).val());
}

$(document).ready(function() {
	$('#username').blur(function() {
		verifyUsername();
	});

	$('#password').blur(function() {
		verifyPassword();
	});

	$('#c_password').blur(function() {
		verifyCPassword();
	});

	$('#email').blur(function() {
		verifyEmail();
	});

	$('#c_email').blur(function() {
		verifyCEmail();
	});

	$('#firstname').blur(function() {
		verifyFirstname();
	});

	$('#lastname').blur(function() {
		verifyLastname();
	});

	$('#form_join').submit(function() {
		verifyUsername();
		verifyPassword();
		verifyCPassword();
		verifyEmail();
		verifyCEmail();
		verifyFirstname();
		verifyLastname();
		verifyGender(); // run all checker functions before submit
		if($('span.error').text() != '') { // if error found
			console.log('errors');
			return false; // restrict submit
		}
	});
});