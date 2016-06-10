nbApp.controller('MainController', ['$scope', 'SecurityService',
	function($scope, SecurityService) {

		SecurityService.checkSession();

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

		// Display the side classroom menu
		$scope.accordion = function(id) {
		    var x = document.getElementById(id);
		    if (x.className.indexOf("w3-show") == -1) {
		        x.className += " w3-show";
		        x.previousElementSibling.className += " w3-theme-d1";
		    } else { 
		        x.className = x.className.replace("w3-show", "");
		        x.previousElementSibling.className = 
		        x.previousElementSibling.className.replace(" w3-theme-d1", "");
		    }
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

		// Display the modal form to create a classroom
         $scope.show_form_article_modal = function() {
            document.getElementById('article-modal').style.display='block';
         };		

         

	}])