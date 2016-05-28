nbApp.controller('MainController', ['$scope','$location', 'SecurityService',
	function($scope, $location, SecurityService) {

		SecurityService.checkSession();

		$scope.groups = [
			'Grupo 1',
			'Grupo 2',
			'Grupo 3',
			'Grupo 4',
		]

		$scope.acord = function(id) {
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
		    var x = document.getElementById("navDemo");
		    if (x.className.indexOf("w3-show") == -1) {
		        x.className += " w3-show";
		    } else { 
		        x.className = x.className.replace(" w3-show", "");
		    }
		};

	}])