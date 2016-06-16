nbApp.controller('ArticleController', ['$scope', '$routeParams', '$window', '$route', '$location', 'ArticlesService','ValidationService','SharedDataService','UserService','LoadingService','ClassroomsService',
	function($scope, $routeParams, $route, $window, $location, ArticlesService,ValidationService,SharedDataService,UserService,LoadingService,ClassroomsService) {

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

			refresh_article();

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

		$scope.edit_article = function(classroom_id, article_id) {

			$location.path("classroom/" + classroom_id + "/article/" + article_id + "/edit");

		};

		$scope.redirect_to_classroom = function(classroom_id) {
			$location.path("classroom/" + classroom_id);
		} 

		$scope.show_edit_button = function() {

			if ($scope.logged_user_data)
				return $scope.article.author_id = $scope.logged_user_data.id;

		};

		$scope.like = function(article_id) {

			LoadingService.showLoading();  

			ArticlesService.like(article_id).then(function(response) {

				if(response.valid) {

					refresh_article();

				}

			});

		};

		$scope.unlike = function(article_id) {

			LoadingService.showLoading();  

			ArticlesService.unlike(article_id).then(function(response) {

				if(response.valid) {

					refresh_article();

				}

			});

		};


		function refresh_article() {
			
			ArticlesService.get_article_by_id($scope.article_id).then(function(response) {

				$scope.article = response.data;

		        $scope.article_form_data.body = response.data.body;
			
				LoadingService.hideLoading();  

			});

		}

        $scope.modal_user_info = {};
        $scope.modal_user_info.show = false;

        $scope.$watch('modal_user_info.show', function(show) {

            if (show)
                $scope.modal_user_info.style = { "display" : "block" };
            else
                $scope.modal_user_info.style = {};

        });
        

        $scope.launch_user_info_modal = function(user_id) {

            UserService.get_by_id(user_id).then(function(response) {

                $scope.modal_user_info = response.data;
                return $scope.modal_user_info.show = true;

            });

           
        }; 

        $scope.close_user_info_modal = function() {

            return $scope.modal_user_info.show = false;

        };


}])