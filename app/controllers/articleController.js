nbApp.controller('ArticleController', ['$scope','$routeParams','$location','ArticlesService','ValidationService','SharedDataService','UserService','LoadingService',
	function($scope,$routeParams,$location,ArticlesService,ValidationService,SharedDataService,UserService,LoadingService) {

		LoadingService.showLoading();

		$scope.show_edit_button = false;

		$scope.show_text_angular = false;

		$scope.show_save_button = false;

		$scope.hide_body_content = false;

		$scope.route_path = $location;

		// Get the article_id recibed by URL
		$scope.article_id = $routeParams.id;

		$scope.logged_user_data;

		$scope.article_data;

		$scope.body_content;

				

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {

			$scope.logged_user_data = response.data;
			LoadingService.hideLoading();
			// Get article data by ID
			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

				$scope.article_data = response.data;

				LoadingService.hideLoading();

				if ($scope.article_data.author_id == $scope.logged_user_data.id) {
					$scope.show_edit_buttons = true;
				} else $scope.show_edit_buttons = false;      
			});
		});

		$scope.edit_title ="";	


        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 
            LoadingService.hideLoading();
        });	

		$scope.edit_article = function() {

			document.getElementById($scope.article_data.title).setAttribute("contenteditable", "true");

			// Show the text angular box when edit button is pressed
			$scope.show_text_angular = true;
			// Show the save button when edit button is pressed
			$scope.show_save_button = true;
			$scope.body_content = $scope.article_data.body;
			$scope.hide_body_content = true;
			$scope.edit_title = "Editar el titulo: ";
		}    	

}])