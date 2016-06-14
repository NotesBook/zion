nbApp.factory('ClassroomsService', ['AjaxService',
  	function(AjaxService){

  		var self = {};


	  	self.create_classroom = function (data) {

	  		return AjaxService.send('POST', 'api/classroom/register', data);

	  	};

	  	self.get_classrooms = function () {

	  		return AjaxService.send('GET',"api/dashboard/my_classrooms");

	  	};

	  	self.get_classroom = function (classroom_id) {

	  		return AjaxService.send('GET', 'api/classroom/get_by_id/' + classroom_id);

	  	};


	    return self;


 	}]);