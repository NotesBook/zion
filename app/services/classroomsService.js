nbApp.factory('ClassroomsService', ['AjaxService',
  	function(AjaxService){

  		var self = {};


	  	self.create_classroom = function (method,uri,data) {
	  		return AjaxService.send(method,uri,data);
	  	};

	  	self.get_classrooms = function (method,uri,data) {
	  		return AjaxService.send(method,uri,data);
	  	};

	  	self.get_classroom = function (classroom_id) {
	  		return AjaxService.send('GET', 'api/classroom/get_by_id/' + classroom_id);
	  	};


	    return self;


 	}]);