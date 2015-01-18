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
			callback.call(this, response);
		}, 'json');
	};

	window.initiate_mock = function(params) {
		console.log(params);
	};
})(jQuery, window);