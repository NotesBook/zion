nbApp.controller('RegisterController', ['$scope','ValidationService','CountriesService','UserService',
	function($scope,ValidationService,CountriesService,UserService) { 

        //TODO: Block Screen until validate session
        UserService.check_session_dashboard_redirection().then(function(response) {
            if (response.data && response.data["active_session"])
                $location.path("dashboard/");
        });

        $scope.show_valid_modal;

        $scope.register_form_data = {
            'name':"",
            'surname':"",
            'birthdate':"",
            'country':"",
            'region':"",
            'email':""            
        };
        
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

            UserService.send_register_form_data('post','api/user/register',JSON.stringify($scope.register_form_data)).then(function(response) {
                if(response.valid == true) {
                    $scope.show_valid_modal = true;
                } else $scope.show_valid_modal = false;

            });
         };

	}]);