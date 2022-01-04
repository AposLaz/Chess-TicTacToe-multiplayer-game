<?php 
	class tournament{
		private $tournament_id;

		//dimiourgia tournoua
		public function create_tour(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$var1 = 0;
			$sql = "INSERT INTO ChessTour (User_id)VALUES ('$var1')";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			return true;
		}

		//an to tournoua uparxei
		public function ExistTour(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM ChessTour";
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

			$sql = "SELECT * FROM ChessTour WHERE User_id = '$id' ";
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

			$sql = "SELECT * FROM ChessTour ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			if(mysqli_num_rows($result) == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$user = $row['User_id'];
				if($user == 0){
					$var = 1;
					$sql = "UPDATE ChessTour SET User_id = '$id' ";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
				}
				else
				{
					$var = 1;
					$sql = "INSERT INTO ChessTour (User_id)VALUES ('$id')";
					$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
				}
			}
			else
			{
				$var = 1;
				$sql = "INSERT INTO ChessTour (User_id)VALUES ('$id')";
				$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
			}
			$var = 0;
			$vir = "";
			//dimiourgise to dwmatio
			$sql1 = "INSERT INTO ChessTourRoom (UserOpp,GameID,UserColor,LastMove,Finish,Round,UserID)VALUES ('$var','$var','$vir','$vir','$var','$var','$id')";
			$result2 = mysqli_query($link,$sql1)or die(mysqli_error($link));

			return true;
		}

		//vres posoi xristes einai sto tournoua
		public function UserNum(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM ChessTour ";
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

			$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);
			$round = $row['Round'];

			return $round;
		}

		public function getGameID($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$id' ";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);
			$gameID = $row['GameID'];

			return $gameID;
		}

		//anathetoume sto xristi antipalo me mono elegxo an exei antiplao
		public function AssignUser($id)
		{
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			//arxika vlepoume an exoume kapoion antipalo
			$sql = "SELECT * FROM ChessTourRoom WHERE UserID = '$id' ";
			$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row1 = mysqli_fetch_assoc($result1);
			//exoume antipalo
			$opp = $row1['UserOpp'];
				if($opp != 0)
				{
					$var = "deny";
					return $var;
				}

			//pairnoumeta stoixeia tou antipalou mas
			$gameid = 0;
			$sql = "SELECT * FROM ChessTourRoom WHERE UserID <> '$id' AND GameID = '$gameid' LIMIT 1";
			$result = mysqli_query($link,$sql)or die(mysqli_error($link));
			$row = mysqli_fetch_assoc($result);

			$opp_id = $row['UserID'];

			$color = "white";
			$gameID = rand(100, 10000000);

			$lmove = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";
			$round = $row['Round'] + 1;
			//kanoume update ti vasi mas me ta nea stoixeia
			// Update User
			$sql2 = "UPDATE ChessTourRoom SET UserOpp = '$opp_id' , GameID = '$gameID' , UserColor = '$color' , LastMove = '$lmove' , Round = '$round'  WHERE UserID = '$id' ";
			$result2 = mysqli_query($link, $sql2) or die(mysqli_error($link));
			
			//kanoume update t vasi tou antipalou
			// Update Opponent
			$color = "black";

			$sql3 = "UPDATE ChessTourRoom SET UserOpp = '$id' , GameID = '$gameID' , UserColor = '$color' , LastMove = '$lmove' , Round = '$round'  WHERE UserID = '$opp_id' ";
			$result3 = mysqli_query($link, $sql3) or die(mysqli_error($link));

			$var = "success";
			return $var;
		}
	
		//to apotelesma apo to tournoua
		public function TourNamentResult($id){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
				
			$round = $this->getRound($id);

				$sql = "SELECT * FROM Scores WHERE User_id = '$id' ";
				$result1 = mysqli_query($link,$sql)or die(mysqli_error($link));
				$row1 = mysqli_fetch_assoc($result1);
				$win = $row1['TournamentsWin'];
				$num = $row1['TournamentsNum'];

				$num = $num + 1;
			if($round == 1){
				$sql = "UPDATE Scores SET TournamentsNum = '$num'  WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql)or die(mysqli_error($link));
			}
			
			if($round > 1)
			{
				$win = $win + 1;
				$sql = "UPDATE Scores SET TournamentsWin = '$win' , TournamentsNum = '$num'  WHERE User_id = '$id' ";
				$result2 = mysqli_query($link, $sql)or die(mysqli_error($link));
			}

		
			//vazw opponent id kati pou den uparxei gia na min gienete anakateuthunsi
			$token_opp = rand(100, 10000000); 
			$gameid = 0;
			
			if($round == 1){
				$sql = "DELETE FROM ChessTour WHERE User_id = '$id' ";
				$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");
			}

			if($round > 1)
			{
				$opp_id = 0;

				$color = "";
				$gameID = 0;

				$lmove = "";
				//kanoume update ti vasi mas me ta nea stoixeia
				// Update User
				$sql2 = "UPDATE ChessTourRoom SET UserOpp = '$opp_id' , GameID = '$gameID' , UserColor = '$color' , LastMove = '$lmove'  WHERE UserID = '$id' ";
				$result3 = mysqli_query($link, $sql2) or die(mysqli_error($link));
			}


			return $num;
		}

		public function DeleteTournament()
		{
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}

			$sql = "SELECT * FROM ChessTourRoom ";
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
				$sql = "DELETE FROM ChessTour";
				$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");
			}

			return true;

		}

		public function DeleteTourAdmin(){
			//db connection
			$link = mysqli_connect("db","root","root","project");
			if($link === false){die("ERROR: Could not connect. ");}
			
			$sql = "DELETE FROM ChessTour";
			$result3 = mysqli_query($link, $sql)or die("Smt ges wrong");
			
			return true;
		}
	


	}
?>