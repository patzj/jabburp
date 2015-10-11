"use strict";
var basepath = 'http://localhost/jabburp/';
var icon = 'glyphicon glyphicon-remove';
var group = 'has-error';

// validation functions
function validateUsername() { // var assignment not working on callback.. I wonder why
	var elem = '#username';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else { // username is not empty but...
		if(isTooShort(elem, 4)) { // check if too short
			hasError = true;
			popoverTitle = 'too short';
		} else if(isIndexNumeric(elem, 0) || // check first char if numeric
			hasSpecialChars(elem) || hasWhiteSpace(elem)) { // or if contains special chars and spaces
			hasError = true;
			popoverTitle = 'invalid';
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { username: $(elem).val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					if(response == 'not available') {
						$(elem).siblings('[class*="form-control-feedback"]').removeClass(icon);
						$(elem).parent().removeClass(group);

						$(elem).attr('data-content', response); // set data content for popover

						$(elem).siblings('[class*="form-control-feedback"]').addClass(icon);
						$(elem).parent().addClass(group);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}

	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validatePassword() {
	var elem = '#password';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else if(isTooShort(elem, 6)) { // check if too short
		hasError = true;
		popoverTitle = 'too short';
	} else if(hasWhiteSpace(elem)) { // check for spaces
		hasError = true;
		popoverTitle = 'invalid';
	}

	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateCPassword() {
	var elem = '#c_password';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else if($(elem).val() != $('#password').val()) { // check password mismatch
		hasError = true;
		popoverTitle = 'password mismatch';
	}
	
	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateOPassword() {
	var elem = '#o_password';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	}

	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateEmail() {
	var elem = "#email";
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else { // email is not empty but...
		var validEmail = /\S+@\S+\.\S+/g.test($(elem).val()); // temp checker just to patch things up
		if(!validEmail || hasWhiteSpace(elem)) { // check...
			hasError = true;
			popoverTitle = 'invalid';
		} else {
			$.ajax({
				url: basepath + 'signup/validate',
				data: { email: $(elem).val() },
				success: function(data) {
					var response = eval('(' + data + ')'); // decode callback data
					if(response != '') {
						$(elem).siblings('[class*="form-control-feedback"]').removeClass(icon);
						$(elem).parent().removeClass(group);

						$(elem).attr('data-content', response); // set data content for popover

						$(elem).siblings('[class*="form-control-feedback"]').addClass(icon);
						$(elem).parent().addClass(group);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
				}
			});
		}
	}

	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateEmailNoChanges() { // if input email if same with current on db
	var elem = '#email';

	$(elem).next().removeClass(icon);
	$(elem).parent().removeClass(group);

	$.ajax({
		url: basepath + 'edit/validate',
		data: { email: $(elem).val() },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response != '') {
				$(elem).siblings('[class*="form-control-feedback"]').removeClass(icon);
				$(elem).parent().removeClass(group);

				$(elem).attr('data-content', response);

				$(elem).siblings('[class*="form-control-feedback"]').addClass(icon);
				$(elem).parent().addClass(group);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
		}
	});
}

function validateCEmail() {
	var elem = '#c_email';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else if($(elem).val() != $('#email').val()) { // check email mismatch
		hasError = true;
		popoverTitle = 'email mismatch';
	}
	
	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateFirstname() {
	var elem = '#firstname';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else if (isTooShort(elem, 2)) { // check if too short
		hasError = true;
		popoverTitle = 'too short';
	} else if (hasSpecialCharsV2(elem)) { // check for special chars
		hasError = true;
		popoverTitle = 'invalid';
	}
	
	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateLastname() {
	var elem = '#lastname';
	var hasError = false;
	var popoverTitle = '';

	if(isEmpty(elem)) { // check if empty
		hasError = true;
		popoverTitle = 'required';
	} else if (isTooShort(elem, 2)) { // check if too short
		hasError = true;
		popoverTitle = 'too short';
	} else if (hasSpecialCharsV2(elem)) { // check for special chars
		hasError = true;
		popoverTitle = 'invalid';
	}
	
	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function validateGender() {
	var elem = '[name="gender"]';
	var hasError = false;
	var popoverTitle = '';

	if($('input#male:checked').val() == null && 
		$('input#female:checked').val() == null) { // if no radio button is checked
		hasError = true;
		popoverTitle = 'required';
	}

	return { hasError: hasError, elem: elem, popoverTitle: popoverTitle };
}

function counterAbout() {
	var len = $('#about').val().length;
	$('#about_counter').val(255 - len);
}

function validateAll() { // all in one validation
	var validationList = [validateUsername, validatePassword, validateCPassword, 
		validateEmail, validateCEmail, validateFirstname, validateLastname, validateGender]; // validation list
	var len = validationList.length;

	for(var i = 0; i < len; i++) { // test every validation on list
		var validation = validationList[i]();

		$(validation['elem']).next().removeClass(icon);
		$(validation['elem']).parent().removeClass(group); // remove initial feedback and errors

		$(validation['elem']).attr('data-content', validation['popoverTitle']);

		if(validation['elem'] == '[name="gender"]') // remove feedback on radio btn
			$(validation['elem']).parents('[class*="form-group"]').removeClass(group);

		if(validation['hasError'] == true) { // add feedback and errors
			if(validation['elem'] != '[name="gender"]') {
				$(validation['elem']).next().addClass(icon);
				$(validation['elem']).parent().addClass(group);
				$(validation['elem']).popover();
			} else { // add feedback on radio btn
				$(validation['elem']).parents('[class*="form-group"]').addClass(group);
			}			
		}
	}
}

function validateChangePassword() { // on submit change password validation
	var validationList = [validateOPassword, validatePassword, validateCPassword];
	var len = validationList.length;

	for(var i = 0; i < len; i++) {
		var validation = validationList[i]();

		$(validation['elem']).next().removeClass(icon);
		$(validation['elem']).parent().removeClass(group);

		$(validation['elem']).attr('data-content', validation['popoverTitle']);
		if(validation['hasError'] == true) { // add feedback and errors
			$(validation['elem']).next().addClass(icon);
			$(validation['elem']).parent().addClass(group);
			$(validation['elem']).popover();
		}
	}
}

function validateChangeEmail() {
	var validationList = [validateEmail, validateCEmail];
	var len = validationList.length;

	for(var i = 0; i < len; i++) {
		var validation = validationList[i]();

		$(validation['elem']).next().removeClass(icon);
		$(validation['elem']).next().removeClass(group);

		$(validation['elem']).attr('data-content', validation['popoverTitle']);
		if(validation['hasError'] == true) {
			$(validation['elem']).next().addClass(icon);
			$(validation['elem']).parent().addClass(group);
			$(validation['elem']).popover();
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

	$('#about_counter').val(255); // char count indicator

	$('[data-toggle="popover"]').blur(function() { // run function depending on input blurred
		var response = {};

		$(this).siblings('[class*="form-control-feedback"]').removeClass(icon);
		$(this).parent().removeClass(group); // remove any initial error feedback and icon

		switch($(this).attr('name')) { // check every of focused input
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
				response = validateOPassword();
				break;
			case 'email':
				response = validateEmail();
				if($('#form_change_email') != 0)
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
				break;
			default:
				return;
				break;
		}

		$(this).attr('data-content', response['popoverTitle']); // set data content for popover
		if(response['hasError'] == true) { // set feedback and icon on error
			$(this).siblings('[class*="form-control-feedback"]').addClass(icon);
			$(this).parent().addClass(group);
		}
	});

	$('[data-toggle="popover"]').focus(function() { // set input w/ popover
		$(this).siblings('[class*="form-control-feedback"]').removeClass(icon);
		$(this).parent().removeClass(group);
		$(this).popover();
	});

	$('[name="gender"]').blur(function() { // check error on gender radio btn
		var response = validateGender();
		$(this).parents('[class*="form-group"]').removeClass(group); // remove initial feedback

		if(response['hasError'] == true) // set feedback on error
			$(this).parents('[class*="form-group"]').addClass(group);
	});

	$('[name="gender"]').focus(function() { // remove feedback on error
		$(this).parents('[class*="form-group"]').removeClass(group);
	});

	$('#about').keyup(function() {
		counterAbout();
	});

	$('#form_signup').submit(function() {
		validateAll(); // validate all input
		if($('.form-group').hasClass(group)) return false; // restrict submit
	});

	$('#form_edit_profile').submit(function() {
		validateFirstname();
		validateLastname();
		validateGender(); // some validations
		if($('span.error').text() != '') return false; // restrict submit
	});

	$('#form_change_email').submit(function() {
		validateChangeEmail();
		if($('.form-group').hasClass(group)) return false; // restrict submit
	});

	$('#form_change_password').submit(function() {
		validateChangePassword();
		if($('.form-group').hasClass(group)) return false; // restrict submit
	});

});