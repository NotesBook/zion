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

				$scope.article = response.data;

		        $scope.article_form_data.body = response.data.body;
			
				LoadingService.hideLoading();  

			});

		} else {

				LoadingService.hideLoading();

		}


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

        $scope.show_user_info = function(userid) {

			debugger;

			$scope.show_user_info_modal;

			return;

            UserService.get_by_id(userid).then(function(response) {

                debugger;

            });

        };

}])