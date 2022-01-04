<?php
class move {
	private $MoveId,$MoveUserId,$MoveString,$LastMove;
	
	public function getMoveId(){
		return $this->MoveId;
	}
	public function setMoveId($MoveId){
		return $this->MoveId=$MoveId;
	}	
	
	public function getMoveUserId(){
		return $this->MoveUserId;
	}
	public function setMoveUserId($MoveUserId){
		return $this->MoveUserId=$MoveUserId;
	}	
	
	public function getMoveString(){
		return $this->MoveString;
	}
	public function setMoveString($MoveString){
		return $this->MoveString=$MoveString;
	}	
	
	public function getLastMove($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}
		
		$sql = "SELECT * FROM Game ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
		
		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$gameID = $row["UserGameId"];	
				$move = $row["LastMove"];					
				if($gameID == $id) {
					return $move;
	
				}
			}
		}
		$move="rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		return $move;
	}
	
	public function getColor($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}

		$sql = "SELECT * FROM Game ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

		
		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$userID = $row["UserID"];				
				$col = $row["UserGameColor"];					
				if($userID == $id) {
					return $col;
	
				}
			}
		}
		$col="";
		return $col;
	}

	//kathe fora pou ginete mia nea kinisi kanoume update sto name tou gameID me ti
	//teleutaia kinisi
	public function InsertMove($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}

		$MoveUserId=$this->getMoveUserId(); //to id mas
		$MoveString=$this->getMoveString(); //i kinisi mas
		$MoveId =1;	

		$sql = "SELECT * FROM Game ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$sql = "UPDATE Game SET LastMove = '$MoveString' WHERE UserGameId = '$id' ";
				$result1 = mysqli_query($link, $sql) or die("Error in connection");

			}
		}
	}


	//Tournaments----------------------
	public function getColorTour($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}

		$sql = "SELECT * FROM ChessTourRoom ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

		
		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$userID = $row["UserID"];				
				$col = $row["UserColor"];					
				if($userID == $id) {
					return $col;
	
				}
			}
		}
		$col="";
		return $col;
	}


	public function InsertMoveTour($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}

		$MoveUserId=$this->getMoveUserId(); //to id mas
		$MoveString=$this->getMoveString(); //i kinisi mas
		$MoveId =1;	

		$sql = "SELECT * FROM ChessTourRoom ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$sql = "UPDATE ChessTourRoom SET LastMove = '$MoveString' WHERE GameID = '$id' ";
				$result1 = mysqli_query($link, $sql) or die("Error in connection");

			}
		}
	}

	public function getLastMoveTour($id){
		//db connection
		$link = mysqli_connect("db","root","root","project");
		if($link === false){die("ERROR: Could not connect. ");}
		
		$sql = "SELECT * FROM ChessTourRoom ORDER BY UserID ";	
		$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
		
		if (mysqli_num_rows($result) == 0) { // evaluate the count
			return "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		}
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$gameID = $row["GameID"];	
				$move = $row["LastMove"];					
				if($gameID == $id) {
					return $move;
	
				}
			}
		}
		$move="rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
		return $move;
	}


}
?>