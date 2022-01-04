<?php

	class user{
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

			$sql = "SELECT * FROM Game WHERE UserID = '$userID' ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if(mysqli_num_rows($result)==0){ //tsekaroume na doume an eimaste sundedemenoi
				header("Location: ../logout.php");
			} else {
				while($row = mysqli_fetch_assoc($result)){

					$this->setUserId($row['UserID']);
					$this->setUserGameId($row['UserGameId']);
					$this->setUserGameOpponent($row['UserGameOpponent']);
					$this->setUserGameColor($row['UserGameColor']);

					//an den exoume kapoio multiplayer game i oxi
					if($row["UserGameId"] == 1)
					{ 
						header("Location: chess.php");
					}
					else{
						header("Location: Ch/index.php");
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
			include "classes/tournament.php";

			$sql = "SELECT * FROM Game WHERE UserGameId <> 0 ORDER BY UserGameId ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if (mysqli_num_rows($result)==0) { // evaluate the count
				return "Tom";
			}
			if (mysqli_num_rows($result) > 1) {
				while($row = mysqli_fetch_assoc($result)){
					//to id tou antipalou mas
					$id = $row["UserID"];
					$token = $row["UserGameId"];
					if($row["UserID"] != $_SESSION['UserId']) { // if opponent name,den efmanizei to onoma mas
						
						//elegxoume an o antiplaos paizei se kapoio tournoua

						$tourn = new tournament();
						$user_exist = $tourn->ExistUser($id);

						if ($row["UserGameId"] != 1 || $user_exist == true){
							$available = "Not available table";
						}else{
							$available = "Available table";
						}

						//dinoume ena tuxaio id gia to paixnidi
						if ($token==1){
								$token=rand(10000, 10000000);
						}
						//apeikonizoume ta onomata twn antipalwn
						if ($row["UserGameId"] != 1 || $user_exist == true) {
							if($row["UserGameId"] > 0){
								
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
							if($row["UserGameId"] > 0){
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

			$sql = "SELECT * FROM Game ORDER BY UserID ";	
			$result = mysqli_query($link, $sql) or die("Bad connection.Try later");

			if (mysqli_num_rows($result) == 0) { // evaluate the count
				return "Tom";
			}
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)){
					$gameID = $row["UserGameId"];			
					if($gameID == $id) {
						$GameOpponent=0;
						$GameColor="";
						$startMove="rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1";

						$UserId=$_SESSION['UserId'];

						$sql = "UPDATE Game SET UserGameOpponent = '$GameOpponent' , UserGameId = '$token' , LastMove = '$startMove' , UserGameColor = '$GameColor' , FINISH = '$GameOpponent' WHERE UserGameId = '$id' ";
			$result1 = mysqli_query($link, $sql) or die("Error in connection");
						
						
					}
				}
			}
		}

	}

?>