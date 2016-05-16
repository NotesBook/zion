nbApp.factory('UserService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.getAll = function() {

	  		var uri = "api/user",
				method = "get";
				
			console.log("llamada al servicio ajax");
	  		return AjaxService.send(method,uri);
		
	  	};

	  	self.validate = function(token, email) {
			var	method = "get";
				
	  		return AjaxService.send(method, 'api/user/active/' + email + '/' + token);
	  	};

	    return self;

 	}]);