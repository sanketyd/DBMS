<?php
    include("./config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $hall_name = check_input($_POST["hall_name"]);
        $password = hash('sha256',check_input($_POST["password"]));

        if($stmt = $db_connect->prepare("SELECT password FROM HallLogin WHERE hallName = ?")){
            $stmt->bind_param("s", $hall_name);

            $stmt->execute();

            $stmt->bind_result($db_password);

            $stmt->fetch();

            if($db_password == $password){
                session_start();

                $_SESSION['hallName'] = $hall_name;

                header("Location: ./buyextra.php");

            } else {
                header("Location: ./index.php");
            }

            $stmt->close();
        }
    }
?>
