nbApp.controller('RegisterController', ['$scope','AjaxService',
	function($scope,AjaxService) { 
		
		$scope.username;
		$scope.surname;
    $scope.values = Array();
      
     AjaxService.angularGetCountries().then(function(response){
        
      $scope.listCountries = response;

      console.log(response);

      });

  		// $scope.checkName = function(username) {

  		// 	var username;

  		// 	// console.log(formItem)
  		// 	if(username == "true") {
  				
  		// 		this.username = "VALIDO";
  		// 	}else this.username = "INVALIDO";
  		// 	console.log(username);
  		// }

  		// $scope.checkSurname = function(surname) {

  		// 	var surname;

  		// 	// console.log(formItem)
  		// 	if(surname == "true") {
  				
  		// 		this.surname = "VALIDO";
  		// 	}else this.surname = "INVALIDO";
  		// 	console.log(surname);
  		// }  		
		

	}]);