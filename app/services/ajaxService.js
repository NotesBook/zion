nbApp.factory('AjaxService', ['$q',
	function($q) {

		var self = {};

		self.send = function(method,uri) {
			console.log("SEND")
				var http_request = self.setObject();
			
				var uri = uri,
				defered = $q.defer(),
				promise = defered.promise,
				method = method || "get";
				// header = "",
				// content = content || "";
				// deferred = $q.defer(),
			 	// promise = deferred.promise,

				http_request.onreadystatechange = function() {
					if (http_request.readyState == 4 && http_request.status == 200) {
						// TODO convertir a objeto el responseText
						debugger;
						var JsonObj = JSON.parse(http_request.responseText);
						
						defered.resolve(http_request.responseText);
					}
						// TODO especificar el reject en caso de codigo de error
					    // else  
					    // 	defered.reject("FAIL MAMONAZO");
				};

				// http_request.setRequestHeader(header, content);
				http_request.open(method, uri);
				http_request.send();

				return promise;
		}	

		self.setObject = function() {
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			    return new XMLHttpRequest();
			} else if (window.ActiveXObject) { // IE
			    return new ActiveXObject("Microsoft.XMLHTTP");
			}
		}

		return self;
}])