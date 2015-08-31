"use strict";
var basepath = 'http://localhost/jabburp/';
var url = basepath + 'contact/cancel'; // destination url

function removeStat() { // this function will exec the pending stat removal
	var data = { data: $('h3').text() }; // get the h3 tag; need for identifying w/c to remove
	$.post(url, data, function(data, status) { // ajax 
		if(status == 'success') { // if success
			var json = eval('(' + data + ')'); // decode callback data
			if(json == true) { // if decoded is true
				$('#contact_stat').val('add'); // change btn attr
				$('#contact_stat').text('add'); // change btn content
				$('#contact_stat').next().remove(); // remove sibling btn
			}
		}
	});
}

$(document).ready(function() { // main method
	if($('#contact_stat').val() == 'add') { // remove sibling if stat is add/no rel
		$('#negate_contact_stat').remove();
	}

	$('button').click(function() {
		switch($(this).attr('id')) { // run command depending on the button clicked
			case 'contact_stat':
				console.log($(this).val());
				break;
			case 'negate_contact_stat':
				removeStat(); // removal of pending request bet. 2 users
				break;
			default:
				//
				break;
		}
	});
});