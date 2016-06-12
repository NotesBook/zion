nbApp.factory('ArticlesService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.get_last_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }

	  	self.get_classroom_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }	    

	    self.get_dashboard_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }

	    self.create_article = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }
	    
	    return self;


 	}]);