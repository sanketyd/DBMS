<?php
	include("./config.php");
	session_start();

    if(isset($_SESSION['hallName']) && isset($_SESSION['rollNo'])){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if($stmt = $db_connect->prepare("UPDATE StudentInfo SET roomNo= ? WHERE rollNo=?")){
				$stmt->bind_param("si",$_POST['roomNo'],$_SESSION['rollNo']);
				$stmt->execute();
				$stmt->close();
    	        echo "<script type='text/javascript'>alert('Done'); window.location.href='./buyextra.php';</script>";
			}
		}
	}
	else{
		header("Location: ./index.php");
	}
?>

<html>

<head>
	<title>new roomno</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
	<form action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method = "post" class="form-horizontal" >
		<div class="form-group">
			<div style="height: 100px">	</div>
			<label class="control-label col-md-2" for="username">Enter new room no:</label>
			<div class="col-md-10">
				<input type="text" name="roomNo"  class="form-control" placeholder="RoomNo"> <br>
			</div>
			<div style="height: 10px"> </div>
		<div class="form-group">
                    <label class="control-label col-md-2"><span class="glyphicon glyphicon-pencil"></span></label>
                    <div class="col-md-10">
                        <input class="btn btn-success" type="submit" value="Submit" />
                    </div>
                </div>
		</div>

	</form>
	</div>
</body>

</html>
