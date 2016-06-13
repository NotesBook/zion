
nbApp.controller('UserController', ['$scope', '$routeParams', 'UserService',
	function($scope, $routeParams, UserService) { 

		$scope.user = {};

		var user_id = $routeParams.user_id;

		UserService.get_by_id(user_id).then(function(response) {
			$scope.user = response.data;
		});

	}]);