var nbApp = angular.module('nbApp',[
	'ngRoute',
	]);

nbApp.config(['$routeProvider',
  	function($routeProvider) {
	    $routeProvider.
	    	when('/user', {
		        templateUrl: 'app/views/user/user-list.html',
		        controller: 'UserController'
			}).when('/user/register', {
				templateUrl: 'app/views/user/user-form.html',
				controller: 'UserController'
			}).
			otherwise({
				redirectTo: '/'
			});
  	}]);

