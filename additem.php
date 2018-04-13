<?php
    include('./config.php');

    session_start();

    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $extra_item = check_input($_POST['itemNew']);
            $item_price = check_input($_POST['itemPrice']);
            $day = check_input($_POST['day']);
            $meal = check_input($_POST['meal']);

            if($stmt = $db_connect->prepare("INSERT INTO Extras (hallName, day, meal, extraItem, price) VALUES (?, ?, ?, ?, ?)")){
                $stmt->bind_param("ssssi",$_SESSION['hallName'],$day,$meal,$extra_item,$item_price);
                if($stmt->execute()){
                    echo "<span style='color: green'>Success!</span>";
                } else {
                    echo "<span style='color: red'>Failed!</span>";
                }
                $stmt->close();
            }
        }
    } else {
        header("Location: ./index.php");
    }
?>
<html>
    <head>
        <title>Add Item</title>
    </head>
    <body>
        <form action=<? php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Extra Item: <input name="itemNew" type="text"/>
            <br />
            Price: <input name="itemPrice" type="text"/>
            <br />
            Day:
            <br />
            <input name="day" type="radio" value="MONDAY"/> MONDAY<br />
            <input name="day" type="radio" value="TUESDAY"/> TUESDAY<br />
            <input name="day" type="radio" value="WEDNESDAY"/>WEDNESDAY <br />
            <input name="day" type="radio" value="THURSDAY"/> THURSDAY<br />
            <input name="day" type="radio" value="FRIDAY"/> FRIDAY<br />
            <input name="day" type="radio" value="SATURDAY"/> SATURDAY<br />
            <input name="day" type="radio" value="SUNDAY"/> SUNDAY<br />
            Meal:
            <br />
            <input name="meal" type="radio" value="BREAKFAST" /> BREAKFAST <br />
            <input name="meal" type="radio" value="LUNCH" /> LUNCH <br />
            <input name="meal" type="radio" value="DINNER" /> DINNER <br />
            <input type="submit" />
        </form>
        <a href="./buyextra.php">Home</a>
    </body>
</html>
