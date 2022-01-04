<?php
	/* Me auti ti synartisi epistrefoume to xrwma tou xristi.
	Kanoume xrisi tis move.php gia na paroume to xrwma tou xristi*/
	session_start();
	include "classes/move.php";
	$lCol="";
	if(isset($_POST['MoveString'])){
		$move = new move();
		$move->setMoveUserId($_SESSION['UserId']);
		$lCol=$move->getColor($_SESSION['UserId']);
	}  
	$output = array("msg"=>"$lCol", "loggedin"=>"true");
	echo json_encode($output);
	/* 
		Return json to gui.js in function loadLMove()
		Function loadMove() loads once and then with a setInvervall
	*/

?>