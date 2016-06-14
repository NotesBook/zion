nbApp.controller('ArticleController', ['$scope', '$routeParams', '$route', '$location', 'ArticlesService','ValidationService','SharedDataService','UserService','LoadingService','ClassroomsService',
	function($scope, $routeParams, $route, $location, ArticlesService,ValidationService,SharedDataService,UserService,LoadingService,ClassroomsService) {

		$scope.article_form_data = {
			article_id : undefined,
            classroom_id : "",
            title : "",
            body : "",
            tags : "",
            topic : ""
        }; 

		LoadingService.showLoading();

		// Get the article_id recibed by URL

		
		$scope.article_id = $routeParams.article_id || $routeParams.id;
		$scope.article_is_viewing = $routeParams.article_id;
		$scope.classroom_id = $routeParams.classroom_id;
		$scope.article_is_new = $routeParams.id == "new";
		$scope.article_is_editting = !$scope.article_is_new;

		$scope.article_data;

		if ($scope.article_is_editting || $scope.article_is_viewing) {

			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

				$scope.article = {
					id : response.data.id,
		            classroom_id : response.data.classroom_id,
		            title : response.data.title,
		            body : response.data.body,
		            tags : response.data.tags,
		            topic : response.data.topic
		        }; 

		        $scope.article_form_data.body = response.data.body;
			
				LoadingService.hideLoading();  

			});

		} else {

				LoadingService.hideLoading();

		}

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
     //    $scope.like = function() {

     //    	ArticlesService.like($scope.article_id).then(function(response) {
     //    		if(response.valid == true) {
     //    			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

					// 	$scope.article_data = response.data;
					
					// 	LoadingService.hideLoading();
					// });
     //    		}
     //    	});
     //    }

        // // Add unlike to article when thumbs-up is clicked
     //    $scope.unlike = function() {

     //    	ArticlesService.unlike($scope.article_id).then(function(response) {
     //    		if(response.valid == true) {
     //    			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

					// 	$scope.article_data = response.data;
						
					// 	LoadingService.hideLoading();
  
					// });
  	  //    		}
     //    	});

     //    }


		$scope.save = function() {

			$scope.article_form_data.classroom_id = $scope.classroom_id;

			//TODO: REDO. It's to get dirty field of form data
			$scope.article_form_data.article_id = $scope.article.id;
			$scope.article_form_data.body = $scope.article.body;
			$scope.article_form_data.title = $scope.article_form_data.title || $scope.article.title;
			$scope.article_form_data.tags = $scope.article_form_data.tags || $scope.article.tags;
			$scope.article_form_data.topic = $scope.article_form_data.topic || $scope.article.topic;

			ArticlesService.save_article(JSON.stringify($scope.article_form_data)).then(function(response) {

				$location.path("classroom/" + $scope.classroom_id + "/article/" + response.data);

			});

		};	

}])