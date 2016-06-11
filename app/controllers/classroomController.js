nbApp.controller('ClassRoomController',['$scope', 'ValidationService', 'CategoriesService', 'ClassroomsService','SharedDataService',
	function($scope, ValidationService, CategoriesService,ClassroomsService,SharedDataService) {

        $scope.form_data = {
            'name':"",
            'category': "",
            'subcategory':"",
            'description':"",          
        };

        // Get the classroom object recived from dashboard
        $scope.classroom = SharedDataService.get_val();

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });

        // Get validation JSON  Object
        CategoriesService.getCategoriesJSON().then(function(response) {

            $scope.JSON_categories = response; 

        });         

        // Send the form input data to process it at backend
        $scope.send_form_data = function() {

            $scope.form_data['category'] = $scope.form_data['category'].category;

            $scope.form_data['subcategory'] = $scope.form_data['subcategory'].name;

            ClassroomsService.create_classroom('POST','api/classroom/register',JSON.stringify($scope.form_data)).then(function(response) {

                if(response.valid == true) {

                    document.getElementById('valid-classroom-modal').style.display='block';
                    document.getElementById('classroom-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        }

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_classroomForm = function() {
                
             document.getElementById('valid-classroom-modal').style.display='none';
        };

}])