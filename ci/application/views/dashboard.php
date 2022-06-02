<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>URL Shorten Web App</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	    <script src="https://unpkg.com/@uirouter/angularjs@1.0.30/release/angular-ui-router.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
    </head>
    <body ng-app="dashboardapp">
        <div style="margin-left:1000px;">
            {{firstname + " " + lastname}}
            <a ui-sref="logout" style="margin-left:50px;">Logout</a>
        </div>
        <hr>
        <h1 style="text-align: center;">Welcome to DashBoard!!</h1>
        <div style="margin-left:500px;">
        <a ui-sref="short_url">Short URL Tab</a> |
        <a ui-sref="list_url">List Of URLs Tab</a>
        </div>
        <ui-view></ui-view>

        <script src="/URL-shorten/ci/javascript/dashboard_app.js"></script>
    </body>
</html>