<?php
    session_start();
    if(!isset($_SESSION['hallName'])){
        header("Location: ./index.php");
    }
?>
<html>
    <head>
        <title>Buy Extra</title>
    </head>
    <body>
        <form action="./itemlist.php" method="post">
            Roll No: <input type="text" name="rollNo"/><br />
            <input type="submit"/>
        </form>
        <a href="./additem.php">Add an Item</a>
        <br />
        <a href="./deleteitem.php">Delete Items</a>
        <br />
        <a href="./generatebill.php" style="color:red">Download this month's bill</a>
        <br />
        <a href="./logout.php">Log Out</a>
    </body>
</html>
