
nbApp.controller('UserController', ['$scope', 'UserService',
	function($scope, UserService) { 

		UserService.getAll().then(
			// Se convierte en el resolve
			function(usersJSON) {
				$scope.users = usersJSON;
			},
			function(err) {
				alert("ERROR EN USER CONTROLLER");
			});

	}]);