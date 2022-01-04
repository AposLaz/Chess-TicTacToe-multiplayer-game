<?php

	class userTourTic{
		private $UserId,$UserGameId,$UserGameColor,$UserGameOpponent;
		
		public function getUserId(){
			return $this->UserId;
		}
		public function setUserId($UserId){
			return $this->UserId=$UserId;
		}
		
		public function getUserName(){
			return $this->UserName;
		}
		public function setUserName($UserName){
			return $this->UserName=$UserName;
		}
		
		public function getUserPassword(){
			return $this->UserPassword;
		}
		public function setUserPassword($UserPassword){
			return $this->UserPassword=$UserPassword;
		}
		public function getUserGameId(){
			return $this->UserGameId;
		}
		public function setUserGameId($UserGameId){
			return $this->UserGameId=$UserGameId;
		}
		
		public function getUserGameOpponent(){
			return $this->UserGameOpponent;
		}
		public function setUserGameOpponent($UserGameOpponent){
			return $this->UserGameOpponent=$UserGameOpponent;
		}
		public function getUserGameColor(){
			return $this->UserGameColor;
		}
		public function setUserGameColor($UserGameColor){
			return $this->UserGameColor=$UserGameColor;
		}
////////////////  Update Round
		public function updateRound($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row = mysqli_fetch_assoc($result);

			$round = $row['Round'] + 1;

			$sql = "UPDATE TourTicRoom SET Round = '$round' WHERE UserID = '$id' ";
			$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");

			return $round;
		}
//////////////// check Opponent Exist
		public function checkOpponentExist($oppID){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$oppID' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$gameID = $row2['GameID'];
			if($gameID > 2)
			{
				$val = 0; //exist
				return $val;
			}
			else
			{
				$val = 1; //not exist
				return $val;
			}
		}
////////////////You left You lost yr opponent Win 
		public function getWinOpponentLeft($myID,$oppID){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//-----------antipalos
			$sql = "SELECT * FROM ScoresTic WHERE User_id = '$oppID' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row = mysqli_fetch_assoc($result);
			$win = $row['Pwin'] + 1;

			$sql = "UPDATE ScoresTic SET Pwin = '$win' WHERE  User_id = '$oppID' ";
			$result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");

			$Finish = 1; //kerdizei
			$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
			$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				
			//----------xanw giati efuga
			$sql = "SELECT * FROM ScoresTic WHERE User_id = '$myID' ";
			$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row1 = mysqli_fetch_assoc($result1);
			$losse = $row1['Plosse'] + 1;

			$sql = "UPDATE ScoresTic SET Plosse = '$losse' WHERE  User_id = '$myID' ";
			$result4 = mysqli_query($link, $sql) or die("Bad connection.Try later");

			return true;
		}
///////////////finish reset
		public function finishReset($myID){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$val = 0;
			//update prwta emas
    		$sql = "UPDATE TourTicRoom SET Finish = '$val' WHERE UserID = '$myID' ";
            $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));

            return true;
		}
//////////////begin NEW game
		public function getNewGame($myID,$oppID){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//arxika diagrafoume to paixnidi sto opoio paizoume
			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$myID' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row = mysqli_fetch_assoc($result);
			$gameID = $row['GameID'];

			$delay = rand(1,10);
			sleep($delay);
			$opp = $row['Finish'];
				if($opp == 0 || $opp == 4)
				{
					$var = "deny";
					return $var;
				}
			//epeita kanoume uddate ti vasi mas kai tou antiplaou mas
			//Variables
	        //generate random number for user
			$posit = rand(1,2);
			$val = 4;
			if($posit == 1){
				$color="green";
				$color_opp = "red";
				$myturn = 1;
				$oppturn = 0;
			}
			else{
				$color="red";
				$color_opp = "green";
				$myturn = 0;
				$oppturn = 1;
			}

	       	//update prwta emas
    		$sql = "UPDATE TourTicRoom SET Color = '$color' , Turn = '$myturn' , Finish = '$val' WHERE UserID = '$myID' ";
            $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));
            
            //epeita kanoume update ton antiplao mas
            $sql = "UPDATE TourTicRoom SET Color = '$color_opp' , Turn = '$oppturn' , Finish = '$val' WHERE UserID = '$oppID' ";
            $result4 = mysqli_query($link, $sql) or die(mysqli_error($link));

            ////Insert moveTable
			$num = 0;
			$sql3 = "UPDATE MovesTic SET p00 = '$num',p01 = '$num',p02 = '$num',p10 = '$num',p11 = '$num',p12 = '$num',p20 = '$num',p21 = '$num',p22 = '$num' WHERE Game_id = '$gameID' ";
			$result5 = mysqli_query($link, $sql3) or die(mysqli_error($link));

            return true;
		}

