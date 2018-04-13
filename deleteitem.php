<?php
    include('./config.php');
    session_start();
?>
<html>
    <head>
        <title>Delete Item</title>
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
                    <li><a href="./buyextra.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                </ul>
                <a href="./additem.php" class="navbar-btn btn btn-success"><span class="glyphicon glyphicon-plus"></span>Add an Item</a>
                <a href="./deleteitem.php" class="navbar-btn active"><span class="glyphicon glyphicon-minus"></span>Delete an Item</a>
                <a href=<?php echo "./data/" . $_SESSION['hallName'] . ".csv"; ?> class="btn btn-info navbar-btn"><span class="glyphicon glyphicon-file"></span>Prevoius Bill</a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./generatebill.php"><span class="glyphicon glyphicon-pencil"></span>Generate Bill</a></li>
                    <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>LogOut</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">

        <?php

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

                    echo "<form action='deletefromtable.php' method='get' class='form-horizontal'>";
                    echo "<div class='row'>";
                    echo '
                    <div class="col-md-2" style="text-align:right">
                        <span><b>Items:</b></span>
                    </div>
                    ';
                    echo "<div class='col-md-10'>";
                    while($stmt->fetch()){
                        echo "<div class='checkbox'><label><input type='checkbox' name='toDeleteItem[]' value='" . $extra_item . "'/>" . $extra_item . "</label></div>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label class='control-label col-md-2'><span class='glyphicon glyphicon-minus'></span></label>";
                    echo "<div class='col-md-10'>";
                    echo "<input type='submit' value='Delete Selected Items' class='btn btn-danger col-md-10'/>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";

                    $stmt->close();
                }
            }
        }
        ?>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="form-horizontal">
            <div class="row">
                <div class="col-md-2" style="text-align:right">
                    <span><b>Day:</b></span>
                </div>
                <div class="col-md-10">
                    <div class="radio">
                        <label><input name="day" type="radio" value="MONDAY"<?php echo is_today("MONDAY"); ?>/> MONDAY</label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="TUESDAY"<?php echo is_today("TUESDAY"); ?>/> TUESDAY</label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="WEDNESDAY"<?php echo is_today("WEDNESDAY"); ?>/>WEDNESDAY </label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="THURSDAY"<?php echo is_today("THURSDAY"); ?>/> THURSDAY</label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="FRIDAY"<?php echo is_today("FRIDAY"); ?>/> FRIDAY</label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="SATURDAY"<?php echo is_today("SATURDAY"); ?>/> SATURDAY</label>
                    </div>
                    <div class="radio">
                        <label><input name="day" type="radio" value="SUNDAY"<?php echo is_today("SUNDAY"); ?>/> SUNDAY</label>
                    </div>
                </div>
            </div>
            <div class="row" style="height:10px"></div>
            <div class="row">
                <div class="col-md-2" style="text-align:right">
                    <span><b>Meal:</b></span>
                </div>
                <div class="col-md-10">
                    <div class="radio">
                        <label><input name="meal" type="radio" value="BREAKFAST" <?php echo is_current_meal("BREAKFAST"); ?>/> BREAKFAST</label>
                    </div>
                    <div class="radio">
                        <label><input name="meal" type="radio" value="LUNCH" <?php echo is_current_meal("LUNCH"); ?>/> LUNCH</label>
                    </div>
                    <div class="radio">
                        <label><input name="meal" type="radio" value="DINNER"<?php echo is_current_meal("DINNER"); ?> /> DINNER</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"><span class="glyphicon glyphicon-minus"></span></label>
                <div class="col-md-10">
                    <input type="submit" value="Show Items" class="btn btn-primary col-md-10"/>
                </div>
            </div>
        </form>
    </div>
    </body>
</html>
