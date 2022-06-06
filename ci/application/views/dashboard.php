<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>URL Shorten Web App</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	    <script src="https://unpkg.com/@uirouter/angularjs@1.0.30/release/angular-ui-router.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Material design Lite Links  -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
        <!-- <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css"> -->
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-blue.min.css" />        
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    </head>
    <body ng-app="dashboardapp">
    <div class = "mdl-layout mdl-js-layout mdl-layout--fixed-header">
         <header class = "mdl-layout__header">
            <div class = "mdl-layout__header-row">
               <!-- Title -->
               <span class = "mdl-layout-title">URL-Shorten App</span>
               <!-- Add spacer, to align navigation to the right -->
               <div class = "mdl-layout-spacer"></div>
               <!-- Navigation -->
               <nav class = "mdl-navigation">
               <button ui-sref="logout" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                    <i class="material-icons">logout</i>
                </button>
                  <!-- <a class = "mdl-navigation__link" href = "" 
                     style = "color:gray">Home</a>
                  <a class = "mdl-navigation__link" href = "" 
                     style = "color:gray">About</a> -->
               </nav>
            </div>
         </header>
         
         <div class = "mdl-layout__drawer">
            <span class = "mdl-layout-title">Hii! {{firstname + " " + lastname}}</span>
            <nav class = "mdl-navigation">
            <a class="mdl-navigation__link" ui-sref="short_url">Short URL Tab</a>
            <a class="mdl-navigation__link" ui-sref="list_url">List Of URLs Tab</a>    
            </nav>
         </div>
    <!-- </div> -->
        <!-- <div style="background-color: indigo;">
            <div style="margin-left:1090px;padding-top: 10px; color: white;font-size:16px;">
                {{firstname + " " + lastname}}
                <button ui-sref="logout" style="margin-left:10px;margin-right:10px;" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                    <i class="material-icons">logout</i>
                </button>
            </div> -->
                <!-- <a ui-sref="logout" style="margin-left:50px;">Logout</a> -->
            <!-- <div>
                <span class="material-icons" style="margin-left: 50px;padding-top:20px;">logout</span>
            </div> -->
            <!-- <hr style="background-color: white; height:2px;">
        </div> -->
        <h1 style="text-align: center;">Welcome to DashBoard!!</h1>
        <!-- <div style="margin-left:500px;">
        <a ui-sref="short_url">Short URL Tab</a> |
        <a ui-sref="list_url">List Of URLs Tab</a>
        </div> -->
        <!-- <main class = "mdl-layout__content">     -->
            <!-- <div class = "mdl-tabs mdl-js-tabs">
                <div class = "mdl-tabs__tab-bar">
                    <a ui-sref="short_url" class = "mdl-tabs__tab is-active">Short URL Tab</a>
                    <a ui-sref="list_url" class = "mdl-tabs__tab ">List Of URLs Tab</a>
                </div>
            </div> -->
        <!-- </main> -->
        <ui-view></ui-view>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="/URL-shorten/ci/javascript/dashboard_app.js"></script>
    </body>
</html>