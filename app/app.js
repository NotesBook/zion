var nbApp = angular.module('nbApp',[
	'ngRoute',
	]);

nbApp.config(['$routeProvider',
  	function($routeProvider) {
	    $routeProvider.
	    	when('/users', {
		        templateUrl: 'app/views/user-list.html',
		        controller: 'userController'
			}).
			otherwise({
				redirectTo: '/users'
			});
  	}]);

