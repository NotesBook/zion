nbApp.factory('LoadingService', [
  	function(){

  		var self = {};

  		self.showLoading = function() {

  			$('#loading').css('display', 'block');

  		};

  		self.hideLoading = function() {
  			
  			$('#loading').css('display', 'none');

  		};
	    
	    return self;


 	}]);