nbApp.controller('MainController', ['$scope', 'SecurityService','ClassroomsService','UserService','SharedDataService',
	function($scope, SecurityService,ClassroomsService,UserService,SharedDataService) {

		SecurityService.checkSession();

		// Get logged in user data
		// UserService.get_user_by_id().then(function(response) {
		// 	console.log(response);
		// })


		// Get all Classrooms by user
		ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {

			$scope.classrooms = response.data;
		})

		// Set the value of the classroom to use anywhere
		$scope.class_view = function(class_view) {
			
			SharedDataService.set_val(class_view);
			 
		}

		// Test classroom groups on side menu
		$scope.groups = [
			{ 	
				id: 1,
				nombre: 'Aula 1',
			},
			{ 	
				id: 2,
				nombre: 'Aula 2',
			}			
		]

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