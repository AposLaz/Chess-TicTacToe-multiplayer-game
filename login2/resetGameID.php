<?php 
/*
	Me auti ti sunartisi tha kanoume reset to GameId tou xristi wste na deixnoume oti den einai se kanena paixnidi kai na thetoume ta values twn upoloipwn arxeiwn.
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
/////////////////////////////////////////////////////////////////////////////////////SKAKI
    if(mysqli_num_rows($result)>0)
	{
    	while($row = mysqli_fetch_assoc($result)) {
    		$UserGameOpponent = "";
    		$UserGameId = 0;
    		$LastMove = "";
    		$UserGameColor = "";
    		$sql = "UPDATE Game SET UserGameOpponent = '$UserGameOpponent' , UserGameId = '$UserGameId' , LastMove = '$LastMove' , UserGameColor = '$UserGameColor' ,FINISH = '$UserGameId' WHERE UserID = '$user_id' ";
			$result1 = mysqli_query($link, $sql) or die(mysqli_error($link));
    	}
    }
    else
    {
    	$UserGameOpponent = "";
    	$UserGameId = 0;
    	$LastMove = "";
    	$UserGameColor = "";
    	$sql = "INSERT INTO Game (UserGameOpponent,UserGameId,LastMove,UserGameColor,FINISH,UserID)VALUES ('$UserGameOpponent','$UserGameId','$LastMove','$UserGameColor', '$UserGameId' , '$user_id')";
    	$result1 = mysqli_query($link, $sql) or die(mysqli_error($link));
    }
///////////////////////////////////////////////////////////////////////////////TAVLI
    $sql = "SELECT * FROM GameTic WHERE UserID = '$user_id' ";
    $result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");
    
    //Variables
    $OppID = 0;
    $GameID = 0;
    $Color = "";
    $Turn = 0;

    if(mysqli_num_rows($result2)>0)
    {
        while($row2 = mysqli_fetch_assoc($result2))
        {
            $Gameid = $row2['GameID'];
             //elegxoume an eimastan idi se paixnidi opote diagrafoume kai to row tou table MovesTic opou GameID = $Gameid
            $sql = "SELECT * FROM MovesTic WHERE Game_id = '$Gameid' ";
            $result4 = mysqli_query($link, $sql)or die(mysqli_error($link));
            if(mysqli_num_rows($result4) > 0)
            {
                $sql = "DELETE FROM MovesTic WHERE Game_id = '$Gameid' ";
                $result5 = mysqli_query($link, $sql)or die(mysqli_error($link));
            }

            $sql = "UPDATE GameTic SET OppID = '$OppID' , GameID = '$GameID' , Color = '$Color' , Turn = '$Turn' , Finish = '$Turn' WHERE UserID = '$user_id' ";
            $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));
        }
    }
    else
    {
        $sql = "INSERT INTO GameTic (OppID,GameID,Color,Turn,Finish,UserID)VALUES ('$OppID','$GameID','$Color','$Turn','$Turn','$user_id') ";
        $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));
    }


?>