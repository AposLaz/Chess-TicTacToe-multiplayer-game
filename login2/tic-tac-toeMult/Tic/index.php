<?php
	
	session_start();
	/* 
		If New opponent button is pushed the player is redirected to indexMult.
		This page checks if it has a gameId and if so it deletes the gameId for the user
		and the opponent
		The function DisplayMessageInGame() in chatBoxInGame.js is displaying the chats with a timeinterval. 
		It also check whether a user has 
		a gameId, if not it is also redirected to intexMult.php
	*/
	//db connection
	$link = mysqli_connect("db","root","root","project");
	if($link === false){die("ERROR: Could not connect. ");}

	require_once('../../csrf.php');
	  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
	    $token_cookie = Token::verify_user($_COOKIE['token']);
	    $part = explode("|",$_COOKIE['token']);
	    if($token_cookie !== $part[0]){
	      header("Location: ../../logout.php");
	    }
	  }
	  if(!(isset($_SESSION['loggedin']))){
	    header('Location: ../../index.php');
	  }

	  //take the name from User
       $opponent = $_SESSION['Opponent'];

        $sql = "SELECT * FROM Users WHERE ID = '$opponent' ";
        $result = mysqli_query($link, $sql) or die("Bad connection.Try later");
        $row = mysqli_fetch_assoc($result);
        $username_opp = $row['USERNAME'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<META HTTP-EQUIV=Refresh;>
		<meta charset="utf-8">
		<meta name="keywords" content="Chess, Engine, Javascript, Play Chess, Chess Program, Javascript Chess, Game">
		<title>JSTicTacToe</title>
		<link href="style1.css?v=<?=time();?>" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/reset.css">

		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		
				<script type="text/javascript">
		  // Prevent dropdown menu from closing when click inside the form
		  $(document).on("click", ".navbar-right .dropdown-menu", function(e){
		    e.stopPropagation();
		  });
		</script>
		<script type="text/javascript"> if (!window.console) console = {log: function() {}}; </script>
		<style type="text/css">
				#game-wrap{
					width: 450px;
					height: 455px;
					margin: 0 auto;
					background: gray;
					margin-top: 50px;
					border-left: 5px solid gray;
					border-radius: 20px;
					border-top-left-radius: 20px;
				}

				.row1{
					width: 100%;
					height: 150px;
				}
				.columin{
					width: 33%;
					height: 148.5px;
					border: 3px solid white;
					float: left;
					text-align: center;
					font-size: 120px; /* to megethos tou sumvolou */
					font-family: helvetica;
					color: white;
					cursor: pointer;
				}
				.matched{
					color: maroon;
				}
				.player-1-color{
					color: maroon;
				}
				.columin:nth-child(1){
					border-left: none;
				}
				.columin:nth-child(3){
					border-right: none;
				}

				.row1:nth-child(1) .columin{
					border-top: none;
					margin-top: 3px;
				}
				.row1:nth-child(3) .columin{
					border-bottom: none;
					margin-bottom: 3px;
				}

				#panel{
					width: 400px;
					padding: 10px;
					margin: 0 auto;
					background: brown;
					border-bottom-right-radius: 20px;
					border-bottom-left-radius: 20px;
				}

				#board{
					font-size: 30px;
					font-family: helvetica;
					color: whitesmoke;
					margin-top: 10px;
				}
		</style>

	</head>
	<body style="background: #330033">


		<?php
			//header
			include "header.php";
		?>

		<span id="opponentID" style="color:green;display: none;"><?php echo $opponent;?></span>
	<!----------------------------- MODAL TOTAL SCORE --------------------------------->

			<!---------------  FIND OPPOENENT TOTAL SCORE  -------------------->

				<?php 
					$sql = "SELECT * FROM ScoresTic WHERE User_id = '$opponent' ";
					$result1 = mysqli_query($link,$sql)or die("Oups no connection");
					$row = mysqli_fetch_assoc($result1);
					$win1 = $row['Pwin'];
					$losses = $row['Plosse'];
					$draw = $row['Pdraw'];

					$win = round($win1) + $draw;
					$numGames = $win + $losses + $draw;
					if($numGames > 0)
					{
						$totalScore = round(($win*100)/$numGames);
					}
					else{
						$totalScore = 0;
					}
				?>
			<!---------------END  FIND OPPOENENT TOTAL SCORE  ----------------->

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="background-color: #cc6600">
	      <div class="modal-header" align="center">
	        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 22px;"><strong><?php echo $username_opp; ?>'s</strong> total Score is:</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       	<div class="progress">
			  <div class="progress-bar bg-warning" role="progressbar" style="color:black;width:<?php echo $totalScore;?>%" aria-valuenow="<?php echo $totalScore;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $totalScore; ?>%</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!--------------------------END MODAL TOTAL SCORE -------------------------->


	<!------------------------- MODAL NEW OPPONENT --------------------------->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="showWinner" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="background-color: #cc6600">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <h1>Are you sure that you want to <b>LEAVE</b>?</h1>
	        <p>If the game began you will <b>LOST</b>!!!</p>
	      </div>
	      <div class="modal-footer">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        	<input type="submit" id="leaveNow" class="btn" name="leave_now" style="background-color: red" value="Leave Now">
	      </div>
	    </div>
	  </div>
	</div>

	<!----------------------END MODAL SHOW THE OPPOMENET ---------------------------->

	<!------------------------- MODAL NEW GAME --------------------------->
	<!-- Modal -->
	<div class="modal fade" id="newGameModal" tabindex="-1" role="dialog" aria-labelledby="showWinner" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="background-color: #cc6600">
	      <div class="modal-header">
	        <h5 class="modal-title" id="endID" style="color:red;text-align:center;font-size: 25px;"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <h1>Rematch ???</h1>
	        <p>If the game began you have to <b>Finish</b> it first!!!</p>
	      </div>
	      <div class="modal-footer">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        	<button type="button" class="btn" name="newGame" id="newGameID" style="background-color: red">Rematch</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!----------------------END MODAL SHOW THE GAME ---------------------------->

	<!-----------------------        CHESS BACKGROUND       ---------------------->
		<span id="playerID" style="color:green;display: none;"><?php echo $_SESSION['UserId'];?> </span>

		<div class="container" style="background-color:#00004d;">
			    <div class="inline" style="width:700px" >
			    	<span id="GameStatus" style="text-align:left;"></span>
					<h2 style="text-align: left;margin-left: 60px;color: white">Welcome!!! You are playing against <span style="color:#800000"><strong id="oppName"><?php echo $username_opp;?></strong></span>
					</h2>	
					<!-- EDW THA MPEI I TRILIZA -->

					<div id="game-wrap" align="center">
	
						<div class="row1">
							<div id="col_1" class="col columin"></div>
							<div id="col_2" class="col columin"></div>
							<div id="col_3" class="col columin"></div>
						</div>

						<div class="row1">
							<div id="col_4" class="col columin"></div>
							<div id="col_5" class="col columin"></div>
							<div id="col_6" class="col columin"></div>
						</div>

						<div class="row1">
							<div id="col_7" class="col columin"></div>
							<div id="col_8" class="col columin"></div>
							<div id="col_9" class="col columin"></div>
						</div>

					</div>

				</div>


			<div class="inline" align="center" style="padding: 10px;">
				<br>
				<h1 style="color:#fff;"><strong>Options</strong></h1>
				<hr style="width: 15%;border: 1px solid black">
				<div id="inline2">
					<br>
					<p style="color:#800000;font-size: 24px;"><strong><?php echo $username_opp; ?>'s</strong> practise Score:</p>
					<button type="button" class="" data-toggle="modal" data-target="#exampleModal">Practise Score</button>
					<br>
					<br>
					<p style="color:#800000;font-size: 24px;">Find a new opponent:</p>
					<input type="submit" data-toggle="modal" data-target="#myModal" id="deleteGame-submit" value="New Opponent">
					<br>
					<br>
					<p style="color:#800000;font-size: 24px;">Rematch:</p>
					<input type="submit" data-toggle="modal" data-target="#newGameModal" id="NewGameButton" value="New Game">
					<br>
					<br>
					<div id="panel">
						<h1 id="board"></h1>
					</div>
				</div>
			</div>
			
		<!--  -->	
			
		</div>

<!-----------------------       END CHESS BACKGROUND       ---------------------->

<!--  -->	
		<script src="js/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script src="js/main.js"></script>
		
		<script>
			$(document).on('click','#deleteGame-submit',function(){
				$('#myModal').modal('show');
			})
		</script>
		<!--<script src="../../js/chatboxInGame.js"></script>	-->
		
	</body>
</html>