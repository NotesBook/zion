var nbApp = angular.module('nbApp',['ngMessages',
	'ngRoute',
	]);

nbApp.config(['$routeProvider',
  	function($routeProvider) {
	    $routeProvider
	    	.when('/', {
				templateUrl: 'app/views/user/user-login-form.html',
				controller: 'LoginController'
			}).when('/user/validation/:email/:token', {
				templateUrl: 'app/views/user/user-login-form.html',
				controller: 'LoginController'
			}).when('/user/register', {
				templateUrl: 'app/views/user/user-register-form.html',
				controller: 'RegisterController'
			}).when('/dashboard', {
				templateUrl: 'app/views/site/dashboard.html',
				controller: 'MainController'
			}).
			otherwise({
				redirectTo: '/'
	});
}]);

