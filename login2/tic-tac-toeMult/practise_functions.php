<?php  
	session_start();
	require_once('../config.php');

	/////// Opponent Tournament Results
	if (isset($_POST['displayOppenentDataID'])) {
		$id = $_POST['displayOppenentDataID'];

		$sql = "SELECT * FROM ScoresTic WHERE User_id = '$id' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");
		$row = mysqli_fetch_assoc($result);

		$win = $row['Twin'];
		$losses = $row['Tlosse'];
		$win = round($row['Twin']/2);
		
		$rounds = $win + $losses;
		
		$totalWins = $row['Tour_wins'];
		$totalNums = $row['Tour_nums'];

		$user_data = array($id,$rounds,$win,$totalWins,$totalNums);
		echo json_encode($user_data);
	}

	/////// My Results
	if (isset($_POST['myResultsID'])) {

		$id = $_POST['myResultsID'];
		$sql = "SELECT * FROM ScoresTic WHERE User_id = '$id' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");
		$row = mysqli_fetch_assoc($result);

		$win1 = $row['Pwin']/2;
        $losses = $row['Plosse'];
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

		$Tlosses = $row['Tlosse'];
		$Twin = $row['Twin'];
		$Twin = round($Twin/2);
		
		$TnumGames = $row['Tour_nums'];
		$TnumWin = $row['Tour_wins'];
		
		$user_data = array($id,$win,$losses,$draw,$totalScore,$Twin,$Tlosses,$Tdraw,$TnumGames,$TnumWin);
		echo json_encode($user_data);

	}

	/////// Opponent Tournament Results
	
	
?>