//////////////get finish
		public function getFinish($myID){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			
			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$myID' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$finish = $row2['Finish'];

			return $finish;
		}
//////////////draw function
		public function getDraw($myID,$oppID)
		{
				//db connection
				$link = mysqli_connect("db","root","root","project");
				if($link === false){die("ERROR: Could not connect. ");}
			//-----------egw
				$Finish = 3; //isopalia
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$myID' ";
				$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");

			//----------antipalos
				$Finish = 3; //isopalia
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
				$result5 = mysqli_query($link, $sql)or die("Bad connection.Try later");

				return true;
		}
//////////////function winnerGreen
		public function getWinnerGreen($myID,$oppID,$mycolor){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			if($mycolor == "green"){//kerdizw
				//-----------egw
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$myID' ";
				$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row = mysqli_fetch_assoc($result);
				$win = $row['Twin'] + 1;

				$sql = "UPDATE ScoresTic SET Twin = '$win' WHERE  User_id = '$myID' ";
				$result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 1; //kerdizw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$myID' ";
				$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				
				//----------antipalos
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$oppID' ";
				$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row1 = mysqli_fetch_assoc($result1);
				$losse = $row1['Tlosse'] + 1;

				$sql = "UPDATE ScoresTic SET Tlosse = '$losse' WHERE  User_id = '$oppID' ";
				$result4 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 2; //xanw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
				$result5 = mysqli_query($link, $sql) or die("Bad connection.Try later");
			}elseif ($mycolor == "red") { //xanw
				//-----------egw
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$myID' ";
				$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row = mysqli_fetch_assoc($result);
				$Plosse = $row['Tlosse'] + 1; //xanw

				$sql = "UPDATE ScoresTic SET Tlosse = '$Plosse' WHERE  User_id = '$myID' ";
				$result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 2; //xanw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$myID' ";
				$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				
				//----------antipalos
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$oppID' ";
				$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['Twin'] + 1;

				$sql = "UPDATE ScoresTic SET Twin = '$win' WHERE  User_id = '$oppID' ";
				$result4 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 1; //kerdizei
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
				$result5 = mysqli_query($link, $sql) or die("Bad connection.Try later");
			}
			return true;
		}
//////////////function winnerRed
		public function getWinnerRed($myID,$oppID,$mycolor){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			if($mycolor == "red"){//kerdizw
				//-----------egw
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$myID' ";
				$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row = mysqli_fetch_assoc($result);
				$win = $row['Twin'] + 1;

				$sql = "UPDATE ScoresTic SET Twin = '$win' WHERE  User_id = '$myID' ";
				$result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 1; //kerdizw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$myID' ";
				$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				
				//----------antipalos
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$oppID' ";
				$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row1 = mysqli_fetch_assoc($result1);
				$losse = $row1['Tlosse'] + 1;

				$sql = "UPDATE ScoresTic SET Tlosse = '$losse' WHERE  User_id = '$oppID' ";
				$result4 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 2; //xanw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
				$result5 = mysqli_query($link, $sql) or die("Bad connection.Try later");

			}elseif ($mycolor == "green") { //xanw
				//-----------egw
				$sql = "SELECT * FROM ScoresTic WHERE User_id='$myID' ";
				$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row = mysqli_fetch_assoc($result);
				$losse = $row['Tlosse'] + 1; //xanw

				$sql = "UPDATE ScoresTic SET Tlosse = '$losse' WHERE  User_id = '$myID' ";
				$result2 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 2; //xanw
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$myID' ";
				$result3 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				
				//----------antipalos kerdizei
				$sql = "SELECT * FROM ScoresTic WHERE User_id = '$oppID' ";
				$result1 = mysqli_query($link, $sql) or die("Bad connection.Try later");
				$row = mysqli_fetch_assoc($result1);
				$win = $row1['Twin'] + 1;

				$sql = "UPDATE ScoresTic SET Twin = '$win' WHERE  User_id = '$oppID' ";
				$result4 = mysqli_query($link, $sql) or die("Bad connection.Try later");

				$Finish = 1; //kerdizei
				$sql = "UPDATE TourTicRoom SET Finish = '$Finish' WHERE UserID = '$oppID' ";
				$result5 = mysqli_query($link, $sql) or die("Bad connection.Try later");
			}
			return true;
		}

