<?php
/*
	This page will redirect player either in page for find opponent,either in the game
*/

session_start();
include "classes/user.php";

	$user = new user();
	//take the name from User
    $user_id = $_SESSION['user'];

	$user->setUserId($user_id);
	if($user->UserLogin()==true){
		// The function UserLogin is called, userlogin decides if the user is going to 
		// an already started multigame or if user is going to indexMult to choose an opponent
		
		// The session variables are set
		$_SESSION['UserId']=$user->getUserId();
		//$_SESSION['UserName']=$user->getUserName();
		$_SESSION['GameId']=$user->getUserGameId();
		$_SESSION['Opponent']=$user->getUserGameOpponent();
		$_SESSION['Color']=$user->getUserGameColor();  
	}
?>