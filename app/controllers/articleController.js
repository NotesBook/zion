nbApp.controller('ArticleController', ['$scope','$routeParams','$location','ArticlesService','ValidationService','SharedDataService','UserService',
	function($scope,$routeParams,$location,ArticlesService,ValidationService,SharedDataService,UserService) {

		$scope.show_edit_button = false;

		$scope.show_text_angular = false;

		$scope.show_save_button = false;

		$scope.route_path = $location;

		// Get the article_id recibed by URL
		$scope.article_id = $routeParams.id;

		$scope.logged_user_data;

		$scope.article_data;

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {

			$scope.logged_user_data = response.data;

			// Get article data by ID
			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

				$scope.article_data = response.data;

				if ($scope.article_data.author_id == $scope.logged_user_data.id) {
					$scope.show_edit_buttons = true;
				} else $scope.show_edit_buttons = false;      
			});

		});

		


        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });	

		$scope.edit_article = function() {

			document.getElementById($scope.article_data.title).setAttribute("contenteditable", "true");
			$scope.show_text_angular = true;
			$scope.show_save_button = true;
		}    	

}])