<?php
	include("./config.php");
	session_start();

    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

        	if($stmt = $db_connect->prepare("DELETE FROM StudentInfo WHERE rollNo = ? "))
        		$stmt->bind_param("i",$_SESSION['rollNo']);
        		$stmt->execute();
        		$stmt->close();
		}
	}
	else{
        header("Location: ./index.php");
	}


?>