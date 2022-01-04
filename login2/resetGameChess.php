<?php 
/*
	Me auti ti sunartisi tha kanoume update to GameId tou xristi wste na deixnoume oti einai sto skaki kai tha exei ti timi 1.
*/
	session_start();
	require_once('csrf.php');
	require_once("config.php");

	if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
    $token_cookie = Token::verify_user($_COOKIE['token']);
    $part = explode("|",$_COOKIE['token']);
    if($token_cookie !== $part[0]){
      header("Location: logout.php");
    }
  }
  if(!(isset($_SESSION['loggedin']))){
    header('Location: index.php');
  }

  //take the name from User
    $user_id = $_SESSION['user'];
    $sql = "SELECT * FROM Game WHERE UserID = '$user_id' ";
    $result = mysqli_query($link, $sql) or die("Bad connection.Try later");

    if(mysqli_num_rows($result)>0)
	{
    	while($row = mysqli_fetch_assoc($result)) {
    		$UserGameOpponent = "";
    		$UserGameId = 1;
    		$LastMove = "";
    		$UserGameColor = "";
    		$sql = "UPDATE Game SET UserGameOpponent = '$UserGameOpponent' , UserGameId = '$UserGameId' , LastMove = '$LastMove' , UserGameColor = '$UserGameColor' , FINISH = '$UserGameId' WHERE UserID = '$user_id' ";
			$result1 = mysqli_query($link, $sql) or die("Error in connection");
    	}
    }
    header("Location: chessMult/UserLogin.php");


?>