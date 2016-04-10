
nbApp.controller('userController', ['$scope', 'UserService',
	function($scope, UserService) { 

		$scope.users = UserService.getAll();


	}]);