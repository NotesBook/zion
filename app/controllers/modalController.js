nbApp.controller('ModalController', ['$scope','ModalService',
	function($scope, ModalService) { 

        $scope.modal = {};

        $scope.modal.style = function () {
            if ($scope.modal.show())
                return { "display" : "block" };
            
            return {};
        };

        //Get properties from ModalService
        $scope.modal.show = function () { 

            return ModalService.show;
        
        };

        //Get properties from ModalService
        $scope.modal.close = ModalService.closeModal;

        $scope.modal.title = function () { return ModalService.title; };
        $scope.modal.text = function () { return ModalService.text; };
        $scope.modal.show_accept_button = function () { return ModalService.show_accept_button; };
        $scope.modal.href_accept_button = function () { return ModalService.href_accept_button; };

	}]);