nbApp.controller('SetupController', ['$scope', 'UserService', 'LoadingService', 'CountriesService', 'ValidationService', 'ModalService',
	function($scope, UserService, LoadingService, CountriesService, ValidationService, ModalService) { 

		$scope.user = {};

		LoadingService.showLoading();

        $scope.user_form_data = {};

        // Get logged in user data
        UserService.get_logged_user_data().then(function(response) {

            $scope.user = response.data;
            $scope.user_form_data = response.data;

            $scope.user_form_data.birthdate_input = new Date(response.data.birthdate.split('/')[2], response.data.birthdate.split('/')[1], response.data.birthdate.split('/')[0]);

			LoadingService.hideLoading();

        });  

        $scope.UserService = UserService;
        $scope.upload_avatar = function() {
            LoadingService.showLoading();
        	
   		 	var file_data = $('#setup_avatar').prop('files')[0];  
        	this.UserService.upload_avatar(file_data).then(function(response) {

                $scope.logged_user_data.avatar_src = response.data;
                LoadingService.hideLoading();

            });

        };
                
        // Get listCountries JSON object
        CountriesService.getListCountries().then(function(response) {
        
            $scope.listCountries = response;

        });

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {
            
           $scope.JSON_validation = response; 
           
        });

        $scope.send_user_form_data = function() {

            LoadingService.showLoading();

            UserService.send_user_form_data(JSON.stringify($scope.user_form_data)).then(function(response) {

                if (response.valid) {

                    ModalService.showModal("¡ Datos Actualizados !", "", true);

                } else {

                    ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true);

                }

                LoadingService.hideLoading();

            }, function () {

                    ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true, '#/dashboard');

                    LoadingService.hideLoading();
            });

        };

	}]);