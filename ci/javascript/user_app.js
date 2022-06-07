var user_app = angular.module('userapp',['ui.router']);
user_app.controller('loginctrl',function($scope,$http,$window){

    $scope.user = {};
    $scope.submit_login = function(){
        if($scope.user.email == null || $scope.user.password == null){
            swal('Error!!','Email or Password cant be empty!!','info');
        }else{
            $http({
                method:'post',
                url:'/URL-Shorten/ci/user_controller/check_user/',
                data:$scope.user,
            }).then(function(response){
                if(response.data.check == true){
                    sessionStorage.setItem('user_id',response.data.id);
                    swal("Login Successfully!!", "Your Credentials match in the database!", "success")
                    .then(function(){
                        $window.location.href = "/URL-Shorten/ci/dashboard_controller/dashboard";
                    });
                    // alert('Login Successfully!!!');
                    // $window.location.href = "/URL-Shorten/ci/dashboard_controller/dashboard";
                }else{
                    // alert(response.data.error);
                    swal("There is Some Error!!", response.data.error, "error");
                    $scope.user.email = "";
                    $scope.user.password = "";
                }
            },function(){
                // alert('Failure in Login !!!! Try Again!!!');
                swal("Failure!!!", "Failure in Login Try Again!!!", "error");
            });
        }
    };
});
user_app.controller('signupctrl',function($scope,$http,$window){
    $scope.user = {};
    $scope.submit_signup = function(){
        if($scope.user.firstname == null ||
            $scope.user.lastname == null ||
            $scope.user.email == null ||
            $scope.user.password == null){
                swal('Error!','Fields can not be empty!!','info');
        }else{
            $http({
                method:'post',
                url:'/URL-Shorten/ci/user_controller/add_user/',
                data:$scope.user,
            }).then(function(response){
                if(response.data.check_email == false){
                    if(response.data.check == true){
                        sessionStorage.setItem('user_id',response.data.id);
                        // alert('User Added Successfully');
                        swal("Success!!!", "User Added Successfully!!", "success")
                        .then(function(){
                            $window.location.href = '/URL-Shorten/ci/dashboard_controller/dashboard';
                        });
                        // $window.location.href = '/URL-Shorten/ci/dashboard_controller/dashboard';
                    }else{
                        // alert('There is an error in adding user in database!!!');
                        swal("DataBase Error!!", "There is an error in adding user in database!!!", "error");
                    }
                }else{
                    // alert('Email Already Exists!! or Registered!!');
                    swal("User Already Exist!!", "Email Already Registered!!!", "error");
                }
            },function(){
                // alert('There is some failure in adding user Try Again!!!');
                swal("Failure!!!", "There is some failure in adding user Try Again!!!", "error");
            });
        }
    };
});
user_app.config(function($stateProvider,$urlRouterProvider){
    var login = {
        name:'login',
        url:'/login',
        templateUrl:'/URL-Shorten/ci/static_pages/login_page.html',
        controller:'loginctrl'
    }
    var signup = {
        name:'signup',
        url:'/signup',
        templateUrl:'/URL-Shorten/ci/static_pages/signup_page.html',
        controller:'signupctrl'
    }
    $urlRouterProvider.otherwise('/login');
    $stateProvider.state(login);
    $stateProvider.state(signup);

});
user_app.run(function($rootScope,$timeout){
    $rootScope.$on('$viewContentLoaded', function() {
        $timeout(function() {
            componentHandler.upgradeAllRegistered();
        });
    });
});