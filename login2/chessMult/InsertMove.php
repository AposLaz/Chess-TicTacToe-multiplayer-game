<?php
/*
	Me auti ti sunartisi apothikeuoume ti teleutaia kinisi tou paixti kai ti 
	fortwnoume kai stous 2 paixtes
*/
session_start();
include "classes/move.php";
	$lMove="rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
	if(isset($_POST['MoveString'])){
		$move = new move();
		$move->setMoveUserId($_SESSION['UserId']);
		//autin einai i kinisi pou apothikeuoume kathe fora 
		$move->setMoveString($_POST['MoveString']);
		$move->InsertMove($_SESSION['GameId']);
		//auto parakatw leei oti den o xreaizetai kai to vazei se 
		//$lMove=$move->getLastMove($_SESSION['GameId']);
	}
	$output = array("msg"=>"$lMove", "loggedin"=>"true");
	echo json_encode($output);
?>