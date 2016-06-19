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

	  	self.send_register_form_data = function(data) {

	  		return AjaxService.send('post','api/user/register', data);
	  	};

	  	self.send_user_form_data = function(data) {

	  		return AjaxService.send('post','api/user/save', data);
	  	};

	  	self.send_login_form_data = function(method,uri,data) {

	  		return AjaxService.send(method,uri,data);
	  	};

	  	self.check_session_dashboard_redirection = function() {

	  		return AjaxService.send('GET', 'api/user/check_session');

	  	};

	  	self.upload_avatar = function(avatar_src) {

        	var formData = new FormData();
        	formData.append("avatar", avatar_src);
	  		return AjaxService.send('POST', 'api/user/upload_avatar', formData);

	  	};

	  	self.get_by_id = function(user_id) {

	  		return AjaxService.send('GET', 'api/user/get_by_id/' + user_id);

	  	};

	  	self.check_email_exists = function(email) {

	  		return AjaxService.send('GET', 'api/user/check_email_exists/' + email);

	  	};

	  	self.send_classroom_invitation = function(email, classroom_id) {

	  		return AjaxService.send('GET', 'api/user/send_classroom_invitation/' + email + '/' + classroom_id);

	  	};

	  	self.change_password = function(old_password_p, new_password_p) {

	  		var _data = {old_password: old_password_p, new_password: new_password_p};

	  		return AjaxService.send('POST', 'api/user/change_password/', JSON.stringify(_data));

	  	};

	    return self;

 	}]);