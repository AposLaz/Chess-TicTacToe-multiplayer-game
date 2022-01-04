<?php
	/* Me auti ti synartisi epistrefoume to xrwma tou xristi.
	Kanoume xrisi tis move.php gia na paroume to xrwma tou xristi*/
	session_start();
	require_once("../config.php");
	
	$id=$_POST["id"];
	$sql = "SELECT * FROM GameTic WHERE OppID >=1 AND UserID = '$id' ";
	$result = mysqli_query($link, $sql) or die("Error in connection");

	if(mysqli_num_rows($result)>0)
	{
		$output = array("msg"=>"success", "loggedin"=>"true");
	}
	else
	{
		$output = array("msg"=>"false", "loggedin"=>"true");
	}
	echo json_encode($output);
	/* 
		Return json to gui.js in function loadLMove()
		Function loadMove() loads once and then with a setInvervall
	*/

?>