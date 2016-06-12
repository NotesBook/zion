nbApp.service('SharedDataService', function() {

  var val;

  self = {};

  self.set_val = function(Shared_data) {
      val = Shared_data;
  };

  self.get_val = function(){
      return val;
  };

  return self;


});