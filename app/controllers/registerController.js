nbApp.controller('RegisterController', ['$scope','ValidationService','CountriesService','AjaxService',
	function($scope,ValidationService,CountriesService,AjaxService) { 

        $scope.show_valid_modal;

        $scope.form_data = Array();

        $scope.form_data = {
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
         $scope.send_form_data = function() {

            AjaxService.send('POST','api/user/register',JSON.stringify($scope.form_data)).then(function(response) {
                
                 if(response.valid == true) {
                    $scope.show_valid_modal = true;
                 } else $scope.show_valid_modal = false;

            });
         }


	}]);