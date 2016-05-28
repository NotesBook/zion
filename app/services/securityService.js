nbApp.factory('SecurityService', ['AjaxService',
	function(AjaxService) {

		var self = {};

		self.checkSession = function() {			

			var method = 'get';
			var uri = 'api/user/check_session';

		    return AjaxService.send(method,uri);

		}

		return self;
	}
]);