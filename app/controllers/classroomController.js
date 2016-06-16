nbApp.controller('ClassRoomController',['$scope', '$routeParams', 'LoadingService', 'ValidationService', 'CategoriesService', 'ClassroomsService','SharedDataService','ArticlesService','UserService','$window',
	function($scope, $routeParams, LoadingService, ValidationService, CategoriesService,ClassroomsService,SharedDataService,ArticlesService,UserService,$window) {

        /* This line is include to show articles menu in classroom view */
        $scope.show_menu_articles = true;

        $scope.classroom_id = $routeParams.classroom_id;

        // --- SERVICES ---

        //1. Get the classroom object recived from dashboard
        ClassroomsService.get_classroom($scope.classroom_id)
            .then(function (response){

                $scope.classroom_item = response.data;
                //2. Get all classroom articles by id
                $scope.refresh_articles();

            });  

        // --- METHODS ---                                 

        // Refresh the classroom side list when classroom is created
        $scope.refresh_articles = function() {

            ArticlesService.get_last_articles($scope.classroom_id).then(function(response) {

                $scope.last_classroom_articles = response.data;
                LoadingService.hideLoading(); 

            });

        }; 

        $scope.like = function(article_id) {

            LoadingService.showLoading();  

            ArticlesService.like(article_id).then(function(response) {

                if(response.valid) {

                    $scope.refresh_articles();

                }

            });

        };

        $scope.unlike = function(article_id) {

            LoadingService.showLoading();  

            ArticlesService.unlike(article_id).then(function(response) {

                if(response.valid) {

                    $scope.refresh_articles();

                }

            });

        };

}])