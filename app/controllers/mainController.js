nbApp.controller('MainController', ['$scope', 'SecurityService','ClassroomsService','UserService','SharedDataService','ArticlesService','CategoriesService',
	function($scope, SecurityService,ClassroomsService,UserService,SharedDataService,ArticlesService,CategoriesService) {

		SecurityService.checkSession();

		$scope.classroom_form_data = {
            'name':"",
            'category': "",
            'subcategory':"",
            'description':"",          
        };

        // Get validation JSON  Object
        CategoriesService.getCategoriesJSON().then(function(response) {

            $scope.JSON_categories = response; 

        });           

		// Get logged in user data
		UserService.get_logged_user_data().then(function(response) {

			$scope.logged_user_data = response.data;
		});

		// Get all Classrooms by user
		ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {

			$scope.classrooms = response.data;
		});

		// Refresh the classroom side list when classroom is created
		$scope.refresh_classrooms = function() {

			ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {

			$scope.classrooms = response.data;
			});
		};

		// Set the value of the selected classroom to use anywhere
		$scope.class_view = function(classroom_item) {
			
			SharedDataService.set_val(classroom_item);
			 
		};

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

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_classroomForm = function() {
                
             document.getElementById('valid-classroom-modal').style.display='none';
        };        	      


        // Send the form input data to process it at backend
        $scope.send_classroom_form_data = function() {

            $scope.classroom_form_data['category'] = $scope.classroom_form_data['category'].category;

            $scope.classroom_form_data['subcategory'] = $scope.classroom_form_data['subcategory'].name;

            ClassroomsService.create_classroom('POST','api/classroom/register',JSON.stringify($scope.classroom_form_data)).then(function(response) {

                if(response.valid == true) {

                    document.getElementById('valid-classroom-modal').style.display='block';
                    document.getElementById('classroom-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        }        

	}])