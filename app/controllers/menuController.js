nbApp.controller('MenuController', ['$scope', 'SecurityService', 'MenuService', 'ModalService', 'LoadingService', 'UserService', 'ClassroomsService', 'CategoriesService',
	function($scope, SecurityService, MenuService, ModalService, LoadingService, UserService, ClassroomsService, CategoriesService) { 

        LoadingService.showLoading();
        SecurityService.checkSession();

        /* Modal Create Classroom */
        $scope.modal_create_classroom = {};
        $scope.modal_create_classroom.show = false;

        $scope.$watch('modal_create_classroom.show', function(show) {

            if (show)
                $scope.modal_create_classroom.style = { "display" : "block" };
            else
                $scope.modal_create_classroom.style = {};

        });

        $scope.launch_form_classroom_modal = function() {

            return $scope.modal_create_classroom.show = true;

        }; 

        $scope.close_form_classroom_modal = function() {

            return $scope.modal_create_classroom.show = false;

        };    

        // Send the form input data to process it at backend
        $scope.send_classroom_form_data = function() {

            LoadingService.showLoading();

            $scope.classroom_form_data['category'] = $scope.classroom_form_data['category'].category;

            $scope.classroom_form_data['subcategory'] = $scope.classroom_form_data['subcategory'].name;

            ClassroomsService.create_classroom(JSON.stringify($scope.classroom_form_data)).then(function(response) {

                if(response.valid == true) {

                    ModalService.showModal(" ¡ Aula creada con exito ! ", "Revisa tu email para invitar a otros usuarios", true, '#/classroom/' + response.data);
                    $scope.close_form_classroom_modal();
                    LoadingService.hideLoading();  

                    /* Create Classroom Form */
                    $scope.classroom_form_data = {
                        name:"",
                        category: "",
                        subcategory: "",
                        description: "",          
                    }; 
            
                } else ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true);
 
            });
        };     

        /* Create Classroom Form */
        $scope.classroom_form_data = {
            name:"",
            category: "",
            subcategory: "",
            description: "",          
        }; 

        /* Get Associated Info */ 
        /* $scope.$parent is ussed for sharing the info with controller of view loaded */
        UserService.get_logged_user_data().then(function(response) {

            $scope.$parent.logged_user_data = response.data;

        });

        CategoriesService.getCategoriesJSON().then(function(response) {

            $scope.$parent.JSON_categories = response; 

        }); 

        // Refresh the classroom side list when classroom is created
        $scope.refresh_classrooms = function() {

            ClassroomsService.get_classrooms().then(function(response) {

                 $scope.$parent.classrooms = response.data;

            });
        };

        $scope.refresh_classrooms();


        /* ----------------------- Article ---------------------- */
        
        // Send the form input data to process it at backend
        $scope.send_article_form_data = function() {
            
            $scope.article_form_data['classroom_id'] = $scope.classroom_id;

            $scope.article_form_data['user_id'] = $scope.logged_user_data.id;

            ArticlesService.create_article('POST','api/article/save',JSON.stringify($scope.article_form_data)).then(function(response) {
                if(response.valid == true) {

                    document.getElementById('valid-article-modal').style.display='block';
                    document.getElementById('article-modal').style.display='none';
            
                } else $scope.show_valid_modal = false;
 
            });
        };       

        // Display the modal form to create an article
        $scope.show_form_article_modal = function() {

            document.getElementById('article-modal').style.display='block';

        };          

        // Hides the valid modal when accept button is clicked 
        $scope.hide_valid_article_form = function() {
                
             document.getElementById('valid-article-modal').style.display='none';

        };         

        /* ----------------------- Fin Article ---------------------- */

        // Logout user and redirect to login
        $scope.logout = function() {
            UserService.logout().then(function(response) {
                if(response.valid == true) {
                    $window.location.href = '#/';
                    $cookies.remove("loginTokenCookie");
                }
            });
        };

        $scope.redirect_to_article = function(article_id) {
            $window.location.href = '#/article/'+article_id;
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

	}]);