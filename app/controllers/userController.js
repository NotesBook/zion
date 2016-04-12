
nbApp.controller('userController', ['$scope', 'UserService',
	function($scope, UserService) { 

		$scope.users = UserService.getAll().then(
			// Se convierte en el resolve
			function(response) {
				

				 response.promise;
			},
			function(err) {
				debugger;
				 err.reject;
			});


	}]);