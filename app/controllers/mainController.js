nbApp.controller('MainController', ['$scope', '$cookies', '$window','SecurityService','ClassroomsService','UserService','SharedDataService','ArticlesService','CategoriesService', 'LoadingService',
	function($scope, $cookies,$window, SecurityService,ClassroomsService,UserService,SharedDataService,ArticlesService,CategoriesService, LoadingService) { 

		// Get all Dashboard articles
		ArticlesService.get_dashboard_articles('GET',"api/dashboard/last_articles").then(function(response) {

			$scope.dashboard_articles = response.data;

            LoadingService.hideLoading();
		});	

	}])