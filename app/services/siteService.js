nbApp.factory('SiteService', ['AjaxService',
  	function(AjaxService){

  		var self = {};


	  	self.create_classroom = function(method,uri,data) {

	  		return AjaxService.send(method,uri,data);
	  	};

	    return self;

 	}]);