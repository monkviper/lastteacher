(function($, window) {
	var _ajax_url = lt_ajax_url;
	var _ajax_nonce = lt_ajax_nonce;
	var ajax = function(action, params, callback) {
		params = params || {};
		if(!$.isObject(params)) {
			params = {};
		}
		params.action = action;
		params._ajax_nonce = _ajax_nonce;
		$.post(_ajax_url, params, function(response) {
			callback.apply(this, arguments);
		}, 'json');
	};

	var container = $('#mock');
	var placeholder = $('#placeholder');
	var main = $('#main');
	var paused = $('#paused');
	var instructions = $('#instructions');
	var finished = $('#finished');

	var new_mock_session = function(mock_id) {
		container.addClass('preparing');
		ajax('register_new_mock', {mock: mock_id}, function(response) {
			if(response.error) {
				alert(response.message);
				if('undefined' != typeof response.redirect && response.redirect) {
					window.location.href = response.redirect;
				} else if('undefined' != typeof response.reload && response.reload) {
					window.location.reload(true);
				}
			} else {
				//@todo new mock session created, and loaded, save the info and show the appropriate forms to user
			}
		});
	};

	window.initiate_mock = function(params) {
		console.log(params);
	};
})(jQuery, window);