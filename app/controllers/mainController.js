nbApp.controller('MainController', ['$scope', 'SecurityService','ClassroomsService','UserService','SharedDataService',
	function($scope, SecurityService,ClassroomsService,UserService,SharedDataService) {

		SecurityService.checkSession();

		// Get logged in user data
		UserService.get_loged_user_data().then(function(response) {
			$scope.logged_user_data = response.data;
		})


		// Get all Classrooms by user
		ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {

			$scope.classrooms = response.data;
		})

		// Refresh the classroom side list when classroom is created
		$scope.refresh_classrooms = function() {

			ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {
			$scope.classrooms = response.data;
			})
		}

		// Set the value of the selected classroom to use anywhere
		$scope.class_view = function(classroom_item) {
			
			SharedDataService.set_val(classroom_item);
			 
		}

		// Used to toggle the menu on smaller screens when clicking on the menu button
	 	$scope.openNav = function() {
		    var x = document.getElementById("navToogle");
		    if (x.className.indexOf("w3-show") == -1) {
		        x.className += " w3-show";
		    } else { 
		        x.className = x.className.replace(" w3-show", "");
		    }
		};

		// Display the modal form to create a classroom
        $scope.show_form_classroom_modal = function() {
            document.getElementById('classroom-modal').style.display='block';
        };		

		// Display the modal form to create a classroom
        $scope.show_form_article_modal = function() {
        	document.getElementById('article-modal').style.display='block';
        };		

         

	}])