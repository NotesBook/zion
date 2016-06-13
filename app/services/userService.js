nbApp.factory('UserService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.get_logged_user_data = function() {
	  		var uri = 'api/user/get_logged_user_data',
				method = 'get';
				
	  		return AjaxService.send(method,uri);
	  	};

	  	self.logout = function() {
	  		var method = "get",
	  			uri = "api/user/logout";

  			return AjaxService.send(method,uri);	
	  	}

	  	self.validate = function(token, email) {
			var	method = "get";
				
	  		return AjaxService.send(method, 'api/user/active/' + email + '/' + token);
	  	};

	  	self.send_register_form_data = function(method,uri,data) {

	  		return AjaxService.send(method,uri,data);
	  	};

	  	self.send_login_form_data = function(method,uri,data) {

	  		return AjaxService.send(method,uri,data);
	  	};

	  	self.check_session_dashboard_redirection = function() {

	  		return AjaxService.send('GET', 'api/user/check_session');

	  	};

	    return self;

 	}]);