nbApp.controller('ArticleController', ['$scope','ArticlesService','ValidationService','SharedDataService','UserService',
	function($scope,ArticlesService,ValidationService,SharedDataService,UserService) {

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {
			$scope.logged_user_data = response.data;
		});


        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });		
}])