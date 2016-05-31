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
                console.log(response);
                if(response.valid == true) {
                    $scope.show_valid_modal = true;
                } else $scope.show_valid_modal = false;

            });
         }         

}])