<?php session_start(); session_destroy(); ?>
<html>
    <head>
        <title>Welcome to Mess Management IITK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <h2>Mess Management IITK</h2>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <form action="./logincheck.php" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-2" for="username">Hall Name/No.</label>
                    <div class="col-md-10">
                        <input type="text" name="hall_name" class="form-control" placeholder="Enter Hall Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2" for="password">Password</label>
                    <div class="col-md-10">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><span class="glyphicon glyphicon-log-in"></span></label>
                    <div class="col-md-10">
                        <input class="btn btn-success" type="submit" value="Login" />
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
