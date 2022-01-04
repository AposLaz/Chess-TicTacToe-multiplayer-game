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
	
	$sql = "SELECT * FROM GameTic WHERE UserID = '$id' ";	
	$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
	
	if(mysqli_num_rows($result) == 0) { // evaluate the count
		return "Tom";
	}
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)){
			if ($row["GameID"] == 1) {

				//generate random number for user
				$posit = rand(1,2);

				if($posit == 1){
					$color="green";
					$color_opp = "red";
					$myturn = 1;
					$oppturn = 0;
				}
				else{
					$color="red";
					$color_opp = "green";
					$myturn = 0;
					$oppturn = 1;
				}

				// Update User
				$sql2 = "UPDATE GameTic SET OppID = '$opponent' , GameID = '$token' , Color = '$color', Turn = '$myturn' WHERE UserID = '$id' ";
				$result2 = mysqli_query($link, $sql2) or die("Error in connection");

				// Update Opponent
				// Update User
				$sql1 = "UPDATE GameTic SET OppID = '$id' , GameID = '$token' , Color = '$color_opp' , Turn = '$oppturn' WHERE UserID = '$opponent' ";
				$result1 = mysqli_query($link, $sql1) or die("Error in connection");

				////Insert moveTable
				$num = 0;
				$sql3 = "INSERT INTO MovesTic (p00,p01,p02,p10,p11,p12,p20,p21,p22,Game_id)VALUES ('$num','$num','$num','$num','$num','$num','$num','$num','$num','$token') ";
				$result3 = mysqli_query($link, $sql3) or die(mysqli_error($link));

			}
		}
	}
	header("Location: Tic/index.php");

?>