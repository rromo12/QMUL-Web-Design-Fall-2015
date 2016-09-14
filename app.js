/**
 * http://jasonwatmore.com/post/2015/03/10/AngularJS-User-Registration-and-Login-Example.aspx
 */
( function() {
    'use strict';
    angular
        .module('app', ['ngRoute', 'ngCookies', 'ui.bootstrap','ngFileUpload', 'ngImgCrop'])
        .controller('ModalController', ModalController)
        //.controller('ModalInstanceController', ModalInstanceController)
        .config(config);
        //.run(run);

    ModalController.$inject = ['$uibModal', '$rootScope', '$scope'];
    function ModalController($uibModal, $rootScope, $scope) {
        $rootScope.openModal = function () {
            $rootScope.uibModalInstance = $uibModal.open({
                templateUrl: 'app/components/signUpLogin/signUpView.html',
                controller: 'RegisterController',
                controllerAs: 'vm'
            })
        };
        $rootScope.closeModal = function () {
            $rootScope.uibModalInstance.close();
        };
    }


    config.$inject = ['$routeProvider', '$locationProvider'];
    function config($routeProvider, $locationProvider) {
                $routeProvider.
                    when('/home', {
                        templateUrl: 'app/components/home/homeView.html'
                        //controller: 'ModalController'
                    }).
                    when('/userProfile', {
                        templateUrl: 'app/components/userProfile/userProfileView.html',
                        controller: 'UserProfileController'
                    }).
                    when('/sanctuary', {
                        templateUrl: 'app/components/sanctuary/sanctuaryView.html',
                        controller: 'SanctuaryController'
                    }).

                    otherwise({
                        redirectTo: '/home'
                    });
    }



    run.$inject = ['$rootScope', '$location', '$cookieStore', '$http'];
    function run($rootScope, $location, $cookieStore, $http) {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        console.log("hi");
        if ($rootScope.globals.currentUser) {

            $http.defaults.headers.common['Authorization'] = 'Basic ' +  $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in and trying to access a restricted page
            var restrictedPage = $.inArray($location.path(), ['/home']) === -1;
            var loggedIn =  $rootScope.globals.currentUser;
            if (restrictedPage && !loggedIn) {
                $location.path('/home');
            }
        });
    }


}());
