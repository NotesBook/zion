nbApp.controller('RegisterController', ['$scope', 'ValidationService', 'CountriesService', 'UserService', 'ModalService', 'LoadingService',
	function($scope, ValidationService, CountriesService, UserService, ModalService, LoadingService) { 

        LoadingService.showLoading();

        //TODO: Block Screen until validate session
        UserService.check_session_dashboard_redirection().then(function(response) {
            if (response.data && response.data["active_session"]) {

                $location.path("dashboard/");

            } else {

                $scope.register_model = {};

                $scope.$watch('register_model.email', function() {
                    
                        UserService.check_email_exists($scope.register_model.email).then(function(response) {

                            if(!response.valid) {
                                $scope.email_is_used = true;
                            } else {
                                $scope.email_is_used = false;
                            }

                        });

                });

                $scope.$watch('register_model.birthdate_input', function() {
                    if ($scope.register_model.birthdate_input) {
                          function pad(s) { return (s < 10) ? '0' + s : s; }
                          var d = $scope.register_model.birthdate_input;
                          $scope.register_model.birthdate = [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
                    }
                     
                });
                
                // Get listCountries JSON object
                CountriesService.getListCountries().then(function(response) {
                
                    $scope.listCountries = response;

                });

                // Get validation JSON  Object
                ValidationService.getValidationJSON().then(function(response) {
                    
                   $scope.JSON_validation = response; 
                   
                });
                 
                // Send the form input data to process it at backend
                $scope.send_register_form_data = function() {

                    LoadingService.showLoading();

                    UserService.send_register_form_data(JSON.stringify($scope.register_model)).then(function(response) {

                        if (response.valid) {
                            ModalService.showModal("¡ Usuario registrado con exito !", "Verifica tu email para validar la cuenta", true);
                        } else {
                            ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true);
                        }

                        LoadingService.hideLoading();

                    }, function () {

                            ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true, '#/user/register');

                            LoadingService.hideLoading();
                    });
                };

                LoadingService.hideLoading();

            }
        });

	}]);