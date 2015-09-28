"use strict";
var basepath = 'http://localhost/jabburp/';
var icon = "glyphicon glyphicon-remove";
var group = "has-error";

// validation functions
function validateUsername() { // var assignment not working on callback.. I wonder why
	var elem = '#username';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else { // username is not empty but...
		if(isTooShort(elem, 4)) { // check if too short
			hasError = true;
		} else if(isIndexNumeric(elem, 0) || // check first char if numeric
			hasSpecialChars(elem) || hasWhiteSpace(elem)) { // or if contains special chars and spaces
			hasError = true;
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { username: $(elem).val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					if(response == 'not available') {
						$(elem).next().addClass(icon);
						$(elem).parent().addClass(group);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}

	return { hasError: hasError, elem: elem };
}

function validatePassword() {
	var elem = '#password';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else if(isTooShort(elem, 6)) { // check if too short
		hasError = true;
	} else if(hasWhiteSpace(elem)) { // check for spaces
		hasError = true;
	}

	return { hasError: hasError, elem: elem };
}

function validateCPassword() {
	var elem = '#c_password';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else if($(elem).val() != $('#password').val()) { // check password mismatch
		hasError = true;
	}
	
	return { hasError: hasError, elem: elem };
}

function validateOPassword() {
	var result = '';
	if(isEmpty('#o_password')) result = '*';
	$('#o_password').next().text(result);
}

function validateEmail() {
	var elem = "#email";
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else { // email is not empty but...
		var validEmail = /\S+@\S+\.\S+/g.test($(elem).val()); // temp checker just to patch things up
		if(!validEmail || hasWhiteSpace(elem)) { // check...
			hasError = true;
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { email: $(elem).val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					if(response == 'not available') {
						$(elem).next().addClass(icon);
						$(elem).parent().addClass(group);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}

	return { hasError: hasError, elem: elem };
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
	var elem = '#c_email';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else if($(elem).val() != $('#email').val()) { // check email mismatch
		hasError = true;
	}
	
	return { hasError: hasError, elem: elem };
}

function validateFirstname() {
	var elem = '#firstname';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else if (isTooShort(elem, 2)) { // check if too short
		hasError = true;
	} else if (hasSpecialCharsV2(elem)) { // check for special chars
		hasError = true;
	}
	
	return { hasError: hasError, elem: elem };
}

function validateLastname() {
	var elem = '#lastname';
	var hasError = false;

	if(isEmpty(elem)) { // check if empty
		hasError = true;
	} else if (isTooShort(elem, 2)) { // check if too short
		hasError = true;
	} else if (hasSpecialCharsV2(elem)) { // check for special chars
		hasError = true;
	}
	
	return { hasError: hasError, elem: elem };
}

function validateGender() {
	var elem = '[name="gender"]';
	var hasError = false;

	if($('input[type=radio]:checked').val() == null) { // if no radio button is checked
		hasError = true;
	}

	return { hasError: hasError, elem: elem };
}

function counterAbout() {
	var len = $('#about').val().length;
	$('#about_counter').val(255 - len);
}

function validateAll() { // all in one validation
	var validationList = [validateUsername, validatePassword, validateCPassword, 
		validateEmail, validateCEmail, validateFirstname, validateLastname, validateGender];
	var len = validationList.length;

	for(var i = 0; i < len; i++) {
		var validation = validationList[i]();

		$(validation['elem']).next().removeClass(icon);
		$(validation['elem']).parent().removeClass(group);

		if(validation['elem'] == '[name="gender"]')
			$(validation['elem']).parents('[class*="form-group"]').removeClass(group);

		if(validation['hasError'] == true) {
			if(validation['elem'] != '[name="gender"]') {
				$(validation['elem']).next().addClass(icon);
				$(validation['elem']).parent().addClass(group);
			} else {
				$(validation['elem']).parents('[class*="form-group"]').addClass(group);
			}			
		}
	}
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

	$('input').keyup(function() { // run function depending on input blurred
		var response = {};

		$(this).next().removeClass(icon);
		$(this).parent().removeClass(group);

		switch($(this).attr('name')) {
			case 'username':
				response = validateUsername();
				break;
			case 'password':
				response = validatePassword();
				break;
			case 'c_password':
				response = validateCPassword();
				break;
			case 'o_password':
				validateOPassword();
				break;
			case 'email':
				response = validateEmail();
				if($('#form_change_email') == 1)
					validateEmailNoChanges(); // if on change email page
				break;
			case 'c_email':
				response = validateCEmail();
				break;
			case 'firstname':
				response = validateFirstname();
				break;
			case 'lastname':
				response = validateLastname();
				break
			case 'gender':
				response = validateGender();
				break;
			default:
				console.log('no command yet.');
				break;
		}

		if(response['hasError'] == true) {
			$(this).next().addClass(icon);
			$(this).parent().addClass(group);
		}
	});


	$('[name="gender"]').focus(function() {
		var response = validateGender();
		$(response['elem']).parents('[class*="form-group"]').removeClass(group);

		if(response['hasError'] == true)
			$(response['elem']).parents('[class*="form-group"]').addClass(group);
	});

	$('[name="gender"]').blur(function() {
		var response = validateGender();
		$(response['elem']).parents('[class*="form-group"]').removeClass(group);

		if(response['hasError'] == true)
			$(response['elem']).parents('[class*="form-group"]').addClass(group);
	});

	$('#about').keyup(function() {
		counterAbout();
	});

	$('#form_signup').submit(function() {
		validateAll();
		if($('.form-group').hasClass(group)) return false; // restrict submit
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