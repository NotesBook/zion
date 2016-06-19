nbApp.factory('ArticlesService', ['AjaxService',
  	function(AjaxService){

  		var self = {};

	  	self.get_last_articles = function(class_id) {

	    	return AjaxService.send("GET","api/classroom/last_articles/" + class_id);

	    }

	    self.get_article_by_id = function(id) {

	    	var method = "get",
	    		uri = 'api/article/get_by_id/' + id;
	    		
	    	return AjaxService.send(method,uri);

	    }	    

	    self.get_dashboard_articles = function() {

	    	return AjaxService.send('GET', "api/dashboard/last_articles");

	    }

	    self.save_article = function(data) {

	    	var method = 'post',
	    		uri = 'api/article/save',
	    		data = data;

	    	return AjaxService.send(method,uri,data);

	    }

	    self.like = function(article_id) {

	    	var method = 'get',
	    		uri = 'api/article/like/' + article_id;

	    	return AjaxService.send(method,uri);	

	    }

	    self.unlike = function(article_id) {

	    	var method = 'get',
	    		uri = 'api/article/unlike/' + article_id;

	    	return AjaxService.send(method,uri);

	    };

	    self.get_most_popular_articles = function() {

	    	return AjaxService.send('GET', 'api/article/get_most_popular_articles')

	    }
	    
	    return self;


 	}]);