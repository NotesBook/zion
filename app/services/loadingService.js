nbApp.factory('LoadingService', [
  	function(){

  		var self = {};

  		self.showLoading = function() {

  			$('#loading').css('display', 'block');

  		};

  		self.hideLoading = function() {
  			
        setTimeout(function() { $('#loading').css('display', 'none') }, 1000);

  		};
	    
	    return self;


 	}]);