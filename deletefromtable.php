<?php
    include("./config.php");

    session_start();

    if(isset($_SESSION['hallName']) && isset($_SESSION['day']) && isset($_SESSION['meal'])){
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if($stmt = $db_connect->prepare("DELETE FROM Extras WHERE hallName = ? AND day = ? AND meal = ? AND extraItem = ?")){
                if(!isset($_GET['toDeleteItem'])){
                    header("Location: ./deleteitem.php");
                }
                foreach ($_GET['toDeleteItem'] as $to_delete_item) {
                    $stmt->bind_param("ssss", $_SESSION['hallName'], $_SESSION['day'], $_SESSION['meal'], $to_delete_item);
                    $stmt->execute();
                }
                $stmt->close();
            }
            unset($_SESSION['day']);
            unset($_SESSION['meal']);
            header("Location: ./buyextra.php");
        }
    } else {
        if(isset($_SESSION['hallName'])){
            header("Location: ./buyextra.php");
        } else {
            header("Location: ./index.php");
        }
    }
?>
