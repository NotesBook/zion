nbApp.controller('LoginController', ['$scope', '$routeParams', '$location', '$cookies', 'UserService',
	function($scope, $routeParams, $location, $cookies, UserService) { 

		$scope.login_form_data = {
			'email':"",
			'password':""
		};


		//0. Check if it's user validation
		var token = $routeParams.token,
			email = $routeParams.email;
		
		//1. If registration, validate user
		$scope.showValidateConfirmation = false;

		if(token)
			UserService.validate(token, email).then(function(data) {
				if(data["valid"] === true) {
					$scope.showValidateConfirmation = true;
				}
			});

		$scope.send_login_form_data = function() {

			UserService.send_login_form_data('POST','api/user/login', JSON.stringify($scope.login_form_data)).then(function(response) {
				if(response.valid == true) {
					$location.path("dashboard/");

					//add token to cookie
					$cookies.put("loginTokenCookie", response.data);
				}
			});
		};

		//TODO: Delete cookie loginTokenCookie when logout

	}]);