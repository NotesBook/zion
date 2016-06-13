nbApp.controller('SetupController', ['$scope', 'UserService', 'LoadingService',
	function($scope, UserService, LoadingService) { 

		$scope.logged_user_data = {};

		LoadingService.showLoading();

        // Get logged in user data
        UserService.get_logged_user_data().then(function(response) {

            $scope.logged_user_data = response.data;

			LoadingService.hideLoading();

        });  


        $scope.UserService = UserService;
        $scope.upload_avatar = function() {
        	
   		 	var file_data = $('#setup_avatar').prop('files')[0];  
        	this.UserService.upload_avatar(file_data);

        };

	}]);