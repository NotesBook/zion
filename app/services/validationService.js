nbApp.factory('ValidationService',['AjaxService',
	function(AjaxService) {

		var self = {};

		self.getValidationJSON = function(method,uri) {			

			var method = 'get';
			var uri = 'api/user/validationJson';

		    return AjaxService.send(method,uri);

		}

		return self;
	}
]);