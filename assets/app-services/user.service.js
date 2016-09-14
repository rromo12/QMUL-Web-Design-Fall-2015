(function () {
    'use strict';

    angular
        .module('app')
        .factory('UserService', UserService);

    UserService.$inject = ['$http'];
    function UserService($http) {
        var service = {};

        service.GetAll = GetAll;
        service.Create = Create;
        service.Update = Update;
        service.Delete = Delete;
        service.GetByEmail = GetByEmail;

        return service;

        function GetAll() {
            var deferred= $q.defer();
            $http.get('http://webprojects.eecs.qmul.ac.uk/rgr30/BeOne/assets/php/get_user_info.php?userid=*').then(function(response) {
                var deferredArray = $q.defer();
                deferredArray.resolve(response.data);
                deferred.resolve(JSON.parse(deferredArray.promise()));
            }, function() {
                deferred.resolve({success:false, message: 'error retrieving user data', data: []});
            });
            return deferred.promise;
        }


        function GetByEmail(email) {
            var deferred = $q.defer();
            $http.get('http://webprojects.eecs.qmul.ac.uk/rgr30/BeOne/assets/php/get_user_info_by_email.php?email=' + email).then(function(response) {
                var deferredData = $q.defer();
                deferredData.resolve(JSON.parse(response.data));
                var user = $q.defer();
                user.resolve(deferredData.promise[0]);
                deferred.resolve(user);



            }, function() {
                deferred.resolve({});
            });
            return deferred.promise;
        }

        function Create(user) {
            var deferred = $q.defer();
                GetByEmail(user.email)
                    .then(function (duplicateUser) {
                        if (duplicateUser !== null) {
                            deferred.resolve({ success: false, message: 'Email "' + user.email + '" is already taken' });
                        } else {
                            $http.post("http://webprojects.eecs.qmul.ac.uk/rgr30/BeOne/assets/php/signUp.php", {
                                'fname': user.firstName,
                                'lname': user.lastName,
                                'uname': user.email,
                                'email': user.email,
                                'pwd': user.password,
                                'country': user.country,
                                'city': user.city,
                                'dob': user.birthday,
                                'sex': user.sex,
                                'goal': user.goal,
                                'picture': user.profilePictureBlob
                            }).then( function() {
                                deferred.resolve({ success: true });
                            }, function() {
                                deferred.resolve({ success: false, message: error });
                            });


                        }
                    });

            return deferred.promise;
        }

        function Update(user) {
            return $http.put('/api/users/' + user.id, user).then(handleSuccess, handleError('Error updating user'));
        }


    }

})();
