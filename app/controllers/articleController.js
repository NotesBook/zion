nbApp.controller('ArticleController', ['$scope','$routeParams','$location','ArticlesService','ValidationService','SharedDataService','UserService','LoadingService','ClassroomsService',
	function($scope,$routeParams,$location,ArticlesService,ValidationService,SharedDataService,UserService,LoadingService,ClassroomsService) {

		$scope.article_form_data = {
			'article_id': "",
            "classroom_id": "",
            "title": "",
            "body": "",
            "tags": "",
            "topic": ""
        }; 

		$scope.create_article_form_data = {
            "classroom_id": "",
            "title": "",
            "body": "",
            "tags": "",
            "topic": ""
        };         



		$scope.show_edit_view = false;

		$scope.show_read_view = true;

		$scope.show_create_view = false;		

		$scope.show_edit_button = false;

		$scope.show_text_angular = false;

		$scope.show_save_button = false;

		$scope.hide_body_content = false;

		$scope.route_path = $location;

		LoadingService.hideLoading();

		// Get the article_id recibed by URL
		//TODO: Unccoment
		//$scope.article_id = $routeParams.id;

		$scope.logged_user_data;

		$scope.article_data;

		$scope.body_content;

		// Get logged in user data
		//TODO: Unccoment
		// UserService.get_logged_user_data().then(function(response) {

		// 	$scope.logged_user_data = response.data;
		// 	LoadingService.hideLoading();
		// 	// Get article data by ID
		// 	ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

		// 		$scope.article_data = response.data;
			
		// 		LoadingService.hideLoading();

		// 		if ($scope.article_data.author_id == $scope.logged_user_data.id) {
		// 			$scope.show_edit_button = true;
		// 		} else $scope.show_edit_buttons = false;      
		// 	});
			
		// });

        // Add like to article when thumbs-up is clicked
        $scope.like = function() {

        	ArticlesService.like($scope.article_id).then(function(response) {
        		if(response.valid == true) {
        			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

						$scope.article_data = response.data;
					
						LoadingService.hideLoading();
					});
        		}
        	});
        }

        // // Add unlike to article when thumbs-up is clicked
        $scope.unlike = function() {

        	ArticlesService.unlike($scope.article_id).then(function(response) {
        		if(response.valid == true) {
        			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

						$scope.article_data = response.data;
						
						LoadingService.hideLoading();
  
					});
  	     		}
        	});

        }


		$scope.show_edit_article_view = function() {

			$scope.show_edit_view = true;
			$scope.show_read_view = false;
			$scope.show_create_view = false;

		}    

		$scope.show_create_article_view = function() {

			$scope.show_edit_view = false;
			$scope.show_read_view= false;
			$scope.show_create_view = true;

		} 

		$scope.save_new_article = function() {
			
			$scope.create_article_form_data['classroom_id'] = $scope.article_data.classroom_id;

			ArticlesService.save_article(JSON.stringify($scope.create_article_form_data));

		};		

		$scope.save_edited_article = function() {

			$scope.article_form_data['title'] = $scope.article_data.title;
			$scope.article_form_data['tags'] = $scope.article_data.tags;
			$scope.article_form_data['topic'] = $scope.article_data.topic;
			$scope.article_form_data['classroom_id'] = $scope.article_data.id;
			$scope.article_form_data['article_id'] = $scope.article_data.classroom_id;
			$scope.article_form_data['body'] = $scope.article_data.body;					

			ArticlesService.save_article(JSON.stringify($scope.article_form_data));

		};

}])