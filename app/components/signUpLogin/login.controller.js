/**
 * http://jasonwatmore.com/post/2015/03/10/AngularJS-User-Registration-and-Login-Example.aspx
 */
(function () {
    'use strict';

    angular
        .module('app')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$location', 'AuthenticationService', 'FlashService', '$scope', '$rootScope'];
    function LoginController($location, AuthenticationService, FlashService, $scope, $rootScope) {
        var vm = this;

        vm.login = login;

        (function initController() {
            // reset login status
            AuthenticationService.ClearCredentials();
        })();

        function login() {
            vm.dataLoading = true;
            AuthenticationService.Login(vm.email, vm.password, function (response) {
                if (response.success) {
                    AuthenticationService.SetCredentials(vm.email,$scope.uid, vm.password);
                    $location.path('/userProfile');
                    $rootScope.closeModal();
                } else {
                    FlashService.Error(response.message);
                    vm.dataLoading = false;
                }
            });
        }
    }

})();