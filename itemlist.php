<?php
    include("./config.php");
    session_start();
?>
<html>
<head>
    <title>Select Item</title>
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
                    <li><a href="./deletestudent.php"><span class="glyphicon glyphicon-trash"></span>Delete From Hall</a></li>
                    <li><a href="./changeroomno.php"><span class="glyphicon glyphicon-pencil"></span>Change Room</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./history.php"><span class="glyphicon glyphicon-file"></span>History</a></li>
                    <li><a href="./buyextra.php"><span class="glyphicon glyphicon-remove-sign"></span>Cancel</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <table class="table table-hover">
            <?php
            if(isset($_SESSION['hallName'])){
                if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_SESSION['rollNo'])){

                    $rollNo = 0;
                    $post_roll_no = "";
                    if(isset($_SESSION['rollNo'])) $rollNo = $_SESSION['rollNo'];
                    else $rollNo = (int)check_input($_POST['rollNo']);

                    if(isset($_POST['rollNo'])) $post_roll_no = $_POST['rollNo'];
                    if((string)$rollNo == $post_roll_no || isset($_SESSION['rollNo'])){
                        unset($post_roll_no);
                        if(!isset($_SESSION['rollNo'])) $_SESSION['rollNo'] = $rollNo;

                        $student_exists = TRUE;

                        if($stmt = $db_connect->prepare("SELECT name, hallName, roomNo, bill FROM StudentInfo WHERE rollNo = ?")){
                            $stmt->bind_param("i",$rollNo);
                            $stmt->execute();
                            $stmt->bind_result($name, $hallName, $roomNo, $bill);
                            if($stmt->fetch()){
                                if($_SESSION['hallName'] != $hallName){
                                    echo "<span style='color:red'>Warning: Student doesn't belong to Hall" . $_SESSION['hallName'] . "</span><br />";
                                }
                                $_SESSION['currentBill'] = $bill;
                                echo "<tr><td></td><td>";
                                echo "<img src='https://oa.cc.iitk.ac.in/Oa/Jsp/Photo/" . $rollNo . "_0.jpg' class='img-circle' /> </td> </tr>";
                                echo "<tr>";
                                echo "<td> Name </td> <td>" . $name . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td> Hall No.</td> <td>" . $hallName . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td> Room No.</td> <td>" . $roomNo . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td> Current Extra's Bill</td> <td>" . $bill . "</td>";
                                echo "</tr>";
                                echo "</table>";
                            } else {
                                $student_exists = FALSE;
                                echo "<tr> <td> Entry doesn't Exist </td> </tr> </table>\n";
                                echo '<form action="./newuser.php" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="name"> Name </label>
                                    <div class="col-md-10" > <input type="text" name="studentName" class="form-control"/> </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="room"> Room No. </label>
                                    <div class="col-md-10" > <input type="text" name="roomNo" class="form-control"/> </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2"><span class="glyphicon glyphicon-plus"></span></label>
                                    <div class="col-md-10"> <input type="submit" class="btn btn-success"/> </div>
                                </div>
                                </form>';
                            }

                            $stmt->close();
                        }

                        if(($stmt = $db_connect->prepare("SELECT extraItem, price FROM Extras WHERE hallName = ? AND day = ? AND meal = ?")) && $student_exists){

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

                            echo "<form action='./itembought.php' method='post' class='form-horizontal'>";

                            $_SESSION['itemsAndPrices'] = array();

                            $is_list_empty = TRUE;

                            echo "<table class='table table-bordered'>\n";
                            echo "<tr><th>Item Name</th><th>Item Price</th><th>Quantity</th></tr>";
                            while($stmt->fetch()){
                                $is_list_empty = FALSE;
                                array_push($_SESSION['itemsAndPrices'], array($extra_item, $item_price));
                                echo "<tr><td> " . $extra_item . "</td> <td>" . $item_price . "</td> <td class='form-group'> <input name='" . $extra_item . "' type='text' value=0 class='form-control'/></td></tr>";
                            }
                            echo "</table>\n";

                            if(!$is_list_empty){
                                echo "<input type='submit' class='btn btn-info col-md-12'/>";
                            }
                            echo "</form>";
                            $stmt->close();
                        }
                    } else {
                        echo "Check entered Roll No.";
                    }

                } else {
                    echo "Please Enter Roll No.\n";
                    header("Location: ./buyextra.php");
                }
            } else {
                header("Location: ./index.php");
            }
            ?>
        </div>
    </body>
</html>
