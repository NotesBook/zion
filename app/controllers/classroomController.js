nbApp.controller('ClassRoomController',['$scope', 'ValidationService', 'CategoriesService', 'SiteService',
	function($scope, ValidationService, CategoriesService,SiteService) {

        $scope.form_data = {
            'name':"",
            'category':"",
            'subcategory':"",
            'description':"",          
        };

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

            SiteService.create_classroom('POST','api/classroom/register',JSON.stringify($scope.form_data)).then(function(response) {

                if(response.valid == true) {

                    document.getElementById('valid_classroom_modal').style.display='block';
                    document.getElementById('classroom-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;

            });
        }

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_classroomForm = function() {
                
             $scope.accepted = true;
        };

}])