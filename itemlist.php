<?php
    include("./config.php");
    session_start();

    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

             $rollNo = (int)$_POST['rollNo'];
             if((string)$rollNo == $_POST['rollNo']){
                 $_SESSION['rollNo'] = $rollNo;

                 if($stmt = $db_connect->prepare("SELECT name, hallName, roomNo, bill FROM StudentInfo WHERE rollNo = ?")){
                     $stmt->bind_param("i",$rollNo);
                     $stmt->execute();
                     $stmt->bind_result($name, $hallName, $roomNo, $bill);
                     if($stmt->fetch()){
                         echo "<img src='https://oa.cc.iitk.ac.in/Oa/Jsp/Photo/" . $rollNo . "_0.jpg' /> <br />";
                         echo "Name:" . $name . "<br />";
                         echo "Hall No.:" . $hallName . "<br />";
                         echo "Room No.:" . $roomNo . "<br />";
                         echo "Current Extra's Bill:" . $bill . "<br />";
                     } else {
                         echo "Entry doesn't Exist\n";
                         echo '<form action="./neworedit.php" method="post">
                            Name: <input type="text" name="studentName"/> <br />
                            Room No.: <input type="text" name="roomNo"/> <br />
                            <input type="submit"/>
                         </form>';
                     }

                     $stmt->close();
                 }

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

                     echo "<form action='./itembought.php' method='post'>";

                     while($stmt->fetch()){
                         echo "Item Name: " . $extra_item . " Price: " . $item_price . "<input name='" . $extra_item . "' type='text'/><br />";
                     }

                     echo "<input type='submit'/>";
                     echo "</form>";
                     $stmt->close();
                 }
             } else {
                 echo "Check enetered Roll No.";
             }

        } else {
            echo "Please Enter Roll No.\n";
            sleep(4);
            header("Location: ./buyextra.php");
        }
    } else {
        echo "Please Login First.\n";
        sleep(4);
        header("Location: ./index.php");
    }
?>
