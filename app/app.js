var nbApp = angular.module('nbApp',[
	'ngMessages',
	'textAngular',
	'ngRoute',
	'ngCookies',
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
			}).when('/article/edit/:id', {
				templateUrl: 'app/views/article/article-view.html',
				controller: 'ArticleController'
			}).when('/article/:id', {
				templateUrl: 'app/views/article/article-view.html',
				controller: 'ArticleController'
			}).when('/article/create', {
				templateUrl: 'app/views/article/article-view.html',
				controller: 'ArticleController'
			}).when('/classroom/:classroom_id', {
				templateUrl: 'app/views/classroom/classroom-view.html',
				controller: 'ClassRoomController'
			}).when('/setup', {
				templateUrl: 'app/views/setup/setup-view.html',
				controller: 'SetupController'
			}).when('/user/:user_id', {
				templateUrl: 'app/views/user/user-view.html',
				controller: 'UserController'
			}).
			otherwise({
				redirectTo: '/'
	});
}]);

