nbApp.factory('AjaxService', ['$q', '$cookies', '$location',
	function($q, $cookies, $location) {

		var self = {};

		self.send = function(method,uri,data) {

			var http_request = getObject();
			var uri = uri,
			defered = $q.defer(),
			data = data || "";
			promise = defered.promise,
			method = method || "get";

			http_request.onreadystatechange = function() {

				if (http_request.readyState == 4) {
					if (http_request.status == 200) {
						console.log(http_request.responseText);
						var JsonObj = JSON.parse(http_request.responseText);
						defered.resolve(JsonObj);
					} else {
						console.error("AjaxService - Error: ", http_request.statusText);

						//TODO: If 405 redirect to home
						$location.path('/');

						defered.reject("AjaxService - Error: ", http_request.statusText);
					}
				}
			};

			http_request.open(method, uri);

			//inject the token if exits. The xhrOBject must be open
			http_request.setRequestHeader("token", $cookies.get("loginTokenCookie"));

			http_request.send(data);

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