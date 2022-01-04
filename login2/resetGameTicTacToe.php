<?php 
/*
	Me auti ti sunartisi tha kanoume update to GameId tou xristi wste na deixnoume oti einai sto tavli kai tha exei ti timi 1.
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
    $sql = "SELECT * FROM GameTic WHERE UserID = '$user_id' ";
    $result = mysqli_query($link, $sql) or die("Bad connection.Try later");

    if(mysqli_num_rows($result)>0)
	 {
    	while($row = mysqli_fetch_assoc($result)) {
    		//Variables
        $OppID = 0;
        $GameID = 1;
        $Color = "";
        $Turn = 0;
       
    		 $sql = "UPDATE GameTic SET OppID = '$OppID' , GameID = '$GameID' , Color = '$Color' , Turn = '$Turn' WHERE UserID = '$user_id' ";
            $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));
    	}
    }
    header("Location: tic-tac-toeMult/UserLogin.php");


?>