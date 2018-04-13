<?php
    include("./config.php");
    session_start();

    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

             $rollNo = (int)check_input($_POST['rollNo']);
             if((string)$rollNo == $_POST['rollNo']){
                 $_SESSION['rollNo'] = $rollNo;

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
                         echo "<img src='https://oa.cc.iitk.ac.in/Oa/Jsp/Photo/" . $rollNo . "_0.jpg' /> <br />";
                         echo "Name:" . $name . "<br />";
                         echo "Hall No.:" . $hallName . "<br />";
                         echo "Room No.:" . $roomNo . "<br />";
                         echo "Current Extra's Bill:" . $bill . "<br />";
                     } else {
                         $student_exists = FALSE;
                         echo "Entry doesn't Exist\n";
                         echo '<form action="./newuser.php" method="post">
                            Name: <input type="text" name="studentName"/> <br />
                            Room No.: <input type="text" name="roomNo"/> <br />
                            <input type="submit"/>
                         </form>';
                     }

                     $stmt->close();
                 }

                 if(($stmt = $db_connect->prepare("SELECT extraItem, price FROM Extras WHERE hallName = ? AND day = ? AND MEAL = ?")) && $student_exists){

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

                     $_SESSION['itemsAndPrices'] = array();

                     $is_list_empty = TRUE;

                     while($stmt->fetch()){
                         $is_list_empty = FALSE;
                         array_push($_SESSION['itemsAndPrices'], array($extra_item, $item_price));
                         echo "Item Name: " . $extra_item . " Price: " . $item_price . " Quantity: <input name='" . $extra_item . "' type='text' value=0 /><br />";
                     }

                     if(!$is_list_empty){
                         echo "<input type='submit'/>";
                     }
                     echo "</form>";
                     $stmt->close();
                 }
             } else {
                 echo "Check entered Roll No.";
             }

        } else {
            echo "Please Enter Roll No.\n";
            sleep(4);
            header("Location: ./buyextra.php");
        }
    } else {
        header("Location: ./index.php");
    }
?>
