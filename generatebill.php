<?php
    include('./config.php');
    session_start();

    echo "Please Wait!";

    if(isset($_SESSION['hallName'])){
        if($stmt = $db_connect->prepare("SELECT rollNo, name, roomNo, bill FROM StudentInfo WHERE hallName = ?")){
            $stmt->bind_param("s",$_SESSION['hallName']);
            $stmt->execute();
            $stmt->bind_result($roll_no, $name, $room_no, $bill);

            $output_file = fopen("./data/" . $_SESSION['hallName'] . ".csv", "w");

            while($stmt->fetch()){
                echo $roll_no;
                $temp_csv_array = array($roll_no, $name, $room_no, $bill);
                fputcsv($output_file, $temp_csv_array);
            }

            fclose($output_file);
        }

        if($stmt = $db_connect->prepare("UPDATE StudentInfo SET bill = 0 WHERE hallName = ?")){
            $stmt->bind_param("s", $_SESSION['hallName']);
            $stmt->execute();
            $stmt->close();
        }

        if($stmt = $db_connect->prepare("DELETE FROM History WHERE onDate < ? AND rollNo IN (SELECT rollNo FROM StudentInfo WHERE hallName = ?)")){
            $date_two_month_before = date("Y:m:d",time()-5184000);
            $stmt->bind_param("ss",$date_two_month_before,$_SESSION['hallName']);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: ./data/" . $_SESSION['hallName'] . ".csv");
    } else {
        header("Location: ./index.php");
    }
?>
