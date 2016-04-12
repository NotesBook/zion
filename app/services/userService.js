nbApp.factory('UserService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.getAll = function() {

	  		var uri = "api/user",
				method = "get";
				
				console.log("llamada al servicio ajax");
		  		return AjaxService.send(method,uri);
		
	  	};

	    return self;

 	}]);