nbApp.controller('MainController', ['$scope', '$cookies', '$window','SecurityService','ClassroomsService','UserService','SharedDataService','ArticlesService','CategoriesService', 'LoadingService',
	function($scope, $cookies,$window, SecurityService,ClassroomsService,UserService,SharedDataService,ArticlesService,CategoriesService, LoadingService) { 

		// Get all Dashboard articles
		refresh_articles();

		function refresh_articles() {

			ArticlesService.get_dashboard_articles().then(function(response) {

				$scope.dashboard_articles = response.data;

	            LoadingService.hideLoading();
			});	

		}

        $scope.like = function(article_id) {

            LoadingService.showLoading();  

            ArticlesService.like(article_id).then(function(response) {

                if(response.valid) {

                    refresh_articles();

                }

            });

        };

        $scope.unlike = function(article_id) {

            LoadingService.showLoading();  

            ArticlesService.unlike(article_id).then(function(response) {

                if(response.valid) {

                    refresh_articles();

                }

            });

        };

        /* --------------- */


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