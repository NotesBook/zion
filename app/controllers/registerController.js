nbApp.controller('RegisterController', ['$scope','AjaxService',
	function($scope,AjaxService) { 
		
		$scope.username;
		$scope.surname;
        $scope.values = Array();
      
        AjaxService.angularRequest('api/config/country.json').then(function(response) {
        
            $scope.listCountries = response.data;

        });
	}]);