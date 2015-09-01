"use strict";
var basepath = 'http://localhost/jabburp/';
var url = basepath + 'contact/cancel'; // destination url

function removeStatus() { // this function will exec the pending stat removal
	var data = { data: $('h3').text() }; // get the h3 tag; need for identifying w/c to remove
	$.post(url, data, function(data, status) { // ajax 
		if(status == 'success') { // if success
			var json = eval('(' + data + ')'); // decode callback data
			if(json == true) { // if decoded is true
				$('#btn_cs').val('add'); // change btn attr
				$('#btn_cs').text('add'); // change btn content
				$('#btn_cs').next().remove(); // remove sibling btn
			}
		}
	});
}

function confirmRequest() { // this function will confirm the request

}

$(document).ready(function() { // main method
	switch($('#btn_cs').val()) {
		case 'add': // remove sibling btn if status is add/no rel
			$(this).next().remove();
			break;
		case 'pending':
			$('#btn_cs').prop({disabled: true});
			break;
		default:
			//
			break;
	}

	$('button').click(function() {
		switch($(this).attr('id')) { // run command depending on the button clicked
			case 'btn_cs':
				switch($(this).val()) {
					case 'confirm':
						
						break;
					default:
						console.log($(this).value);
						break;
				}
				break;
			case 'btn_null_cs':
				removeStatus(); // removal of pending request bet. 2 users
				break;
			default:
				//
				break;
		}
	});
});