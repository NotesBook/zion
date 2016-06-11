nbApp.factory('UserService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.get_user_by_id = function() {

	  		var uri = 'api/user/get_user_by_id',
				method = 'get';
				
	  		return AjaxService.send(method,uri);
		
	  	};

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

	    return self;

 	}]);