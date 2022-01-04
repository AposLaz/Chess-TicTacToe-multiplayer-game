<?php
	/*
		Me auti ti sunartisi dinoume se kathe xristi ton antiplao tou 
	*/
	session_start();
	require_once("../config.php");
	/* ------------------------ ELEGXOS EGKYROTITAS --------------------*/
	
	//pairnoume to paixnidi me ton antipalo mas
	$token=$_GET["id"];
	//$UserName=$_SESSION['UserName'];
	$_SESSION['GameId']=$token;
	
	//pairnoume to id(oxi to name) tou antipalou mas
	$opponent=$_GET["name"];
	$_SESSION['Opponent']=$opponent;
	//to id mas
	$id = $_SESSION["UserId"];
	
	$sql = "SELECT * FROM Game WHERE UserID = '$id' ";	
	$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
	
	if(mysqli_num_rows($result) == 0) { // evaluate the count
		return "Tom";
	}
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)){
			if ($row["UserGameId"] == 1) {
				$color="white";
				$move = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
				// Update User
				$sql2 = "UPDATE Game SET UserGameOpponent = '$opponent' , UserGameId = '$token' , LastMove = '$move' , UserGameColor = '$color' WHERE UserID = '$id' ";
				$result2 = mysqli_query($link, $sql2) or die("Error in connection");

				$color="black";
				// Update Opponent
				// Update User
				$sql1 = "UPDATE Game SET UserGameOpponent = '$id' , UserGameId = '$token' , LastMove = '$move' , UserGameColor = '$color' WHERE UserID = '$opponent' ";
				$result1 = mysqli_query($link, $sql1) or die("Error in connection");

			}
		}
	}
	header("Location: Ch/index.php");
?>