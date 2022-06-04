<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>URL Shorten Web App</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	    <script src="https://unpkg.com/@uirouter/angularjs@1.0.30/release/angular-ui-router.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            .uiview{
                border: 2px solid black;
                display: inline-block;
                justify-content: center;
                padding:10px;
                margin-left: 500px;   
            }
        </style>
    </head>
    <body ng-app="userapp">
        <p style="text-align: center;font-size: 40px;">Welcome to URL Shorten Web App</p>
        <div class="uiview"><ui-view></ui-view></div>
        <script src="/URL-Shorten/ci/javascript/user_app.js"></script>
    </body>
</html>