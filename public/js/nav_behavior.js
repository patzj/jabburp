'use strict';
var pagePath;

function requestsNotification() {
	$.ajax({
		url: basepath + 'contact/notification',
		data: { data: true },
		success: function(data) {
			var response = eval('(' + data + ')');
			if(response != 0) {
				$('nav li a').eq(2).html('<span class="glyphicon glyphicon-th-list"></span>' +
					'&nbsp;Requests&nbsp;<span class="badge">' + response + '</span>');
			}

			setTimeout(functionrequestsNotification, 1000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus);
		}
	});
}

$(document).ready(function() {
	pagePath = location.pathname;

	switch(true) {
		case /\/jabburp\/edit/i.test(pagePath):
		case /\/jabburp\/profile\/view\/\S+/i.test(pagePath):
			$('nav li').eq(1).addClass('active');
			break;
		case /\/jabburp\/contact/i.test(pagePath):
			$('nav li').eq(2).addClass('active');
			break;
		case /\/jabburp\/search/i.test(pagePath):
			$('nav li').eq(3).addClass('active');
			break;
		case /\/jabburp/i.test(pagePath):
			$('nav li').eq(0).addClass('active');
			break;
		default:
			break;
	}

	requestsNotification();
});