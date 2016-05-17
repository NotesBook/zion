nbApp.controller('RegisterController', ['$scope','ValidationService','CountriesService',
	function($scope,ValidationService,CountriesService) { 

        $scope.name = "";
        $scope.surname = "";
        $scope.email = "";
        $scope.birthdate = "";
        $scope.country = "";
        $scope.password = "";

        $scope.error = false;
        $scope.incomplete = true;        

        // Get listCountries JSON object
        CountriesService.getListCountries().then(function(response) {
        
            $scope.listCountries = response;

        });

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {
            
            $scope.nameRegExp = response.data.name.substring(1,response.data.name.length-1);
            $scope.surnameRegExp = response.data.surname.substring(1,response.data.surname.length-1);
            $scope.passwordRegExp = response.data.password.substring(1,response.data.password.length-1);
            $scope.emailRegExp = response.data.email.substring(1,response.data.email.length-1);
            $scope.dateRegExp = response.data.date.substring(1,response.data.date.length-1);

        }); 

	}]);