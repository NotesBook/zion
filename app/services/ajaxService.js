nbApp.factory('AjaxService', ['$q','$http',
	function($q,$http) {

		var self = {};

		self.send = function(method,uri) {

			var http_request = getObject();
			var uri = uri,
			defered = $q.defer(),
			promise = defered.promise,
			method = method || "get";

			http_request.onreadystatechange = function() {

				if (http_request.readyState == 4) {
					if (http_request.status == 200) {
						console.log(http_request.responseText);
						var JsonObj = JSON.parse(http_request.responseText);
						defered.resolve(JsonObj);
					} else {
						console.error("AjaxService - Error: ", oXHR.statusText);
						defered.reject("AjaxService - Error: ", oXHR.statusText);
					}
				}
			};

			http_request.open(method, uri);
			http_request.send();

			return promise;
		}	

		function getObject() {
			
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
			    return new XMLHttpRequest();
			} else if (window.ActiveXObject) { // IE
			    return new ActiveXObject("Microsoft.XMLHTTP");
			}
		}

		return self;
}])