<?php
	include("./config.php");
	session_start();


    if(isset($_SESSION['hallName'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          	$is_dues = TRUE; 
            if($stmt = $db_connect->prepare("SELECT bill FROM StudentInfo WHERE rollNo = ?") && $_POST['day'] == "YES" ){
            	$stmt->bind_param("i",$_SESSION['rollNo']);
            	$stmt->execute();
            	$stmt->bind_result($bill);
            	$stmt->fetch();
            	if($bill == 0){
            		$is_dues= FALSE;
            	}
            }


        	if($stmt = $db_connect->prepare("DELETE FROM StudentInfo WHERE rollNo = ? ") && !($is_dues)){
        		$stmt->bind_param("i",$_SESSION['rollNo']);
        		$stmt->execute();
        		$stmt->close();
	     	    echo  "<a href="./buyextra.php">Home</a>";
			}
	}
	else{
        header("Location: ./index.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Are you sure you want to delete your name from hall </title>
</head>
<body>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
		<input name="day" type="radio" value="YES"/> YES<br />
        <input name="day" type="radio" value="NO"/> NO<br />
	</form>
</body>
</html>