<?php
    include("./config.php");
    session_start();
    if(!isset($_SESSION['hallName'])){
        header("Location: ./index.php");
    }
    if(isset($_SESSION['rollNo'])){
        unset($_SESSION['rollNo']);
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
                    <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                </ul>
                <a href="./additem.php" class="btn btn-success navbar-btn"><span class="glyphicon glyphicon-plus"></span>Add an Item</a>
                <a href="./deleteitem.php" class="btn btn-danger navbar-btn"><span class="glyphicon glyphicon-minus"></span>Delete an Item</a>
                <a href=<?php echo "./data/" . $_SESSION['hallName'] . ".csv"; ?> class="btn btn-info navbar-btn"><span class="glyphicon glyphicon-file"></span>Prevoius Bill</a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./generatebill.php"><span class="glyphicon glyphicon-pencil"></span>Generate Bill</a></li>
                    <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>LogOut</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-2" style="text-align:right">
                    <span class="label label-default">Extra Items</span>
                </div>
                <div class="col-md-10">
                    <?php
                        if($stmt = $db_connect->prepare("SELECT extraItem, price FROM Extras WHERE hallName = ? AND day = ? AND MEAL = ?")){

                            $today = strtoupper(date("l", time()));
                            $time_now = (int)date("G",time());
                            $meal = 'DINNER';

                            if($time_now <= 11){
                                $meal = 'BREAKFAST';
                            } else if(11 < $time_now && $time_now <= 18){
                                $meal = 'LUNCH';
                            }

                            $stmt->bind_param("sss", $_SESSION['hallName'], $today, $meal);
                            $stmt->execute();
                            $stmt->bind_result($extra_item, $item_price);

                            echo "<ul class='list-group'>";

                            while($stmt->fetch()){
                                echo "<li class='list-group-item'>" . $extra_item . "<span class='badge'>" . $item_price . "</span>" . "</li>";
                            }

                            echo "</ul>";

                            $stmt->close();
                        } else {
                            echo "Error while displaying items.";
                        }
                    ?>
                </div>
            </div>
            <form action="./itemlist.php" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-2" for="roll">Roll Number</label>
                    <div class="col-md-10">
                        <input type="text" name="rollNo" class="form-control" placeholder="Your Roll No."/><br />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><span class="glyphicon glyphicon-tags"></span></label>
                    <div class="col-md-10">
                        <input type="submit" value="Buy an Item" class="btn btn-default"/>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
