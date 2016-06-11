nbApp.service('SharedDataService', function() {

  var val1;

  self = {};

  self.set_val = function(newString) {
      val1 = newString
  };

  self.get_val = function(){
      return val1;
  };

  return self;


});