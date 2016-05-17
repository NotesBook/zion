nbApp.controller('RegisterController', ['$scope','ValidationService','CountriesService',
	function($scope,ValidationService,CountriesService) { 

        $scope.username = "";
        $scope.surname = "";
        $scope.mail = "";
        $scope.date = "";
        $scope.country = "";

        $scope.error = false;
        $scope.incomplete = true;        

        // Cargo el JSON con el listado de paises
        CountriesService.getListCountries().then(function(response) {
        
            $scope.listCountries = response;

        });

        // Cargo el JSON de validaciones
        ValidationService.getValidationJSON().then(function(response) {
            
            $scope.json = response.data;
            $scope.nameRegExp = response.data.name;
            $scope.surnameRegExp = response.data.name;
            $scope.mailRegExp = response.data.mail;
            $scope.dateRegExp = response.data.date;

        });        	

        $scope.$watch('username',function() { $scope.test(); } );
        // $scope.$watch('surname',function() { $scope.test(); } );

        $scope.test = function() {

             (!$scope.username.match($scope.nameRegExp)) ? $scope.incomplete = true : $scope.incomplete = false;
            
        };       

	}]);