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

	}])