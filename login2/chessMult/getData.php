<?php 
	session_start();
	require_once('../config.php');

	if (isset($_POST['userID'])) {
		$id = $_POST['userID'];
		$sql = "SELECT * FROM Scores WHERE User_id = '$id' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");
		$row = mysqli_fetch_assoc($result);

		$win = $row['Twin'];
		$losses = $row['Tloose'];
		$draw = $row['Tdraw'];
		$win = round($row['Twin']/2);
		
		$numGames = $win + $losses;

		$totalWins = $row['TournamentsWin'];
		$totalNums = $row['TournamentsNum'];
		
		$user_data = array($id,$numGames,$win,$totalWins,$totalNums);
		echo json_encode($user_data);
	}

	if (isset($_POST['myID'])) {

		$id = $_POST['myID'];
		$sql = "SELECT * FROM Scores WHERE User_id = '$id' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");
		$row = mysqli_fetch_assoc($result);

		$win1 = $row['Pwin']/2;
        $losses = $row['Ploose'];
        $draw = $row['Pdraw'];

        $win = round($win1) + $draw;
        $numGames = $win + $losses + $draw;
        if($numGames > 0)
        {
          $totalScore = round(($win*100)/$numGames);
        }
        else{
          $totalScore = 0;
        }

		$Tlosses = $row['Tloose'];
		$Tdraw = $row['Tdraw'];
		$Twin = $row['Twin'];
		$Twin = round($Twin/2);
		
		$TnumGames = $row['TournamentsNum'];
		$TnumWin = $row['TournamentsWin'];
		
		$user_data = array($id,$win,$losses,$draw,$totalScore,$Twin,$Tlosses,$Tdraw,$TnumGames,$TnumWin);
		echo json_encode($user_data);

	}

?>