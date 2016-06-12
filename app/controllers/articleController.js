nbApp.controller('ArticleController', ['$scope','ArticlesService','ValidationService','SharedDataService','UserService',
	function($scope,ArticlesService,ValidationService,SharedDataService,UserService) {

		// Get the classroom object recived from dashboard
        $scope.classroom_item = SharedDataService.get_val();

		// ArticlesService.get_classroom_articles('GET',"api/classroom/last_articles",$scope.classroom_item.id).then(function(response) {
		// 	$scope.classroom_articles = response.data;
		// 	});	        

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {
			$scope.logged_user_data = response.data;
		});


        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });		
}])