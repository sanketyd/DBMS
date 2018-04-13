<?php
    include('./config.php');
    session_start();

    if(isset($_SESSION['hallName']) && isset($_SESSION['rollNo']) && isset($_SESSION['itemsAndPrices']) && isset($_SESSION['currentBill'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $total_price = $_SESSION['currentBill'];

            foreach($_SESSION['itemsAndPrices'] as $item_and_price){
                if(isset($_POST[$item_and_price[0]])){
                    $current_item_quantity = check_input($_POST[$item_and_price[0]]);
                    $total_price = $total_price + $current_item_quantity*$item_and_price[1];

                    if ($current_item_quantity > 0) {
                        if($stmt = $db_connect->prepare("INSERT INTO History (rollNo, onDate, atTime, item, quantity, price) VALUES (?, ?, ?, ?, ?, ?)")){
                            $on_date = date("Y-m-d", time());
                            $at_time = date("G:i:s", time());
                            $this_price = $current_item_quantity*$item_and_price[1];
                            $stmt->bind_param("isssii", $_SESSION['rollNo'], $on_date, $at_time, $item_and_price[0], $current_item_quantity, $this_price);
                            $stmt->execute();
                            $stmt->close();
                        } else {
                            echo "Failed to Log History";
                        }
                    }

                } else {
                    echo "Some Problem Occurred Please Try Again";
                    echo "<a href='./itemlist'>Home</a>";
                }
            }

            if($total_price > 0){
                if($stmt = $db_connect->prepare("UPDATE StudentInfo SET bill = ? WHERE rollNo = ?")){
                    $stmt->bind_param("ii",$total_price,$_SESSION['rollNo']);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                echo "Please Select An Item";
                sleep(5);
                header("Location: ./itemlist.php");
            }
        }

        unset($_SESSION['itemsAndPrices']);
        unset($_SESSION['currentBill']);
        unset($_SESSION['rollNo']);
        echo "<script type='text/javascript'>alert('Done'); window.location.href='./buyextra.php';</script>";

    } else {
        if(!isset($_SESSION['hallName'])){
            header("Location: ./index.php");
        } else if(!isset($_SESSION['rollNo'])){
            header("Location: ./buyextra.php");
        }
    }
?>
