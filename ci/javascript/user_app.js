var user_app = angular.module('userapp',['ui.router']);
user_app.controller('loginctrl',function($scope,$http,$window){
    $scope.user = {};
    $scope.submit_login = function(){
        $http({
            method:'post',
            url:'/URL-Shorten/ci/user_controller/check_user/',
            data:$scope.user,
        }).then(function(response){
            if(response.data.check == true){
                sessionStorage.setItem('user_id',response.data.id);
                alert('Login Successfully!!!');
                $window.location.href = "/URL-Shorten/ci/dashboard_controller/dashboard";
            }else{
                alert(response.data.error);
                $scope.user.email = "";
                $scope.user.password = "";
            }
        },function(){
            alert('Failure in Login !!!! Try Again!!!');
        });
    };
});
user_app.controller('signupctrl',function($scope,$http,$window){
    $scope.user = {};
    $scope.submit_signup = function(){
        $http({
            method:'post',
            url:'/URL-Shorten/ci/user_controller/add_user/',
            data:$scope.user,
        }).then(function(response){
            if(response.data.check_email == false){
                if(response.data.check == true){
                    sessionStorage.setItem('user_id',response.data.id);
                    alert('User Added Successfully');
                    $window.location.href = '/URL-Shorten/ci/dashboard_controller/dashboard';
                }else{
                    alert('There is an error in adding user in database!!!');
                }
            }else{
                alert('Email Already Exists!! or Registered!!');
            }
        },function(){
            alert('There is some failure in adding user Try Again!!!');
        });
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