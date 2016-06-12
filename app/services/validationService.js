nbApp.factory('ValidationService',['AjaxService',
	function(AjaxService) {

		var self = {};

		self.getValidationJSON = function() {			
			
			var method = 'get';
			var uri = 'api/user/validationJson';

			var JSON_promise = AjaxService.send(method,uri).then(function(response) {

				for (var key in response.data) {

                response.data[key] = response.data[key].substring(1,response.data[key].length-1);

            	};

            	return response.data;
			});

	
			return JSON_promise;
			
		}
		
		return self;
	}
]);
