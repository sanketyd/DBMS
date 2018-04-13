<?php
    session_start();
    if(!isset($_SESSION['hallName'])){
        header("Location: ./index.php");
    }
?>
<html>
    <head>
        <title>Buy Extra</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Mess Management IITK</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./generatebill.php" class="btn btn-danger" style="color:white"><span class="glyphicon glyphicon-pencil"></span>Generate Bill</a></li>
                    <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>LogOut</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <form action="./itemlist.php" method="post">
                Roll No: <input type="text" name="rollNo"/><br />
                <input type="submit"/>
            </form>
            <a href="./additem.php" class="btn btn-success col-md-12">Add an Item</a>
            <br />
            <a href="./deleteitem.php">Delete Items</a>
            <br />
            <a href="./generatebill.php" style="color:red">Download this month's bill</a>
            <br />
            <a href="./logout.php">Log Out</a>
        </div>
    </body>
</html>
