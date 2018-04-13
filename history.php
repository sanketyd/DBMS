<?php
    include("./config.php");
    session_start();
?>
<html>
    <head>
        <title>History</title>
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
                    <li><a href="./itemlist.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                    <li><a href="./deletestudent.php"><span class="glyphicon glyphicon-trash"></span>Delete From Hall</a></li>
                    <li><a href="./changeroomno.php"><span class="glyphicon glyphicon-pencil"></span>Change Room</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="./history.php"><span class="glyphicon glyphicon-file"></span>History</a></li>
                    <li><a href="./buyextra.php"><span class="glyphicon glyphicon-remove-sign"></span>Cancel</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <table class="table table-bordered">
                <tr>
                    <th>
                        Roll No.
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Time
                    </th>
                    <th>
                        Item
                    </th>
                    <th>
                        Quantity
                    </th>
                    <th>
                        Price
                    </th>
                </tr>
                <?php
                    if(isset($_SESSION['hallName']) && isset($_SESSION['rollNo'])){
                        if($stmt = $db_connect->prepare("SELECT * FROM History WHERE rollNo = ? ORDER BY onDate DESC, atTime DESC")){
                            $stmt->bind_param("i",$_SESSION['rollNo']);
                            $stmt->execute();
                            $stmt->bind_result($roll_no, $on_date, $at_time, $item, $quantity, $price);
                            while($stmt->fetch()){
                                echo "<tr>
                                    <td>
                                    $roll_no
                                    </td>
                                    <td>
                                    $on_date
                                    </td>
                                    <td>
                                    $at_time
                                    </td>
                                    <td>
                                    $item
                                    </td>
                                    <td>
                                    $quantity
                                    </td>
                                    <td>
                                    $price
                                    </td>
                                </tr>";
                            }
                            $stmt->close();
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>