/////////////Find for a first Move
		public function getFirstMove($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$gameID = $row2['GameID'];

			$sql1 = "SELECT * FROM MovesTic WHERE Game_id = '$gameID' ";
			$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
			$row1 = mysqli_fetch_assoc($result1);

			$p00 = $row1['p00'];
			$p01 = $row1['p01'];
			$p02 = $row1['p02'];
			$p10 = $row1['p10'];
			$p11 = $row1['p11'];
			$p12 = $row1['p12'];
			$p20 = $row1['p20'];
			$p21 = $row1['p21'];
			$p22 = $row1['p22'];

			if($p00 == 0 && $p01 == 0 && $p02 == 0 && $p10 == 0 && $p11 == 0 && $p12 == 0 && $p20 == 0 && $p21 == 0 && $p22 == 0){
				$ret = "failed";
			}
			elseif ($p00 != 0 || $p01 != 0 || $p02 != 0 || $p10 != 0 || $p11 != 0 || $p12 != 0 || $p20 != 0 || $p21 != 0 || $p22 != 0){
				$ret = "success";
			}
			return $ret;

		}
/////////////Update My turn
		public function updateTurn($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$turn = $row2['Turn'];
			$turn = $turn+2;

			$sql = "UPDATE TourTicRoom SET Turn = '$turn' WHERE UserID = '$id' ";
           	$result3 = mysqli_query($link, $sql) or die(mysqli_error($link));

			return $turn;
		}


