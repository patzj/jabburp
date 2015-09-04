"use strict";
var basepath = 'http://localhost/jabburp/';

function display_chat(other) { // other user param
	var url = basepath + 'chat/display'; // target url
	var data = { data: other };
	$.post(url, data, function(data, status) {
		if(status == 'success') {
			var response = eval('(' + data + ')');
			var len = response.length;
			if(len > 0) {
				$('#chat_output').empty();
				for(var i in response) {
					$('#chat_output').append('<p>[' + response[i]['date_time'] + ']' + 
						'uid' + response[i]['user'] + ' says: ' +
						response[i]['content'] +
					'</p>');
				}
			} else console.log('null response.');
		} else console.log('something went wrong.');
	});
}

$(document).ready(function() {
	$('#contact_list a').click(function() {
		var i = $(this).index();
		var other = $('h4').eq(i).text();
		display_chat(other);
		return false;
	});
});