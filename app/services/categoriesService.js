nbApp.factory('CategoriesService',['AjaxService',
	function(AjaxService) {

		var self = {};

		self.getCategoriesJSON = function() {			
			
			var method = 'get';
			var uri = 'api/config/categories.json';

			return AjaxService.send(method,uri);
			
		}
		
		return self;
	}
]);