////////////grafoume sti thesi O = 1 , X = 2
		public function writeClickPosition($id,$col,$row,$color){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			//get gameID
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$gameID = $row2['GameID'];

			$colored = $color;
			//grafoume sti vasi analoga me ti thesi
			if ($colored == "green") {
				if($row == 0 && $col == 0){
					$p00 = 1;
					$sql1 = "UPDATE MovesTic SET p00 = '$p00' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 0 && $col == 1) {
					$p01 = 1;
					$sql1 = "UPDATE MovesTic SET p01 = '$p01' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 0 && $col == 2) {
					$p02 = 1;
					$sql1 = "UPDATE MovesTic SET p02 = '$p02' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 0) {
					$p10 = 1;
					$sql1 = "UPDATE MovesTic SET p10 = '$p10' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 1) {
					$p11 = 1;
					$sql1 = "UPDATE MovesTic SET p11 = '$p11' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 2) {
					$p12 = 1;
					$sql1 = "UPDATE MovesTic SET p12 = '$p12' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 2 && $col == 0) {
					$p20 = 1;
					$sql1 = "UPDATE MovesTic SET p20 = '$p20' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 2 && $col == 1) {
					$p21 = 1;
					$sql1 = "UPDATE MovesTic SET p21 = '$p21' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 2 && $col == 2) {
					$p22 = 1;
					$sql1 = "UPDATE MovesTic SET p22 = '$p22' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				else
				{
					return false;
				}	
			}

			if ($colored == "red") {
				if($row == 0 && $col == 0){
					$p00 = 2;
					$sql1 = "UPDATE MovesTic SET p00 = '$p00' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 0 && $col == 1) {
					$p01 = 2;
					$sql1 = "UPDATE MovesTic SET p01 = '$p01' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 0 && $col == 2) {
					$p02 = 2;
					$sql1 = "UPDATE MovesTic SET p02 = '$p02' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 0) {
					$p10 = 2;
					$sql1 = "UPDATE MovesTic SET p10 = '$p10' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 1) {
					$p11 = 2;
					$sql1 = "UPDATE MovesTic SET p11 = '$p11' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 1 && $col == 2) {
					$p12 = 2;
					$sql1 = "UPDATE MovesTic SET p12 = '$p12' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				elseif ($row == 2 && $col == 0) {
					$p20 = 2;
					$sql1 = "UPDATE MovesTic SET p20 = '$p20' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 2 && $col == 1) {
					$p21 = 2;
					$sql1 = "UPDATE MovesTic SET p21 = '$p21' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}elseif ($row == 2 && $col == 2) {
					$p22 = 2;
					$sql1 = "UPDATE MovesTic SET p22 = '$p22' WHERE Game_id = '$gameID' ";
					$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
				}
				else
				{
					return false;
				}
			}
			$ret = $colored;
			return $colored;
			
		}

///////////pairnoume ti thesi pou epilegei o xristis me click
		public function getClickPosition($id,$col,$row){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row2 = mysqli_fetch_assoc($result);
			//psaxnoume na vroume to paixnidi
			$gameID = $row2['GameID'];

			$sql1 = "SELECT * FROM MovesTic WHERE Game_id = '$gameID' ";
			$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
			$row1 = mysqli_fetch_assoc($result1);

			$p00 = $row1['p00'];
			$p01 = $row1['p01'];
			$p02 = $row1['p02'];
			$p10 = $row1['p10'];
			$p11 = $row1['p11'];
			$p12 = $row1['p12'];
			$p20 = $row1['p20'];
			$p21 = $row1['p21'];
			$p22 = $row1['p22'];

			if($row == 0 && $col == 0){
				return $p00;
			}elseif ($row == 0 && $col == 1) {
				return $p01;
			}
			elseif ($row == 0 && $col == 2) {
				return $p02;
			}
			elseif ($row == 1 && $col == 0) {
				return $p10;
			}
			elseif ($row == 1 && $col == 1) {
				return $p11;
			}
			elseif ($row == 1 && $col == 2) {
				return $p12;
			}
			elseif ($row == 2 && $col == 0) {
				return $p20;
			}elseif ($row == 2 && $col == 1) {
				return $p21;
			}elseif ($row == 2 && $col == 2) {
				return $p22;
			}
			else
			{
				return false;
			}
		}

//////////pairnoume to xrwma tou xristi
		public function getUserColor($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row = mysqli_fetch_assoc($result);

			$color = $row['Color'];
			return $color;
		}
///////pairnoume to guro tou xristi
		public function getTurn($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");
			$row = mysqli_fetch_assoc($result);

			$turn = $row['Turn'];
			if($turn == 0)
			{
				$turn = 0;
			}

			return $turn;
		}
		
		public function getUserRole($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM Users WHERE ID = '$id' ";
			$result = mysqli_query($link,$sql) or die("ERROR-ROLE: Could not connect. ");
			$row = mysqli_fetch_assoc($result);
			$role = $row['ROLE'];
			return $role;
		}

		public function UserLogin(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$userID = $this->getUserId();

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$userID' ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if(mysqli_num_rows($result)==0){ //tsekaroume na doume an eimaste sundedemenoi
				header("Location: ../logout.php");
			} else {
				while($row = mysqli_fetch_assoc($result)){

					$this->setUserId($row['UserID']);
					$this->setUserGameId($row['GameID']);
					$this->setUserGameOpponent($row['OppID']);
					$this->setUserGameColor($row['Color']);

					//an den exoume kapoio multiplayer game i oxi
					if($row["GameID"] == 1)
					{ 
						header("Location: tic-tac-toe.php");
					}
					else{
						header("Location: Tic/index.php");
					}  
					return true;
				}
			} 
			//return $UserRequest->rowCount();
		}
		
		public function DisplayAvailablePlayers(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			//include "classes/tournament.php";

			$sql = "SELECT * FROM TourTicRoom WHERE GameID <> 0 ORDER BY GameID ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if (mysqli_num_rows($result) > 1) {
				while($row = mysqli_fetch_assoc($result)){
					//to id tou antipalou mas
					$id = $row["UserID"];
					$token = $row["GameID"];
					if($row["UserID"] != $_SESSION['UserId']){ // if opponent name,den efmanizei to onoma mas
						
						//elegxoume an o antiplaos paizei se kapoio tournoua

						//$tourn = new tournament();
						//$user_exist = $tourn->ExistUser($id);
						//if ($row["UserGameId"] != 1 || $user_exist == true){
						
						if ($row["GameID"] != 1){
							$available = "Not available table";
						}else{
							$available = "Available table";
						}

						//dinoume ena tuxaio id gia to paixnidi
						if ($token==1){
								$token=rand(1000, 10000000);
						}
						//apeikonizoume ta onomata twn antipalwn
						if ($row["GameID"] != 1) {
							if($row["GameID"] > 0){
								
								$sql1 = "SELECT * FROM Users WHERE ID = '$id' ";	
								$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
								$row1 = mysqli_fetch_assoc($result1);
								?>

								<li class="media" style="border:2px solid black;border-radius: 10px;background-color:red;">
							        <div class="row">
							          <h1 style="font-size: 20px; text-align: center;color:black"><?php echo $available;?></h1>
							          <hr style="border: 1px solid #331a00;">
							          <div class="col-lg-3">
							              <p id="avatarName" style="color:black;">Play with <span style="color:#331a00;font-size: 18px;"><strong><?php echo $row1["USERNAME"];?></strong><span></p>
							              <img class="mr-3" style="border:1px solid black" id="avatar" src="img/avatar.jpg" alt="Generic placeholder image">
							              <input type="button" data-toggle="modal" data-target="#exampleModal" class="mt-0 mb-1 displayDATA" style="color:white;cursor:pointer;padding: 0;border: none;background: none;" data-id="<?php echo $id;?>" value="See_Tournament Score">
							          </div>
							          <div class="col-lg-6">
							              <br>
							              <br>
							              <p class="mt-0 mb-1" style="color:black"><strong>VS</strong></p>
							          </div>
							          <div class="col-lg-3">
							              <p style="color: black;" id="avatarName">Cant stay here</p>
							              <img class="mr-3" style="border:1px solid black;" id="avatar" src="img/avatar.jpg" alt="Generic placeholder image">
							         
							          </div>
							        </div>
							      </li>
							     <!--
								<span style="color:red" class="UserNameS"><?php echo $row1["USERNAME"];?>					
								</span>
								</span> is 
								<span class="ChatMessageS" > <?php echo $available;?>
								</span> </br>-->
								<?php
							}
						} else {
							if($row["GameID"] > 0){
								$sql1 = "SELECT * FROM Users WHERE ID = '$id' ";	
								$result1 = mysqli_query($link, $sql1) or die("Bad connection.Try later");
								$row1 = mysqli_fetch_assoc($result1);
								?>

								<li class="media" style="border:2px solid black;border-radius: 10px;background-color:green;">
							        <div class="row">
							          <h1 style="font-size: 20px; text-align: center;color:black"><?php echo $available;?></h1>
							          <hr style="border: 1px solid #331a00;">
							          <div class="col-lg-3">
							              <p id="avatarName" style="color:black;">Play with <span style="color:#331a00;font-size: 18px;"><strong><?php echo $row1["USERNAME"];?></strong><span></p>
							              <img class="mr-3" style="border:1px solid black" id="avatar" src="img/avatar.jpg" alt="Generic placeholder image">
							              <input type="button" data-toggle="modal" data-target="#exampleModal" class="mt-0 mb-1 displayDATA" style="color:white;cursor:pointer;padding: 0;border: none;background: none;" data-id="<?php echo $id;?>" value="See_Tournament Score">
							          </div>
							          <div class="col-lg-6">
							              <br>
							              <br>
							              <p class="mt-0 mb-1" style="color:black"><strong>VS</strong></p>
							          </div>
							          <div class="col-lg-3">
							              <p style="color: black;cursor: pointer" id="avatarName" onclick="parent.location='redirect.php?id=<?php echo $token;?>&name=<?php echo $id;?>';">Stay here</p>
							              <img style="cursor: pointer;border:1px solid black;" class="mr-3" id="avatar" onclick="parent.location='redirect.php?id=<?php echo $token;?>&name=<?php echo $id;?>';" src="img/avatar.jpg" alt="Generic placeholder image">
							         
							          </div>
							        </div>
							      </li>

						<?php
						}
					  }
						
					}
				}
			}
			else{
				//check if user isn't in the chess game
						
						$available = "No available Players";
						?>
							<h1 style="font-size: 40px;color: white" class="UserNameS"><?php echo $available;?>
							</h1>
						<?php
	
			}
		}

		public function DeleteGame($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			
			$token=1;

			$sql = "SELECT * FROM TourTicRoom ORDER BY UserID ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)){
					$gameID = $row["GameID"];

					if($gameID == $id) {


						//elegxoume an eimastan idi se paixnidi opote diagrafoume kai to row tou table MovesTic opou GameID = $Gameid
			            $sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameID' ";
			            $result4 = mysqli_query($link, $sql)or die(mysqli_error($link));
			            if(mysqli_num_rows($result4) > 0)
			            {
			                $sql = "DELETE FROM MovesTic WHERE Game_id = '$gameID' ";
			                $result5 = mysqli_query($link, $sql)or die(mysqli_error($link));
			            }


						//Variables
					    $OppID = 0;
					    $GameID = 1;
					    $Color = "";
					    $Turn = 0;

						$UserId=$_SESSION['UserId'];

						$sql = "UPDATE TourTicRoom SET OppID = '$OppID' , GameID = '$GameID' , Color = '$Color' , Turn = '$Turn' , Finish = '$Turn' WHERE UserID = '$UserId' ";
           				 $result3 = mysqli_query($link, $sql) or die(mysqli_error($link));
						
						
					}
				}
			}
		}

	}

?>