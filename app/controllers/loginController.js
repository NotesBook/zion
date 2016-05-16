nbApp.controller('LoginController', ['$scope', '$routeParams', 'UserService',
	function($scope, $routeParams, UserService) { 
		
		//0. Check if it's user validation
		var token = $routeParams.token,
			email = $routeParams.email;
		
		//1. If registration, validate user
		if(token)
			UserService.validate(token, email).then(function(data) {
				debugger;
			});



	}]);