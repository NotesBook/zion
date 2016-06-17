nbApp.controller('LoginController', ['$scope', '$routeParams', '$location', '$cookies', 'UserService', 'LoadingService', 'ModalService',
	function($scope, $routeParams, $location, $cookies, UserService, LoadingService, ModalService) { 

		LoadingService.showLoading();

		//TODO: Block Screen until validate session
		UserService.check_session_dashboard_redirection().then(function(response) {
  			if (response.data && response.data["active_session"])
  				$location.path("dashboard/");
  			else   				
				LoadingService.hideLoading();
  		});

		$scope.login_form_data = {
			'email':"",
			'password':""
		};


		//0. Check if it's user validation
		var token = $routeParams.token,
			email = $routeParams.email;
		
		//1. If registration, validate user

		if(token)
			UserService.validate(token, email).then(function(data) {
				if (data.valid) {
                   	
                   	ModalService.showModal(" ¡ Usuario validado con exito ! ", "Pulsa aceptar para ir al Login", true);

				} else {

					ModalService.showModal(" Este usuario ha sido activado anteriormente ", "", true);

				}
			});

		$scope.send_login_form_data = function() {

			UserService.send_login_form_data('POST','api/user/login', JSON.stringify($scope.login_form_data)).then(function(response) {
				if(response.valid == true) {
					$location.path("dashboard/");

					//add token to cookie
					$cookies.put("loginTokenCookie", response.data);
				} else {
                   	ModalService.showModal(" ¡ Usuario o contraseña incorrectos ! ", "Prueba de nuevo, o regístrate", true);
				}
			}, function (response) {

               	ModalService.showModal(" ¡ Usuario o contraseña incorrectos ! ", response.error, true);

			});
		};

	}]);