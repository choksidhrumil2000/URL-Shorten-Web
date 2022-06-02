var dashboardapp = angular.module('dashboardapp',['ui.router']);
dashboardapp.controller('logoutctrl',function($window){
    sessionStorage.clear();
    alert('You have loggedOut Successfully!!');
    $window.location.href = "/URL-Shorten/ci/user_controller/url_shorten_app";
});
dashboardapp.controller('urlctrl',function($scope,$http){
    $user_id = sessionStorage.getItem('user_id');
    $scope.shorten_url = "";
    $scope.user = {};
    $scope.submit_short_url = function(){
        $http({
            method:'post',
            url:'/URL-Shorten/ci/dashboard_controller/shorten_url/'+$user_id,
            data:$scope.user
        }).then(function(response){
            //console.log(response);
            if(response.data.check == true){
                alert('URL is successfully Shorten and Stored in Database!!!');
                $scope.shorten_url = response.data.short_url;
                $scope.long_url = response.data.long_url;
            }else if(response.data.check == false && !response.data.long_url){
                alert('url cant be empty!!!');  
            }else{
                alert('There is error in Adding Url to the DataBase!!!');
            }
        },function(){
            alert('Failure in URL Shortening!!!');
        });
    };
    // $scope.count_func = function($short_url){
    //     $http.get('/URL-Shorten/ci/dashboard_controller/store_url_analytics_with_short_url/'+$short_url)
    //         .then(function(response){
    //             if(response.data.check == true){
    //                 alert('count inserted to database!!');
    //             }else{
    //                 alert('There is some error in storing count in database!!!');
    //             }
    //         },function(){
    //             alert('There is some Failure in storing click count!!!');
    //         });
    // };
});
dashboardapp.controller('listurlctrl',function($scope,$http){
    $user_id = sessionStorage.getItem('user_id');
    $http.get('/URL-Shorten/ci/dashboard_controller/geturlsdata/'+$user_id)
        .then(function(response){
            console.log(response.data);
            if(response.data != null){
                $scope.urls = response.data.urls_array;
                $scope.show_para = false;
            }else{
                $scope.show_para = true;
            }
        },function(){
            alert('There is some Failure in Retriving the data');
        });
    // $scope.count_func = function($url_id){
    //     $http.get('/URL-Shorten/ci/dashboard_controller/store_url_analytics/'+$url_id)
    //         .then(function(response){
    //             if(response.data.check == true){
    //                 alert('count inserted to database!!');
    //             }else{
    //                 alert('There is some error in storing count in database!!!');
    //             }
    //         },function(){
    //             alert('There is some Failure in storing click count!!!');
    //         });
    // };
});
dashboardapp.config(function($stateProvider,$urlRouterProvider){
    var logout = {
        name:'logout',
        url:'/logout',
        templateUrl:'/URL-Shorten/ci/static_pages/logout.html',
        controller:'logoutctrl'
    }
    var short_url_state = {
        name:'short_url',
        url:'/short_url',
        templateUrl:'/URL-Shorten/ci/static_pages/short_url.html',
        controller:'urlctrl'
    }
    var list_urls_state = {
        name:'list_url',
        url:'/list_url',
        templateUrl:'/URL-Shorten/ci/static_pages/list_of_urls.html',
        controller:'listurlctrl'
    }
    var url_analytics_state = {
        name:'url_analytics',
        url:'/url_analytics',
        templateUrl:'/URL-Shorten/ci/static_pages/show_url_analytics.html'
    }
    $urlRouterProvider.otherwise('/short_url');
    $stateProvider.state(logout);
    $stateProvider.state(short_url_state);
    $stateProvider.state(list_urls_state);
    $stateProvider.state(url_analytics_state);
});
dashboardapp.run(function($rootScope,$http){
    $user_id = sessionStorage.getItem('user_id');
    $http.get('/URL-Shorten/ci/dashboard_controller/getuserdata/'+$user_id)
    .then(function(response){
        // console.log(response.data);
        $rootScope.firstname = response.data.firstname;
        $rootScope.lastname = response.data.lastname;
    },function(){
        alert('Failure in Showing User!!!');
    });
});