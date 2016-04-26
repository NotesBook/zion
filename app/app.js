var nbApp = angular.module('nbApp',[
	'ngRoute',
	]);

nbApp.config(['$routeProvider',
  	function($routeProvider) {
	    $routeProvider.
	    	when('/user', {
		        templateUrl: 'app/views/user/user-list.html',
		        controller: 'UserController'
			}).when('/', {
				templateUrl: 'app/views/user/user-login-form.html',
				controller: 'LoginController'
			}).when('/user/register', {
				templateUrl: 'app/views/user/user-register-form.html',
				controller: 'RegisterController'
			}).
			otherwise({
				redirectTo: '/'
			});
  	}]);

