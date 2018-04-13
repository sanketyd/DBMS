<?php
    include('./config.php');

    session_start();

    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $day = check_input($_POST['day']);
            $meal = check_input($_POST['meal']);

            if($stmt = $db_connect->prepare("SELECT extraItem, price FROM Extras WHERE hallName = ? AND day = ? AND meal =?")){
                $stmt->bind_param("sss",$_SESSION['hallName'], $day, $meal);
                $stmt->execute();
                $stmt->bind_result($extra_item, $price);

                $_SESSION['day'] = $day;
                $_SESSION['meal'] = $meal;

                echo "<form action='deletefromtable.php' method='get'>";
                while($stmt->fetch()){
                    echo "<input type='checkbox' name='toDeleteItem[]' value='" . $extra_item . "'/>" . $extra_item . "<br />";
                }
                echo "<input type='submit'/>";
                echo "</form>";

                $stmt->close();
            }
        }
    }
?>

<html>
    <head>
        <title>Delete Item</title>
    </head>
    <body>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            Day:
            <br />
            <input name="day" type="radio" value="MONDAY"<?php echo is_today("MONDAY"); ?>/> MONDAY<br />
            <input name="day" type="radio" value="TUESDAY"<?php echo is_today("TUESDAY"); ?>/> TUESDAY<br />
            <input name="day" type="radio" value="WEDNESDAY"<?php echo is_today("WEDNESDAY"); ?>/>WEDNESDAY <br />
            <input name="day" type="radio" value="THURSDAY"<?php echo is_today("THURSDAY"); ?>/> THURSDAY<br />
            <input name="day" type="radio" value="FRIDAY"<?php echo is_today("FRIDAY"); ?>/> FRIDAY<br />
            <input name="day" type="radio" value="SATURDAY"<?php echo is_today("SATURDAY"); ?>/> SATURDAY<br />
            <input name="day" type="radio" value="SUNDAY"<?php echo is_today("SUNDAY"); ?>/> SUNDAY<br />
            Meal:
            <br />
            <input name="meal" type="radio" value="BREAKFAST" <?php echo is_current_meal("BREAKFAST"); ?>/> BREAKFAST <br />
            <input name="meal" type="radio" value="LUNCH" <?php echo is_current_meal("LUNCH"); ?>/> LUNCH <br />
            <input name="meal" type="radio" value="DINNER"<?php echo is_current_meal("DINNER"); ?> /> DINNER <br />
            <input type="submit" />
        </form>
    </body>
</html>
