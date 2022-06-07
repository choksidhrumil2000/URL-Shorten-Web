var dashboardapp = angular.module('dashboardapp',['ui.router']);
dashboardapp.directive('menuClose', function() {
    return {
        restrict: 'AC',
        link: function($scope, $element) {
            $element.bind('click', function() {
                var drawer = angular.element(document.querySelector('.mdl-layout__drawer'));
                if(drawer) {
                    var x = angular.element(document.querySelector('.mdl-layout__obfuscator'));
                    if(x){
                        x.toggleClass('is-visible');
                        drawer.toggleClass('is-visible');
                    }
                    
                }
            });
        }
    };
});
dashboardapp.controller('logoutctrl',function($window){
    sessionStorage.clear();
    // alert('You have loggedOut Successfully!!');
    // $window.location.href = "/URL-Shorten/ci/user_controller/url_shorten_app";
    swal("Success!!!", "You have loggedOut Successfully!!", "success")
        .then(function(){
                $window.location.href = '/URL-Shorten/ci/user_controller/url_shorten_app';                    
        });
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
                // alert('URL is successfully Shorten and Stored in Database!!!');
                swal("Success!!", "URL is successfully Shorten and Stored in Database!!!", "success");
                $scope.shorten_url = response.data.short_url;
                $scope.long_url = response.data.long_url;
            }else if(response.data.check == false && !response.data.long_url){
                // alert('url cant be empty!!!');
                swal("Error!!", "URL Cant be Empty!!", "info");  
            }else{
                swal("Error!!", "There is error in Adding Url to the DataBase!!!", "error");
                // alert('There is error in Adding Url to the DataBase!!!');
            }
        },function(){
            swal("Failure!!", "Failure in URL Shortening!!!", "error");
            // alert('Failure in URL Shortening!!!');
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
            // console.log(response.data);
            if(response.data.check == true){
                $scope.urls = response.data.urls_array;
                $scope.counts = response.data.count_of_urls;
                $scope.show_para = false;
            }else{
                $scope.show_para = true;
            }
        },function(){
            // alert('There is some Failure in Retriving the data');
            swal("Failure!!", "There is some Failure in Retriving the data", "error");
        });
    // $scope.geturl = function($url_part){
    //     PassDataService.setValue($url_part);
    // };
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
dashboardapp.controller('analyticsctrl',function(url_analytics,$scope,$http){
    // $url_part = PassDataService.getValue();
    // $scope.show_graph = false;
    $scope.long_url = url_analytics.long_url;
    $scope.short_url = url_analytics.short_url;
    $scope.click_count = url_analytics.click_count;
    $scope.url_part = url_analytics.url_part;
    $url_part = url_analytics.url_part;
    // $http.get('/URL-Shorten/ci/dashboard_controller/geturldata/'+$url_part)
    //     .then(function(response){
    //         // console.log(response);
    //         if(response.data.check == true){
    //             $scope.long_url = response.data.long_url;
    //             $scope.short_url = response.data.short_url;
    //             $scope.click_count = response.data.click_count;
    //             $scope.url_part = response.data.url_part;
    //         }else{
    //             // alert('There is some error in retriving data in database!!!');
    //             swal("Error!!", "There is some error in retriving data in database!!!", "error");
    //         }
    //     },function(){
    //         // alert('There is some failure in retriving url data!!!');
    //         swal("Failure!!", "There is some failure in retriving url data!!!", "error");
    //     });
    $scope.data_function = function($graph_time,$url_part){
        $http.get('/URL-Shorten/ci/dashboard_controller/get_graph_data/'+$graph_time+'/'+$url_part)
            .then(function(response){
                if(response.data.graph_data_array != null){
                    // console.log(response.data.graph_data_array);
                    google.charts.load('current', {'packages':['line']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                    // var data = new google.visualization.DataTable();
                    // data.addColumn('date','Date');
                    // data.addColumn('number',$graph_time);
                    var data = google.visualization.arrayToDataTable(response.data.graph_data_array);
                    // data.addRows(response.data.graph_data_array);
                    var options = {
                        chart: {
                        title: 'click-count -> Time Graph',
                        subtitle: 'URL-Shorten App graph'
                        },
                        width: 900,
                        height: 500
                    };

                    var chart = new google.charts.Line(document.getElementById($graph_time));

                    chart.draw(data, google.charts.Line.convertOptions(options));
                    }
                    // $scope.show_graph = true;
                }else{
                    // $scope.show_graph = false;
                    // alert('There is an error in retriving the graph data');
                    swal("Error!!", "There is an error in retriving the graph data", "error");

                }
            },function(){
                // alert('There is some failure in retriving graph Data!!!');
                swal("Failure!!", "There is some failure in retriving graph Data!!!", "error");
            });

    };
    $scope.data_function('last_week',$url_part);
});
// dashboardapp.factory('PassDataService',function(){
//     var $url_part = "";
//     var service = {
//         setValue:setValue, 
// 		getValue:getValue 
//     };
//     return service;
    
//     function setValue($part){
//         $url_part = $part;
//     }
//     function getValue(){
//         return $url_part;
//     }
// });
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
        url:'/url_analytics/{url_part}',
        templateUrl:'/URL-Shorten/ci/static_pages/show_url_analytics.html',
        controller:'analyticsctrl',
        resolve:   {
            // Let's fetch the sprocket in question
            // so we can provide it directly to the controller.
            url_analytics:  function($http, $stateParams){
                var url = "/URL-Shorten/ci/dashboard_controller/geturldata/" + $stateParams.url_part;
                return $http.get(url)
                    .then(function(res){ return res.data; }
                        ,function(){
                            swal('Error!!','Error Getting URL Data!!!','error');
                        });
            }
        }
    }
    $urlRouterProvider.otherwise('/short_url');
    $stateProvider.state(logout);
    $stateProvider.state(short_url_state);
    $stateProvider.state(list_urls_state);
    $stateProvider.state(url_analytics_state);
});
dashboardapp.run(function($rootScope,$http,$timeout){
    $user_id = sessionStorage.getItem('user_id');
    $http.get('/URL-Shorten/ci/dashboard_controller/getuserdata/'+$user_id)
    .then(function(response){
        // console.log(response.data);
        $rootScope.firstname = response.data.firstname;
        $rootScope.lastname = response.data.lastname;
    },function(){
        // alert('Failure in Showing User!!!');
        swal("Failure!!", "Failure in Showing User!!!", "error");
    });
    $rootScope.$on('$viewContentLoaded', function() {
        $timeout(function() {
            componentHandler.upgradeAllRegistered();
        });
    });
});

