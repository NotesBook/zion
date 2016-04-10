nbApp.factory('UserService', [ '$http',
  	function($http){

  		var self = {};

	  	self.getAll = function() {

		  		return [
					{name: "Juan"},
					{name: "Galo"}
				]
		
	  	};

	    return self;

 	}]);