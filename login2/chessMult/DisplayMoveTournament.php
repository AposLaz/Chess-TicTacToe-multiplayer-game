<?php
	/*
		Xrisimoipeitai apo sunartisi tis js LoadMove() gia na apeikonizoume kathe 
		fora ti teleutaia kinisi kathe paixti	 
	*/
	session_start();
	include "classes/move.php";
	$lMove="";

	if(isset($_POST['MoveString'])){
		$move = new move();
		$move->setMoveUserId($_SESSION['UserId']);
		$move->setMoveString($_POST['MoveString']);
		$lMove=$move->getLastMoveTour($_SESSION['GameId']);
	}
	$output = array("msg"=>"$lMove", "loggedin"=>"true");
	echo json_encode($output);
	/* 
		Return json to gui.js in function loadMove()
		Function loadMove() loads once and then with a setInvervall
	*/
?>