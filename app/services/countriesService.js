nbApp.factory('CountriesService',['AjaxService',
	function(AjaxService) {

		var self = {};

		self.getListCountries = function() {			

			var method = 'get';
			var uri = 'api/config/countries.json';

		    return AjaxService.send(method,uri);

		}

		return self;
	}
]);