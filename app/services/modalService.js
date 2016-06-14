nbApp.factory('ModalService',[
	function() {

		var self = {};

        self.title = "";
        self.text = "";
        self.show_accept_button = "#/";
        self.href_accept_button = "";
        self.show = false;

        self.showModal = function(title, text, show_accept_button, href_accept_button) {

	        self.title = title;
	        self.text = text;
	        self.show_accept_button = show_accept_button;
	        self.href_accept_button = href_accept_button || '#/';

        	self.show = true;

        };

        self.closeModal = function() {

        	self.show = false;

        };

        self.showLoadingModal = function() {

        	$('#loading').show();

        };

        self.hideLoadingModal = function() {
        	
        	$('#loading').hide();

        };
		
		return self;
	}
]);
