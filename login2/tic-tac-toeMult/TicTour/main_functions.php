<?php  
	session_start();
	include "../classes/userTourTic.php";
	$user = new userTourTic();
/////get color for user
	if(isset($_POST['colorID']))
	{
		$id = $_POST['colorID'];
		$color = $user->getUserColor($id);

		$output = array("msg"=>"$color", "loggedin"=>"true");
		echo json_encode($output);
	}
	/////get My Turn [1,9] for user
	if(isset($_POST['getMymovesID']))
	{
		$id = $_POST['getMymovesID'];
		$turn = $user->getTurn($id);

		$output = array("msg"=>"$turn", "loggedin"=>"true");
		echo json_encode($output);
	}

	/////get Opponent turn [1,9] for user
	if(isset($_POST['getOppmovesID']))
	{
		$id = $_POST['getOppmovesID'];
		$turn = $user->getTurn($id);

		$output = array("msg"=>"$turn", "loggedin"=>"true");
		echo json_encode($output);
	}

	/////get Position 
	if(isset($_POST['potisionID']))
	{
		$id = $_POST['potisionID'];
		$col = $_POST['col'];
		$row = $_POST['row'];

		$position = $user->getClickPosition($id,$col,$row);

		$output = array("msg"=>"$position", "loggedin"=>"true");
		echo json_encode($output);
	}

	/////write in a Position 
	if(isset($_POST['WritePotisionID']))
	{
		$id = $_POST['WritePotisionID'];
		$col = $_POST['col'];
		$row = $_POST['row'];
		$color = $_POST['color'];

		$position = $user->writeClickPosition($id,$col,$row,$color);

		$output = array("msg"=>"$color", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Update Turn upID
	if(isset($_POST['upID']))
	{
		$id = $_POST['upID'];

		$turn = $user->updateTurn($id);

		$output = array("msg"=>"$turn", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Update Turn upID
	if(isset($_POST['firstMoveID']))
	{
		$id = $_POST['firstMoveID'];

		$turn = $user->getFirstMove($id);

		$output = array("msg"=>"$turn", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Winner green
	if (isset($_POST['winnerID'])) {
		$myID = $_POST['winnerID'];
		$oppID = $_POST['oppID'];
		$mycolor = $_POST['color'];

		$winner = $user->getWinnerGreen($myID,$oppID,$mycolor);

		if ($mycolor == "green") {
			$ok = "win";
		}
		else
		{
			$ok = "losse";
		}
		$output = array("msg"=>"$winner", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Winner red
	if (isset($_POST['winnerRedID'])) {
		$myID = $_POST['winnerRedID'];
		$oppID = $_POST['oppID'];
		$mycolor = $_POST['color'];

		$winner = $user->getWinnerRed($myID,$oppID,$mycolor);
		if ($mycolor == "red") {
			$ok = "win";
		}
		else
		{
			$ok = "losse";
		}
		$output = array("msg"=>"$winner", "loggedin"=>"true");
		echo json_encode($output);
	}
	//Draw
	if (isset($_POST['myDrawID'])) {
		$myID = $_POST['myDrawID'];
		$oppID = $_POST['oppID'];

		$winner = $user->getDraw($myID,$oppID);
		$ok = "DRAW";
		$output = array("msg"=>"$ok", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Check if game finished
	if (isset($_POST['MsgFinalID'])) {
		$myID = $_POST['MsgFinalID'];

		$finish = $user->getFinish($myID);
		
		$output = array("msg"=>"$finish", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Check if game finished
	if (isset($_POST['myNewGameID'])) {
		$myID = $_POST['myNewGameID'];
		$oppID = $_POST['oppID'];

		$newGame = $user->getNewGame($myID,$oppID);
		
		$output = array("msg"=>"$newGame", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Check if game finished
	if (isset($_POST['Finish_Update'])) {
		$myID = $_POST['Finish_Update'];

		$finish = $user->finishReset($myID);
		
		$output = array("msg"=>"Reset Happens", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Leave opponent 
	if (isset($_POST['leaveID'])) {
		$myID = $_POST['leaveID'];
		$oppID = $_POST['oppID'];

		$winner = $user->getWinOpponentLeft($myID,$oppID);

		$output = array("msg"=>"Your Opponent left. You Win !!!", "loggedin"=>"true");
		echo json_encode($output);
	}

	//Leave opponent 
	if (isset($_POST['opponentID_exist'])) {
		$oppID = $_POST['opponentID_exist'];

		$ret = $user->checkOpponentExist($oppID);

		$output = array("msg"=>"$ret", "loggedin"=>"true");
		echo json_encode($output);
	}
	///////////////////////////////////////////////////////////////////////TOURNOUA
	//update Round
	if (isset($_POST['UpdateRoundID'])) {
		$id = $_POST['UpdateRoundID'];
		$ret = $user->updateRound($id);

		$output = array("msg"=>"Round is $ret", "loggedin"=>"true");
		echo json_encode($output);
	}

	if (isset($_POST['DrawTourID'])) {
		$myID = $_POST['DrawTourID'];
		$oppID = $_POST['UpdateRoundID'];

		$rematch = $user->getNewGame($myID,$oppID);

		$output = array("msg"=>"Rematch!!!", "loggedin"=>"true");
		echo json_encode($output);
	}
?>