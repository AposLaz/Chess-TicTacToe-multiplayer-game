<?php 
	session_start();
	//db connection
	$link = mysqli_connect("db","root","root","project");
	if($link === false){die("ERROR: Could not connect. ");}

	//----Winners

		//black wins
	if(isset($_POST['idwin1']))
	{
		$user_id = $_POST['idwin1'];

		$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			$color = $row['UserColor'];
			$Roundd = $row['Round'];
			//xaneis
			if($color == "white")
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$lost = $row1['Tloose'];
				$lost = $lost + 1;
				$sql1 = "UPDATE Scores SET Tloose = '$lost' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE ChessTourRoom SET Finish = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");
				$output = array("msg"=>"YOU LOST!!! GAME OVER", "loggedin"=>"true");
			}
			else //kerdizeis
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['Twin'];

					//oi nikes anevainoun *2
					$win = $win + 1;
				$Roundd = $Roundd + 1;
				$sql1 = "UPDATE Scores SET Twin = '$win' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE ChessTourRoom SET Finish = '$ok' , Round = '$Roundd' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");
				$output = array("msg"=>"YOU WIN!!! CONGRATULATIONS", "loggedin"=>"true");
			}
			echo json_encode($output);
		}
	}
	//white wins
	if(isset($_POST['idwin2']))
	{
		$user_id = $_POST['idwin2'];
		$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			$color = $row['UserColor'];
			$Roundd = $row['Round'];

			//xaneis
			if($color == "black")
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$lost = $row1['Tloose'];
				$lost = $lost + 1;

				$sql1 = "UPDATE Scores SET Tloose = '$lost' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die(mysqli_error($link));
				$ok = 10;
				$sql3 = "UPDATE ChessTourRoom SET Finish = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"YOU LOST!!! GAME OVER", "loggedin"=>"true");
			}
			else //kerdizeis
			{
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['Twin'];

					$win = $win + 1;
					$Roundd = $Roundd + 1;
				$sql1 = "UPDATE Scores SET Twin = '$win' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die(mysqli_error($link));
				$ok = 10;
				$sql3 = "UPDATE ChessTourRoom SET Finish = '$ok' , Round = '$Roundd' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"YOU WIN!!! CONGRATULATIONS", "loggedin"=>"true");
			}
			echo json_encode($output);
		}
	}
	//draw
	if(isset($_POST['idwin3']))
	{
		$user_id = $_POST['idwin3'];

		$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$user_id'";
		$result = mysqli_query($link, $sql)or die("Something goes wrong");
		if(mysqli_num_rows($result)>0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['UserID'];
			
				$sql = "SELECT * FROM Scores WHERE User_id = '$id'";
				$result1 = mysqli_query($link, $sql)or die("Something goes wrong");
				$row1 = mysqli_fetch_assoc($result1);

				$draw = $row1['Tdraw'];
				$draw = $draw + 1;

				$sql1 = "UPDATE Scores SET Tdraw = '$draw' WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql1)or die("Smt ges wrong");
				$ok = 10;
				$sql3 = "UPDATE ChessTourRoom SET Finish = '$ok' WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql3)or die("Smt ges wrong");

				$output = array("msg"=>"THE GAME IS DRAW!!!", "loggedin"=>"true");
		}
		echo json_encode($output);
	}


?>