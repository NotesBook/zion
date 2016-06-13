nbApp.controller('ArticleController', ['$scope','$routeParams','$location','ArticlesService','ValidationService','SharedDataService','UserService','LoadingService',
	function($scope,$routeParams,$location,ArticlesService,ValidationService,SharedDataService,UserService,LoadingService) {

		$scope.article_form_data = {
			'article_id': "",
            "classroom_id": "",
            "title": "",
            "body": "",
            "tags": "",
            "topic": ""
        }; 

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

		// Get likes count
		ArticlesService.get_likes_count($scope.article_id).then(function(response) {
			$scope.likes_count = response.data;
		}) 

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {

			$scope.logged_user_data = response.data;
			LoadingService.hideLoading();
			// Get article data by ID
			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

				$scope.article_data = response.data;
			
				LoadingService.hideLoading();

				if ($scope.article_data.author_id == $scope.logged_user_data.id) {
					$scope.show_edit_button = true;
				} else $scope.show_edit_buttons = false;      
			});
			
		});

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 
            LoadingService.hideLoading();
        });	

        $scope.like = function() {

        	ArticlesService.like($scope.article_id).then(function(response) {
        		if(response.valid == true) {
        			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

						$scope.article_data = response.data;
					
						LoadingService.hideLoading();

						if ($scope.article_data.author_id == $scope.logged_user_data.id) {
							$scope.show_edit_button = true;
						} else $scope.show_edit_buttons = false;      
					});

        		}
        	});

        }

        $scope.unlike = function() {

        	ArticlesService.unlike($scope.article_id);
        	$scope.unlikes = article_data.likes_count;        	
        }



		$scope.edit_article = function() {

			document.getElementById($scope.article_data.title).setAttribute("contenteditable", "true");

			$scope.article_form_data['body'] = $scope.article_data.body;
			// Show the text angular box when edit button is pressed
			$scope.show_text_angular = true;
			// Show the save button when edit button is pressed
			$scope.show_save_button = true;	

			$scope.hide_body_content = true;

		}    

		$scope.save_edited_article = function() {

			$scope.article_form_data['title'] = $scope.article_data.title;
			$scope.article_form_data['tags'] = $scope.article_data.tags;
			$scope.article_form_data['topic'] = $scope.article_data.topic;
			$scope.article_form_data['classroom_id'] = $scope.article_data.id;
			$scope.article_form_data['article_id'] = $scope.article_data.classroom_id;					
			
			ArticlesService.edit_article(JSON.stringify($scope.article_form_data));

		};

}])