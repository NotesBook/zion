nbApp.controller('ClassRoomController',['$scope', 'ValidationService', 'CategoriesService', 'ClassroomsService','SharedDataService','ArticlesService','UserService',
	function($scope, ValidationService, CategoriesService,ClassroomsService,SharedDataService,ArticlesService,UserService) {

        $scope.classroom_form_data = {
            'name':"",
            'category': "",
            'subcategory':"",
            'description':"",          
        };

        $scope.article_form_data = {
            "classroom_id": "",
            "user_id": "",
            "title": "",
            "body": "",
            "tags": "",
            "topic": ""
        };     

        // Get the classroom object recived from dashboard
        $scope.classroom_item = SharedDataService.get_val();  

        // Get all classroom articles by id
        ArticlesService.get_last_articles("GET","api/classroom/last_articles/"+$scope.classroom_item.id).then(function(response) {

            $scope.last_classroom_articles = response.data;
            console.log($scope.last_classroom_articles);
        });

        // Get all Classrooms by user
        ClassroomsService.get_classrooms('GET',"api/dashboard/my_classrooms").then(function(response) {

            $scope.classroom_list = response.data;

        })      

        // Get validation JSON  Object
        ValidationService.getValidationJSON().then(function(response) {

            $scope.JSON_validation = response; 

        });                    

        // Refresh the classroom side list when classroom is created
        $scope.refresh_articles = function() {

            ArticlesService.get_classroom_articles('GET',"api/classroom/last_articles/"+$scope.classroom_item.id).then(function(response) {
                $scope.last_classroom_articles = response.data;
            });
        };          

        // Get logged in user data
        UserService.get_logged_user_data().then(function(response) {

            $scope.logged_user_data = response.data;
        });        

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

        // Send the form input data to process it at backend
        $scope.send_article_form_data = function() {
            

            $scope.article_form_data['classroom_id'] = $scope.classroom_item.id;

            $scope.article_form_data['user_id'] = $scope.logged_user_data.id

            ArticlesService.create_article('POST','api/article/save',JSON.stringify($scope.article_form_data)).then(function(response) {
                console.log(response);
                if(response.valid == true) {

                    document.getElementById('valid-article-modal').style.display='block';
                    document.getElementById('article-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        };        

        // Display the modal form to create a classroom
        $scope.show_form_classroom_modal = function() {
            document.getElementById('classroom-modal').style.display='block';
        };          

        // Display the modal form to create an article
        $scope.show_form_article_modal = function() {
            document.getElementById('article-modal').style.display='block';
        };              

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_classroomForm = function() {
                
             document.getElementById('valid-classroom-modal').style.display='none';
        };

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_article_form = function() {
                
             document.getElementById('valid-article-modal').style.display='none';
        };        

}])