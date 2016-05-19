nbApp.controller('RegisterController', ['$scope','ValidationService','CountriesService','AjaxService',
	function($scope,ValidationService,CountriesService,AjaxService) { 

        $scope.form_data = Array();
        $scope.form_data['name'] = "";
        $scope.form_data['surname'] = "";
        $scope.form_data['email'] = "";
        $scope.form_data['birthdate'] = "";
        $scope.form_data['country'] = "";
        $scope.form_data['name'] = "";    

        // Get listCountries JSON object
        CountriesService.getListCountries().then(function(response) {
        
            $scope.listCountries = response;

        });

        // Get validation JSON  Object
         ValidationService.getValidationJSON().then(function(response) {

           $scope.JSON_validation = response; 

        });
         
         $scope.send_form_data = function() {
            
            console.log($scope.form_data);

            AjaxService.send('POST','api/user/register',$scope.form_data);
         }


	}]);