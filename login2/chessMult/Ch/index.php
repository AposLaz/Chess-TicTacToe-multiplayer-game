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
		<title>JSChess</title>
		<link href="style1.css?v=<?=time();?>" rel="stylesheet" type="text/css">

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


	</head>
	<body style="background: #330033">


		<?php
			//header
			include "header.php";
		?>


	<!----------------------------- MODAL TOTAL SCORE --------------------------------->

			<!---------------  FIND OPPOENENT TOTAL SCORE  -------------------->

				<?php 
					$sql = "SELECT * FROM Scores WHERE User_id = '$opponent' ";
					$result1 = mysqli_query($link,$sql)or die("Oups no connection");
					$row = mysqli_fetch_assoc($result1);
					$win1 = $row['Pwin']/2;
					$losses = $row['Ploose'];
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
	      	<form method="post" action="winner.php">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        	<input type="submit" class="btn" name="leave_now" style="background-color: red" value="Leave Now">
	        </form>
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
	        <p>If the current game didn't finsish you will <b>LOST</b>!!!</p>
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

		<div class="container" style="background-color:#b35900">
			    <div class="inline" style="width:700px" >
			    	<span id="GameStatus"></span>
					<h2 style="text-align: left;margin-left: 35px;color: black">Welcome!!! You are playing against <span style="color:#331a00"><strong><?php echo $username_opp;?></strong></span>
					</h2>	
					<div id="FenInDiv" style="display:none;">			
						<input type="text" id="fenIn"/>		
						<button type="button" id="SetFen">Set Position</button>	
					</div>	
					<div id="ThinkingImageDiv">		
					</div>
					<div id="Board">
					</div>
					<div id="CurrentFenDiv" >
						<span id="currentFenSpan" style="display:none;"></span>		
					</div>				
					<div id="ChatMessages">
					</div>
					<div id="AvailablePlayers"></div>
					
					<div id="ChatMessages"></div>

				</div>

			<div class="inline" align="center" style="padding: 10px;">
				<br>
				<h1 style="color:#000;"><strong>Options</strong></h1>
				<hr style="width: 15%;border: 1px solid black">
				<div id="inline2">
					<br>
					<p style="color:#b35900;font-size: 24px;"><strong><?php echo $username_opp; ?>'s</strong> practise Score:</p>
					<button type="button" class="" data-toggle="modal" data-target="#exampleModal">Practise Score</button>
					<br>
					<br>
					<p style="color:#b35900;font-size: 24px;">Find a new opponent:</p>
					<input type="submit" data-toggle="modal" data-target="#myModal" id="deleteGame-submit" value="New Opponent">
					<br>
					<br>
					<p style="color:#b35900;font-size: 24px;">Rematch:</p>
					<input type="submit" data-toggle="modal" data-target="#newGameModal" id="NewGameButton" value="New Game">
					<br>
					<br>
				</div>
			</div>
			<!-- <input type="submit" onclick="parent.location='../chess.php'" id="deleteGame-submit" value="New Opponent"> -->
		<!--This div not outputted but needed to work  -->			
				<div id="EngineOutput"><br/>
					<select id="ThinkTimeChoice" style="display:none;">
					  <option value="1">1s</option>
					  <option value="2">2s</option>
					  <option value="4">4s</option>
					  <option value="6">6s</option>
					  <option value="8">8s</option>
					  <option value="10">10s</option>
					</select><br/><br/><br/>
			
					<span id="BestOut" style="display:none;">BestMove:</span><br/>
					<span id="DepthOut"style="display:none;">Depth:</span><br/>
					<span id="ScoreOut"style="display:none;">Score:</span><br/>
					<span id="NodesOut"style="display:none;">Nodes:</span><br/>
					<span id="OrderingOut"style="display:none;">Ordering:</span><br/>
					<span id="TimeOut"style="display:none;">Time:</span><br/><br/>
					<button type="button" id="SearchButton"style="display:none;">Move Now</button><br/>
					
					<button type="button" id="FlipButton"style="display:none;">Flip Board</button><br/><br/>
					<button type="button" id="TakeButton"style="display:none;">Take Back</button><br/><br/><br/>
					
				</div>
		<!--  -->	
			
		</div>

<!-----------------------       END CHESS BACKGROUND       ---------------------->

<!--  -->	
		<script src="js/jquery-1.10.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/defs.js"></script>
		<script src="js/io.js"></script>
		<script src="js/board.js"></script>
		<script src="js/movegen.js"></script>
		<script src="js/makemove.js"></script>
		<script src="js/perft.js"></script>
		<script src="js/evaluate.js"></script>
		<script src="js/pvtable.js"></script>
		<script src="js/search.js"></script>
		<script src="js/protocol.js"></script>
		<script src="js/guiMultiPlayer.js"></script>
		<script src="js/main.js"></script>
		<script src="js/deleteDB.js"></script>
		<script src="js/readyjs.js"></script>
		<script>
			$(document).on('click','#deleteGame-submit',function(){
				$('#myModal').modal('show');
			})
		</script>
		<!--<script src="../../js/chatboxInGame.js"></script>	-->
		
	</body>
</html>