var url = './service/verify_form_input.php'; // destination url for ajax/post

function verifyUsername() {
	var result = ''; // reserved variable for future use

	if(isEmpty('#username')) { // check if empty
		$('#username').next().text('*');
	} else {
		if(isTooShort('#username', 4)) { // check if too short
			$('#username').next().text('too short');
		} else if(isIndexNumeric('#username', 0)) { // check first char if numeric
			$('#username').next().text('invalid');
		} else if(isThereSpecialChars('#username')) {  // check for special chars
			$('#username').next().text('invalid');
		} else {
			$('#username').next().text('');
			var data = {username: $('#username').val()}; // set data from input to ajax/post
			$.post(url, data, function(data, status) {
				if(status == 'success') { // if success
					var json = eval('(' + data + ')'); // get encoded result
					$('#username').next().text(json); // display result
				}
			});
		}
	}
}

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

function isThereSpecialChars(selector) { // for checking special chars
	return /[`~!@#$%^&*()-+=\[{\]}\\|;:\'\",<>?]/g.test($(selector).val());
}

$(document).ready(function() {
	$('#username').blur(function() {
		verifyUsername();
	})
});