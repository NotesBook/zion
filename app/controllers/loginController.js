nbApp.controller('LoginController', ['$scope', '$routeParams', 'UserService','$location',
	function($scope, $routeParams, UserService,$location) { 

		$scope.login_form_data = {
			'name':"",
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
				console.log(response.valid);
				if(response.valid == false) {
					$location.path("user/register");
				}
			});
		};

	}]);