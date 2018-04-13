<?php
include("./config.php");
session_start();


if(isset($_SESSION['hallName'])){
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$is_dues = TRUE;
		if(($stmt = $db_connect->prepare("SELECT bill FROM StudentInfo WHERE rollNo = ? ")) && ($_POST['confirm'] == "YES")){
			$stmt->bind_param("i",$_SESSION['rollNo']);
			$stmt->execute();
			$stmt->bind_result($bill);
			$stmt->fetch();
			$stmt->close();
			if($bill == 0){
				$is_dues= FALSE;
			}
		}
		if(($stmt= $db_connect->prepare("DELETE FROM StudentInfo WHERE rollNo = ?")) && (!$is_dues)){
			$stmt->bind_param("i",$_SESSION['rollNo']);
			$stmt->execute();
			$stmt->close();
			echo "<script type='text/javascript'>alert('Done'); window.location.href='./buyextra.php';</script>";
		}
		else if($is_dues && $_POST['confirm']=="YES"){
			echo "<script type='text/javascript'>alert('Clear the dues first!!'); window.location.href='./buyextra.php';</script>";
		}
		else{
			header("Location: ./buyextra.php");
		}

	}
}
else{
	header("Location: ./index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
		<font size=3.5>
			<div style="height: 100px">
			</div>
			<div align="center">
				Are you sure you want to leave?

			</font>
			<div >
				<div >
					<center>
						<label> <input name="confirm" type="radio" value="YES"/> YES </label>
						<label> <input name="confirm" type="radio" value="NO"/> NO </label>
						<br>
						<label> <input type="submit" value = "submit" class=" btn btn-danger" /></label>
					</center>
				</div>

			</div>
		</div>
	</form>
</body>
</html>
