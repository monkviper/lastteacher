(function($, window) {
	// ajax related
	var _ajax_url = lt_ajax_url;
	var _ajax_nonce = lt_ajax_nonce;
	var ajax = function(action, params, callback) {
		params = params || {};
		params.action = action;
		params._ajax_nonce = _ajax_nonce;
		$.post(_ajax_url, params, function(response) {
			callback.apply(this, arguments);
		}, 'json');
	};

	// major variables needed throughout
	var container = $('#mock');
	var placeholder = $('#placeholder');
	var main = $('#main');
	var paused = $('#paused');
	var instructions = $('#instructions');
	var finished = $('#finished');

	// timing related, these functions can not be treated for absolute times, only use them to get time intervals, also this is unreliable because it depends on the system clock
	var time = (function() {
		var time = {};

		// a polyfill for Date.now() for ancient browsers
		if (!Date.now) {
			Date.now = function() {
				return new Date().getTime();
			};
		}

		// using the highest resolution timer available for use, performance.now() for newest browsers or fallback to same old method for old browsers
		if (window.performance.now) {
			time.getTimestamp = function() {
				return window.performance.now();
			};
		} else {
			if (window.performance.webkitNow) {
				time.getTimestamp = function() {
					return window.performance.webkitNow();
				};
			} else {
				time.getTimestamp = (function() {
					var current = Date.now();
					setInterval(function() {
						var next = Date.now();
						var diff = Math.abs(next - (current + 100));
						if(100 < diff) {
							current = next;
						} else {
							current += 100;
						}
					}, 100);
					return function() {
						return current;
					};
				})();
			}
		}

		return time;
	})();

	// functions to handle the app
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
				console.log(response);
				//@todo new mock session created, and loaded, save the info and show the appropriate forms to user
			}
		});
	};

	window.initiate_mock = function(params) {
		console.log(params);
		new_mock_session(params.ID);
	};
})(jQuery, window);