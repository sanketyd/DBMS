<?php
    require('./config.php');
    session_start();

    if(isset($_SESSION['hallName']) && isset($_SESSION['rollNo'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $student_name = check_input($_POST['studentName']);
            $room_no = check_input($_POST['roomNo']);

            if($stmt = $db_connect->prepare("INSERT INTO StudentInfo (rollNo, name, hallName, roomNo, bill) VALUES(?, ?, ?, ?, ?)")){
                $stmt->bind_param("isssi", $_SESSION['rollNo'], $student_name, $_SESSION['hallName'], $room_no, $ZERO);
                if($stmt->execute()){
                    echo "Insertion Succesful";
                    sleep(1);
                    header("Location: ./buyextra.php");
                } else {
                    echo "Insertion Failed";
                }
                $stmt->close();
            }
        }
    } else {
        echo "There is something wrong please try again";
        echo "<a href='./index.php'>Home</a>";
    }
?>
