(function () {
    'use strict';

    angular
        .module('app')
        .controller('UserProfileController', UserProfileController);

    UserProfileController.$inject = ['$scope', '$rootScope', 'UserService', '$log', '$cookieStore'];
    function UserProfileController($scope, $rootScope, UserService, $log, $cookieStore) {
        var email= ($cookieStore.get('globals').currentUser.email);
        function getUserData() {
            UserService.GetByEmail(email).then(function(user) {
                $scope.user=user;
            })
        }
        getUserData();
    }
})();