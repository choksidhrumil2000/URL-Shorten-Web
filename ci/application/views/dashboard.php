<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>URL Shorten Web App</title>
        <!-- <style>
               html,
                body {
                margin: 0;
                padding: 0;
                height: 100%;
                }
        </style> -->
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
        <!-- Always shows a header, even in smaller screens. -->
      <div class = "mdl-layout mdl-js-layout mdl-layout--fixed-header">
         <header class = "mdl-layout__header">
            <div class = "mdl-layout__header-row">
               <span class = "mdl-layout-title">URL-Shorten App</span>
               <div class = "mdl-layout-spacer"></div>
               <nav class = "mdl-navigation">
                <button ui-sref="logout" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                        <i class="material-icons">logout</i>
                    </button>
               </nav>
            </div>
         </header>
         
         <div class = "mdl-layout__drawer">
         <span class = "mdl-layout-title">Hii! {{firstname + " " + lastname}}</span>
            <nav class = "mdl-navigation">
            <a class="mdl-navigation__link" menu-close ui-sref="short_url">Short URL Tab</a>
            <a class="mdl-navigation__link" menu-close ui-sref="list_url">List Of URLs Tab</a>    
            </nav>
         </div>
      
         <main class = "mdl-layout__content">
            <div class = "page-content">
                <h1 style="text-align: center;">Welcome To Dashboard!!</h1>
                <ui-view></ui-view>
            </div>
         </main>
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="/URL-shorten/ci/javascript/dashboard_app.js"></script>
    </body>
</html>