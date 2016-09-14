/**
 * http://jasonwatmore.com/post/2015/03/10/AngularJS-User-Registration-and-Login-Example.aspx
 */
(function () {
    'use strict';

    angular
        .module('app')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['UserService', '$location', '$rootScope', 'FlashService', '$log', 'AuthenticationService', '$uibModalInstance', '$scope','$http', '$window', '$timeout', 'Upload'];
    function RegisterController(UserService, $location, $rootScope, FlashService, $log, AuthenticationService, $uibModalInstance, $scope, $http, $window, $timeout, Upload) {
        var vm = this;


        vm.close = function () {
            $uibModalInstance.close();
        };


        vm.user={};

        vm.user.communities=[{name: "Meditation", picture: "http://www.imagefully.com/wp-content/uploads/2015/07/Best-Source-Of-Guided-Meditations-Yoga-Image.jpg"}];


        vm.sexs = ['Sex','Female', 'Male', 'Other'];

        vm.user.sex='Sex';
        vm.goals = ['Goal','Gratitude', 'Empathy', 'Stress Relief', 'Depression Relief', 'Inner Peace',
            'Self Acceptance', 'Live in the Present', 'Anxiety Relief', 'Creative Thinking', 'Self Efficacy', 'Altruism', 'Sustainable Living',
            'Compassion', 'Forgiveness', 'Integrity', 'Joy'];

        vm.user.goal='Goal';
        vm.user.posts=[];
        vm.user.commitment="";

        vm.register = register;

        vm.upload = function (dataUrl) {
            console.log(dataUrl)
                Upload.upload({
                    url: 'https://angular-file-upload-cors-srv.appspot.com/upload',
                    data: {
                        file: Upload.dataUrltoBlob(dataUrl)
                    }
                }).then(function (response) {
                    $timeout(function () {
                        vm.result = response.data;
                    });
                }, function (response) {
                    if (response.status > 0) $scope.errorMsg = response.status
                        + ': ' + response.data;
                }, function (evt) {
                    vm.progress = parseInt(100.0 * evt.loaded / evt.total);
                });
        };



        function register() {
            vm.user.profilePicture=Upload.dataUrltoBlob(vm.user.profilePictureBlob, "userProfilePictureBlob");
            console.log(vm.user.profilePicture);
            vm.dataLoading = true;
            UserService.Create(vm.user)
                .then(function (response) {
                    if (response.success) {
                        FlashService.Success('Registration successful', true);
                        AuthenticationService.SetCredentials(vm.user.email, $scope.uid, vm.user.password);
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