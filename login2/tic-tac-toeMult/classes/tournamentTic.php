<?php 
	class tournament{
		private $tournament_id;

		//dimiourgia tournoua
		public function create_tour(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$var1 = 0;
			$sql = "INSERT INTO TourTic (User_id)VALUES ('$var1')";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			return true;
		}

		//an to tournoua uparxei
		public function ExistTour(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTic";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			if(mysqli_num_rows($result)>0)
			{
				return true;
			}
			return false;
		}
		//an o xristis uparxei
		public function ExistUser($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTic WHERE User_id = '$id' ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			if(mysqli_num_rows($result)>0)
			{
				return true;
			}
			return false;

		}
		//prosthiki xristi se tournoua
		public function InsertUserTour($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTic ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			if(mysqli_num_rows($result) == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$user = $row['User_id'];
				if($user == 0){
					$var = 1;
					$sql = "UPDATE TourTic SET User_id = '$id' ";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
				}
				else
				{
					$var = 1;
					$sql = "INSERT INTO TourTic (User_id)VALUES ('$id')";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
				}
			}
			else
			{
				$var = 1;
				$sql = "INSERT INTO TourTic (User_id)VALUES ('$id')";
				$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
			}
			$var = 0;
			$vir = "";
			//dimiourgise to dwmatio
			$sql1 = "INSERT INTO TourTicRoom (OppID,GameID,Color,Turn,Finish,Round,UserID)VALUES ('$var','$var','$vir','$var','$var','$var','$id')";
			$result2 = mysqli_query($link,$sql1)or die(mysqli_error($link));

			return true;
		}

		//vres posoi xristes einai sto tournoua
		public function UserNum(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTic ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$var = mysqli_num_rows($result);

			if(mysqli_num_rows($result) > 0){
				return $var;
			}	

			return false;
		}


		//pairnoume to guro kathe xristi
		public function getRound($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);
			$round = $row['Round'];

			return $round;
		}

		public function getGameID($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);
			$gameID = $row['GameID'];

			return $gameID;
		}
		//Sti sunexeia tou turnoua anathetoume kai se allo xristi 
		public function AssignUser1($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//arxika vlepoume an exoume kapoion antipalo
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row1 = mysqli_fetch_assoc($result1);
			//exoume antipalo
			$opp = $row1['OppID'];
				if($opp != 0)
				{
					$var = "deny";
					return $var;
				}

			//pairnoumeta stoixeia tou antipalou mas
			$gameid = 0;
			$sql = "SELECT * FROM TourTicRoom WHERE UserID <> '$id' AND GameID = '$gameid' LIMIT 1";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);

			$opp_id = $row['UserID'];
			//generate random number for user
				$posit = rand(1,2);

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

			$gameID = rand(100, 10000000);

			//kanoume update ti vasi mas me ta nea stoixeia
			// Update User
			// Update User
				$sql2 = "UPDATE TourTicRoom SET OppID = '$opp_id' , GameID = '$gameID' , Color = '$color', Turn = '$myturn' WHERE UserID = '$id' ";
				$result2 = mysqli_query($link, $sql2) or die("Error in connection");
			
			//kanoume update t vasi tou antipalou
			// Update Opponent

			$sql1 = "UPDATE TourTicRoom SET OppID = '$id' , GameID = '$gameID' , Color = '$color_opp' , Turn = '$oppturn' WHERE UserID = '$opp_id' ";
				$result4 = mysqli_query($link, $sql1) or die("Error in connection");

			////Insert moveTable
			$num = 0;
			$sql3 = "INSERT INTO MovesTic (p00,p01,p02,p10,p11,p12,p20,p21,p22,Game_id)VALUES ('$num','$num','$num','$num','$num','$num','$num','$num','$num','$gameID') ";
			$result5 = mysqli_query($link, $sql3) or die(mysqli_error($link));


			$var = "success";
			return $var;
		}
		//anathetoume sto xristi antipalo me mono elegxo an exei antiplao
		public function AssignUser($id)
		{
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//arxika vlepoume an exoume kapoion antipalo
			$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
			$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row1 = mysqli_fetch_assoc($result1);
			//exoume antipalo
			$opp = $row1['OppID'];
				if($opp != 0)
				{
					$var = "deny";
					return $var;
				}

			//pairnoumeta stoixeia tou antipalou mas
			$gameid = 0;
			$sql = "SELECT * FROM TourTicRoom WHERE UserID <> '$id' AND GameID = '$gameid' LIMIT 1";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);

			$opp_id = $row['UserID'];
			//generate random number for user
				$posit = rand(1,2);

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

			$gameID = rand(100, 10000000);

			$round = $row['Round'] + 1;
			//kanoume update ti vasi mas me ta nea stoixeia
			// Update User
			// Update User
				$sql2 = "UPDATE TourTicRoom SET OppID = '$opp_id' , GameID = '$gameID' , Color = '$color', Turn = '$myturn' , Round = '$round' WHERE UserID = '$id' ";
				$result2 = mysqli_query($link, $sql2) or die("Error in connection");
			
			//kanoume update t vasi tou antipalou
			// Update Opponent

			$sql1 = "UPDATE TourTicRoom SET OppID = '$id' , GameID = '$gameID' , Color = '$color_opp' , Turn = '$oppturn' , Round = '$round' WHERE UserID = '$opp_id' ";
				$result4 = mysqli_query($link, $sql1) or die("Error in connection");

			////Insert moveTable
			$num = 0;
			$sql3 = "INSERT INTO MovesTic (p00,p01,p02,p10,p11,p12,p20,p21,p22,Game_id)VALUES ('$num','$num','$num','$num','$num','$num','$num','$num','$num','$gameID') ";
			$result5 = mysqli_query($link, $sql3) or die(mysqli_error($link));


			$var = "success";
			return $var;
		}
	
		//to apotelesma apo to tournoua kai to reset gia ti sunexeia
		public function TourNamentResult($id,$round){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
				
			//arxika pairnoume ton arithmo twn paixtwn pou uparxoun sto tournoua
			$sql = "SELECT * FROM TourTicRoom ";
			$result8 = mysqli_query($link,$sql)or die(mysqli_error($link));
			$numPlayer = mysqli_num_rows($result8); //aritmos paixtwn
			
			/////////////////////////////////////////////////////////////////////1os Guros
			if($numPlayer > 4) //eimaste akoma sto 1o guro
			{
				$tmp = 0;
				while($row = mysqli_fetch_assoc($result8)){
					$roun = $row['Round'];
					if($roun == 2)
					{
						$tmp = $tmp + 1;
					}
				}

				if($tmp > 0 && $round == 1)//exases sto 1o guro
				{
					$sql = "SELECT * FROM ScoresTic WHERE User_id = '$id' ";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row1 = mysqli_fetch_assoc($result1);
					$num = $row1['Tour_nums'] + 1;

					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}

					$sql = "UPDATE ScoresTic SET Tour_nums = '$num'  WHERE User_id = '$id' ";
					$result2 = mysqli_query($link, $sql)or die(mysqli_error($link));

					$sql = "DELETE FROM TourTic WHERE User_id = '$id' ";
					$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$sql = "DELETE FROM TourTicRoom WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$res = "You lost in Round 1!!! Better luck next time.";
					return $res;
				}

				if ($round == 2) { //kerdises to 1o guro
					$sql = "SELECT * FROM ScoresTic WHERE User_id = '$id' ";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row1 = mysqli_fetch_assoc($result1);
					$num = $row1['Tour_nums'] + 1;

					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}

					$sql = "UPDATE ScoresTic SET Tour_nums = '$num'  WHERE User_id = '$id' ";
					$result2 = mysqli_query($link, $sql)or die(mysqli_error($link));

					$number = 0;
					$remove = "";

					$sql1 = "UPDATE TourTicRoom SET OppID = '$number' , GameID = '$number' , Color = '$remove' , Turn = '$number' , Finish = '$number' WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql1) or die("Error in connection");

					$res = "You Win Round 1!!! Wait for the next Round.";
					return $res;
				}
		/////////////////////////////////////////////////////////////////////2os Guros
			}elseif ($numPlayer > 2 && $numPlayer < 5) {
				$tmp = 0;
				while($row = mysqli_fetch_assoc($result8)){
					$roun = $row['Round'];
					if($roun == 3)
					{
						$tmp = $tmp + 1;
					}
				}

				if($tmp > 0 && $round == 2)//exases sto 2o guro
				{

					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}


					$sql = "DELETE FROM TourTic WHERE User_id = '$id' ";
					$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$sql = "DELETE FROM TourTicRoom WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$res = "You lost in Round 2!!! Better luck next time.";
					return $res;
				}

				if ($round == 3) { //kerdises to 2o guro

					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}

					$number = 0;
					$remove = "";
					$sql1 = "UPDATE TourTicRoom SET OppID = '$number' , GameID = '$number' , Color = '$remove' , Turn = '$number' , Finish = '$number' WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql1) or die("Error in connection");

					$res = "You Win Round 2!!! Wait for the Final Round.";
					return $res;
				}

			}/////////////////////////////////////////////////////////////////////3os Guros
			elseif ($numPlayer < 3){

				if($round == 3)//exases sto teliko
				{
					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}

					$sql = "DELETE FROM TourTic WHERE User_id = '$id' ";
					$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$sql = "DELETE FROM TourTicRoom WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$res = "You lost in Final!!! Better luck next time.";
					return $res;
				}
				//nikises sto teliko
				if ($round == 4) { //kerdises to 2o guro
					$sql = "SELECT * FROM ScoresTic WHERE User_id = '$id' ";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row1 = mysqli_fetch_assoc($result1);
					$win = $row1['Tour_wins'] + 1;

					/////////////////////////////////////////////////////////////diagrafi movesGame
					$sql = "SELECT * FROM TourTicRoom WHERE UserID = '$id' ";
					$result10 = mysqli_query($link,$sql)or die(mysqli_error($link));
					$row3 = mysqli_fetch_assoc($result10);
					$gameid = $row3['GameID'];

					$sql = "SELECT * FROM MovesTic WHERE Game_id = '$gameid' ";
					$result11 = mysqli_query($link,$sql)or die(mysqli_error($link));
					if(mysqli_num_rows($result11)>0){
						$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameid'";
						$result12 = mysqli_query($link,$sql)or die(mysqli_error($link));
					}

					$sql = "UPDATE ScoresTic SET Tour_wins = '$win'  WHERE User_id = '$id' ";
					$result2 = mysqli_query($link, $sql)or die(mysqli_error($link));

					$sql = "DELETE FROM TourTic WHERE User_id = '$id' ";
					$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$sql = "DELETE FROM TourTicRoom WHERE UserID = '$id' ";
					$result4 = mysqli_query($link, $sql)or die("Smt ges wrong");

					$res = "You Win the Tournament!!! Congratulations.";
					return $res;
				}
			}			
		}

		public function DeleteTournament()
		{
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM TourTicRoom ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$tmp = 0;
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$round = $row['Round'];
					if($round > 1){
						$tmp = $tmp + 1;
					}
				}
			}

			if($tmp == 4){
				$sql = "DELETE FROM TourTic";
				$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");
			}

			return true;

		}

		public function DeleteTourAdmin(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			
			$sql = "SELECT * FROM TourTicRoom";
			$result5 = mysqli_query($link, $sql)or die("Smt ges wrong");
			
			if(mysqli_num_rows($result5) > 0)
				while($row = mysqli_fetch_assoc($result5)){
					$gameID = $row['GameID'];
					//diagrafoume to id apo pantou
					$sql = "DELETE FROM MovesTic WHERE Game_id = '$gameID' ";
					$result4 = mysqli_query($link, $sql)or die("Smt ges wrong");
					$gameID = 0;
				}

			$sql = "DELETE FROM TourTic";
			$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");

			$sql = "DELETE FROM TourTicRoom";
			$result6 = mysqli_query($link, $sql)or die("Smt ges wrong");

			return true;
		}
	


	}
?>