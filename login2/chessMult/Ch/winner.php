<?php 
	session_start();
	//db connection
	$link = mysqli_connect("db","root","root","project");
	if($link === false){die("ERROR: Could not connect. ");}

	//black wins
	if(isset($_POST['id']))
	{
		$user_id = $_POST['id'];

		$sql = "SELECT * FROM Game WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			$color = $row['UserGameColor'];
			//xaneis
			if($color == "white")
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$lost = $row1['Ploose'];
				$lost = $lost + 1;
				$fin = "ok";

				$sql1 = "UPDATE Scores SET Ploose = '$lost' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");
				$output = array("msg"=>"YOU LOST!!! GAME OVER", "loggedin"=>"true");
			}
			else //kerdizeis
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['Pwin'];

					//oi nikes anevainoun *2
					$win = $win + 1;
				$fin = "ok";
				$sql1 = "UPDATE Scores SET Pwin = '$win' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");
				$output = array("msg"=>"YOU WIN!!! CONGRATULATIONS", "loggedin"=>"true");
			}
			echo json_encode($output);
		}
	}
	//white wins
	if(isset($_POST['id1']))
	{
		$user_id = $_POST['id1'];

		$sql = "SELECT * FROM Game WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			$color = $row['UserGameColor'];
			//xaneis
			if($color == "black")
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$lost = $row1['Ploose'];
				$lost = $lost + 1;
				$fin = "asdasd";
				$sql1 = "UPDATE Scores SET Ploose = '$lost' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die(mysqli_error($link));
				$ok = 10;
				$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"YOU LOST!!! GAME OVER", "loggedin"=>"true");
			}
			else //kerdizeis
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['Pwin'];

					//oi nikes anevainoun *2
					$win = $win + 1;
				$fin = "asdasd";
				$sql1 = "UPDATE Scores SET Pwin = '$win' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die(mysqli_error($link));
				$ok = 10;
				$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"YOU WIN!!! CONGRATULATIONS", "loggedin"=>"true");
			}
			echo json_encode($output);
		}
	}

	if(isset($_POST['id2']))
	{
		$user_id = $_POST['id2'];

		$sql = "SELECT * FROM Game WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$draw = $row1['Pdraw'];
				$draw = $draw + 1;
				$fin = "asdasd";
				$sql1 = "UPDATE Scores SET Pdraw = '$draw' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"THE GAME IS DRAW!!!", "loggedin"=>"true");
		}
		echo json_encode($output);
	}

//if you want to leave from the game
	include '../classes/move.php';
	if (isset($_POST['leave_now'])) {
		$firstMove = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		$firstMove1 = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 0";
		$move = new move();
		$lMove=$move->getLastMove($_SESSION['GameId']);
		$id = $_SESSION['UserId'];

		$sql = "SELECT * FROM Game WHERE UserID = '$id'";
		$result5 = mysqli_query($link, $sql)or die("Smt goes wrong");
		$row5 = mysqli_fetch_assoc($result5);
		$fin = $row5['FINISH'];
		//echo $lMove;
		if($lMove != $firstMove && $fin <= 1)
		{
			//echo $lMove;
			$sql = "SELECT * FROM Game WHERE UserID = '$id'";
			$result1 = mysqli_query($link, $sql)or die("Smt goes wrong");
			$row1 = mysqli_fetch_assoc($result1);
			$gameID = $row1['UserGameId'];

			if($gameID <= 1){ //den exw antipalo
				header("Location: ../chess.php");
			}
			else{ //exw antipalo
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result = mysqli_query($link, $sql)or die("Something goes wrong");
				$row = mysqli_fetch_assoc($result);

				$lost = $row['Ploose'];
				$lost = $lost + 1;

				$sql1 = "UPDATE Scores SET Ploose = '$lost' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");

				if($result2){
					header("Location: ../chess.php");
				}
				else{
					echo "Oups Bad connection";
				}
			}
		}
		else
		{
			header("Location: ../chess.php");
		}
	}
	//your opponent left
	if (isset($_POST['idleft'])) {
		$id = $_POST['idleft'];
		$sql = "SELECT * FROM Game WHERE UserID = '$id'";
		$result = mysqli_query($link, $sql)or die("Smt ges wrong");
		$row = mysqli_fetch_assoc($result);

		$gameID = $row['UserGameId'];	
		$gameOpp = $row['UserGameOpponent'];
		if($gameID <= 1 || $gameOpp == "")
		{
			$output = array("msg"=>"YOUR OPPONENT LEFT!!!", "loggedin"=>"true");
		}
		else{
			$output = array("msg"=>"", "loggedin"=>"true");
		}
		echo json_encode($output);
	}

	//check if our game is finished
	if (isset($_POST['newGameID'])){
		$id = $_POST['newGameID'];

		$sql = "SELECT * FROM Game WHERE UserID = '$id'";
		$result = mysqli_query($link, $sql)or die("Smt ges wrong");
		$row = mysqli_fetch_assoc($result);

		$ok = $row['FINISH'];
		if($ok <= 1)
		{
			$output = array("msg"=>"YOU HAVE TO FINISH THIS GAME FIRST!!!", "loggedin"=>"true");
		}
		else
		{
			$ok = 0;
			$sql3 = "UPDATE Game SET FINISH = '$ok' WHERE UserID = '$id' ";
			$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");
			$output = array("msg"=>"success", "loggedin"=>"true");
		}
		echo json_encode($output);
	}

?>