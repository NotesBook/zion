nbApp.factory('ArticlesService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.get_last_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }

	  	self.get_classroom_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }

	    self.get_article_by_id = function(id) {

	    	var method = "get",
	    		uri = 'api/article/get_by_id/'+id;
	    		
	    	return AjaxService.send(method,uri);
	    }	    

	    self.get_dashboard_articles = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }

	    self.edit_article = function(data) {
	    	var method = 'post',
	    		uri = 'api/article/save',
	    		data = data;

	    	return AjaxService.send(method,uri,data);
	    }

	    self.like = function(article_id) {
	    	var method = 'get',
	    		uri = 'api/article/like/'+article_id;

	    	return AjaxService.send(method,uri);	    	
	    }

	    self.unlike = function(article_id) {
	    	var method = 'get',
	    		uri = 'api/article/unlike/'+article_id;

	    	return AjaxService.send(method,uri);	    	
	    }


	    self.get_likes_count = function(article_id) {
	    	var method = 'get',
	    		uri = 'api/article/likes_count/'+article_id;

	    	return AjaxService.send(method,uri);
	    }

	    self.create_article = function(method,uri,data) {
	    	return AjaxService.send(method,uri,data);
	    }
	    
	    return self;


 	}]);