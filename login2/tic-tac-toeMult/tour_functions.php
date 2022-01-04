<?php 
session_start();
 include "classes/tournamentTic.php";
 $tournament = new tournament();
//------------------------------------------- Dimiourgia tour
	if(isset($_POST['createID'])){
		//elegxoume prwta na doume an uparxei kapoio tournoua
		$exist_tour = $tournament->ExistTour();
		//dimiourgoume to tournoua
		if($exist_tour == false)
		{
			$create_tour = $tournament->create_tour();
			$output = array("msg"=>"Tournament Created", "loggedin"=>"true");
		}
		else
		{
			$output = array("msg"=>"Wait until finish the existing Tournament", "loggedin"=>"true");
		}
		echo json_encode($output);
	}

//------------------------------------------- Mpainoume sto tournoua
	if(isset($_POST['PartId'])){
		//elegxoume arxika na doume an o xristis einai sto tournoua
		$user_exist = $tournament->ExistUser($_SESSION['user']);
		if($user_exist == true)
		{
			$output = array("msg"=>"YOU PARTICIPATED WAIT FOR OTHER PLAYERS", "loggedin"=>"true");
		}
		else
		{
			//elegxoume an oi xristes einai parapanw apo 8 den mporw na mpw sto tournoua
			$user_num = $tournament->UserNum();
			if ($user_num >= 8) {
				$output = array("msg"=>"The tournament is full.Better luck next time!!!", "loggedin"=>"true");
			}
			else //alliws
			{
				$insert_user = $tournament->InsertUserTour($_SESSION['user']);
				$output = array("msg"=>"YOU ARE IN!!!WAIT FOR PLAYERS", "loggedin"=>"true");
			}
		}
		echo json_encode($output);
	}

	//----------------------------------- TO TOURNOUA XEKINAEI
	if (isset($_POST['BeginTourid'])) {
		//elegxos an einai 8 atoma sto tournoua
		$user_nums = $tournament->UserNum();
		$round = $_POST['round'];

		$id = $_POST['BeginTourid'];
		if($user_nums == 8 && $round == 0) {
			$delay = rand(1,10);
			sleep($delay);
			$user = $tournament->AssignUser($id);
			$output = array("msg"=>"success", "loggedin"=>"true");
		}
		else if($user_nums == 4 && $round == 2){
			$user = $tournament->AssignUser1($id);
			$output = array("msg"=>"success", "loggedin"=>"true");
		}
		else if($user_nums == 2 && $round == 3){
			$user = $tournament->AssignUser1($id);
			$output = array("msg"=>"success", "loggedin"=>"true");
		}
		else{
			$output = array("msg"=>"false", "loggedin"=>"true");
		}

		//$output = array("msg"=>"$round", "loggedin"=>"true");
		echo json_encode($output);
	}

	//---------------------------------- RESULT THE TOURNAMENT
	if (isset($_POST['userID_msg'])) {
		$id = $_POST['userID_msg'];
		$round = $_POST['round'];

		$tour_result = $tournament->TourNamentResult($id,$round);
		
		$output = array("msg"=>"$tour_result", "loggedin"=>"true");
		echo json_encode($output);
	}

	//-------------------------------- DELETE Tournament
	if(isset($_POST['DeleteID'])){
		$tour = $tournament->DeleteTournament();
		$output = array("msg"=>"deleted tour", "loggedin"=>"true");
		echo json_encode($output);
	}

	//-------------------------------- DELETE Tournament BY ADMIN
	if(isset($_POST['DeleteID_Admin'])){
		$tour = $tournament->DeleteTourAdmin();
		$output = array("msg"=>"deleted tour by Admin", "loggedin"=>"true");
		echo json_encode($output);
	}

?>