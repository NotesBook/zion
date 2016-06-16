nbApp.controller('MenuController', ['$scope', '$window', '$cookies', 'SecurityService', 'MenuService', 'ModalService', 'LoadingService', 'UserService', 'ClassroomsService', 'CategoriesService',
	function($scope, $window, $cookies, SecurityService, MenuService, ModalService, LoadingService, UserService, ClassroomsService, CategoriesService, CountriesService, ValidationService) { 

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
            console.log($scope.classroom_form_data);
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
            console.log($scope.logged_user_data)
        });

        CategoriesService.getCategoriesJSON().then(function(response) {

            $scope.$parent.JSON_categories = response; 

        }); 

        $scope.my_classrooms = [];
        // Refresh the classroom side list when classroom is created
        $scope.refresh_classrooms = function() {

            ClassroomsService.get_classrooms().then(function(response) {

                 $scope.$parent.classrooms = response.data;
                 $scope.my_classrooms = response.data;

            });
        };

        $scope.refresh_classrooms();

        $scope.show_user_info_modal_aa = function(userid) {

            debugger;

            UserService.get_by_id(userid).then(function(response) {

                debugger;

            });

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

        $scope.redirect_to_article = function(classroom_id, article_id) {
            
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


        /* -------------------- Invitaciones ------------------------ */

        /* Modal Create Classroom */
        $scope.modal_user_invite = {};
        $scope.modal_user_invite.show = false;

        $scope.$watch('modal_user_invite.show', function(show) {

            if (show)
                $scope.modal_user_invite.style = { "display" : "block" };
            else
                $scope.modal_user_invite.style = {};

        });

        $scope.launch_invite_modal = function() {

            return $scope.modal_user_invite.show = true;

        }; 

        $scope.close_invite_modal = function() {

            return $scope.modal_user_invite.show = false;

        };    

        $scope.send_invite = function() {

            LoadingService.showLoading();  

            var custom_scope = this;

            UserService.send_classroom_invitation(this.modal_user_invite.email, this.modal_user_invite.classroom).then(function(response) {

                if(response.valid == true) {

                    ModalService.showModal(" ¡ Hecho ! ", "El email ha sido enviado", true);
                    custom_scope.close_invite_modal();
                    LoadingService.hideLoading();  
            
                } else ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true);

            });

        };


        /* -------------------- Introducir código de invitación ------------------------ */

        /* Modal Create Classroom */
        $scope.modal_enroll_modal = {};
        $scope.modal_enroll_modal.show = false;

        $scope.$watch('modal_enroll_modal.show', function(show) {

            if (show)
                $scope.modal_enroll_modal.style = { "display" : "block" };
            else
                $scope.modal_enroll_modal.style = {};

        });

        $scope.launch_enroll_modal = function() {

            return $scope.modal_enroll_modal.show = true;

        }; 

        $scope.close_enroll_modal = function() {

            return $scope.modal_enroll_modal.show = false;

        };    


        $scope.send_enroll = function() {

            LoadingService.showLoading();  

            var custom_scope = this;

            ClassroomsService.invitation_enroll(this.modal_enroll_modal.invitation_code).then(function(response) {

                if(response.valid == true) {

                    ModalService.showModal(" ¡ Hecho ! ", "ya estás en el nuevo aula", true, '#/classroom/' + response.data);
                    custom_scope.close_enroll_modal();
            
                } else ModalService.showModal(" ¡Ups! Ha habido algún error ", "Contacta con el administrador web", true);


                custom_scope.close_enroll_modal();
                LoadingService.hideLoading();  

            }, function(asd) {

                custom_scope.close_enroll_modal();
                LoadingService.hideLoading();  
                ModalService.showModal(" ¡Ups! No existe ese código de invitación ", "No te cueles en las clases :)", true);

            });

        };

	}]);