var playerName="" , opponentName="", turn = 0 , playerColor = "" ,fini = 0 ;
var grid =  [[0,0,0],[0,0,0],[0,0,0]];
var hasWinner = 0, moveCount=0;

//to meros opou fainontai ta mhnumata mas
function boardMsg(x){
	return $("#board").text(x);
}

//tuxaia epilegoume an tha xekinisei prwta o 1os i o 2os paixtis
//thelei allages 
function setTurn(){
	hasWinner=0;
	//an eimai o prasinos paizw 1os alliws paizei 1os o antiplaos m
	//gia turn = 1 xekinaw 1os alliws xekianw 2os
	if(playerColor == "green"){
		turn = 1;
		boardMsg(playerName+"'s turn now!");
	}
	else if(playerColor == "red"){
		turn = 2;
		boardMsg(opponentName+"'s turn now!");
	}
}

/*
	Me to pou mpoume sto paixnidi tha xekiname mia sunartisi .php arxeiou pou ta thetei 
	ston paixti pou epelexe ton antiplao tou tuxaia an tha paixei 1os i 2os(green->1os)
	kai (red->2os).........!!!
	Tha prepei na ftiaxoume mia sunartisi .js ajax gia na kratame gia to poios paixtis paizei.
	Isws xreiastei ena row sto table to opoio tha einai enas counter pou tha metraei tis
	kiniseis.An autes xeperasoun ts 8 kai den exei vgei kapoios nikitis to paixnidi einai
	isopalia. 
*/

function getColor()
{
	var colorID = $('#playerID').text();
	var $user_color;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {colorID:colorID},
		dataType: "json",
		cache: false,
		async:false,
		success:function(data){
			$user_color = data.msg;
		}
	});
	return $user_color;
}

function getMyTurn()
{
	var getmovesID = $('#playerID').text();
	var myturn;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {getMymovesID:getmovesID},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			myturn = data.msg;
		}
	});
	return myturn;
}

function getOppTurn()
{
	var getmovesID = $('#opponentID').text();
	var myturn;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {getOppmovesID:getmovesID},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			myturn = data.msg;
		}
	});
	return myturn;
}


function getPotision(rw,cl)
{
	var ID = $('#playerID').text();
	var pot;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {potisionID:ID,row:rw,col:cl},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			pot = data.msg;
		}
	});
	return pot;
}

function writePotision(rw,cl)
{
	var ID = $('#playerID').text();
	var color = playerColor;
	var pot;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {WritePotisionID:ID,row:rw,col:cl,color:color},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			pot = data.msg;
		}
	});
	return pot;
}

function updateTurn(){
	var upID = $('#playerID').text();
	var ok;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {upID:upID},
		dataType: "json",
		async:false,
		success:function(data){
			console.log("turn:"+data.msg);
			ok = data.msg;
		}
	});
	return ok;
}

function getFirstMove(){
	var firstMove = $('#playerID').text();
	var turn;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {firstMoveID:firstMove},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			turn = data.msg;
		}
	});
	return turn;
}

function finishMessage(){
	var id = $('#playerID').text();
	var fin;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {MsgFinalID:id},
		dataType: "json",
		async:false,
		success:function(data){
			//console.log(data.msg);
			fin = data.msg;
		}
	});
	return fin;
}
///////////////////////////////////////////APPEAR WINNER
setInterval(function(){
	var finishMsg = finishMessage();
	if(finishMsg == 1 && fini == 0) //kerdizw 
	{
		boardMsg("You WIN !!!");
				Swal.fire({
				  title: "You Win!!! Congratulations!!!",
				  height: 500,
				  confirmButtonColor: 'red',
				  showClass: {
				    popup: 'animated fadeInDown faster'
				  },
				  hideClass: {
				    popup: 'animated fadeOutUp faster'
				  }
				});
				$(".swal2-modal").css('background-color', '#e3dac3');
				$(".swal2-modal").css('height', '200px');
				$(".swal2-modal").css('border', '1px solid black');
				fini = fini + 1;

	}
	else if (finishMsg == 2 && fini == 0){ //xanw
		boardMsg("You LOST !!!");
				Swal.fire({
				  title: "You Lost",
				  height: 500,
				  confirmButtonColor: 'red',
				  showClass: {
				    popup: 'animated fadeInDown faster'
				  },
				  hideClass: {
				    popup: 'animated fadeOutUp faster'
				  }
				});
				$(".swal2-modal").css('background-color', '#e3dac3');
				$(".swal2-modal").css('height', '200px');
				$(".swal2-modal").css('border', '1px solid black');
				fini = fini + 1;
	}else if (finishMsg == 3 && fini == 0){ //isopali
		boardMsg("You DRAW !!!");
				Swal.fire({
				  title: "DRAW",
				  height: 500,
				  confirmButtonColor: 'red',
				  showClass: {
				    popup: 'animated fadeInDown faster'
				  },
				  hideClass: {
				    popup: 'animated fadeOutUp faster'
				  }
				});
				$(".swal2-modal").css('background-color', '#e3dac3');
				$(".swal2-modal").css('height', '200px');
				$(".swal2-modal").css('border', '1px solid black');
				fini = fini + 1;
	}else if (finishMsg == 4){
		var id = $('#playerID').text();
		$.ajax({
			type: "POST",
			url: "main_functions.php",
			data: {Finish_Update:id},
			dataType: "json",
			async:false,
			success:function(data){
				//console.log(data.msg);
				window.location.href = "index.php";
			}
		});
	}
},4000);
/////////////////////////////////////////-------Deixe ton antipalo
setInterval(function(){
	var myturn = getMyTurn();
	var oppturn = getOppTurn();
	var finish = finishMessage();
	grid[0][0] = getPotision(0,0);
	grid[0][1] = getPotision(0,1);
	grid[0][2] = getPotision(0,2);
	grid[1][0] = getPotision(1,0);
	grid[1][1] = getPotision(1,1);
	grid[1][2] = getPotision(1,2);
	grid[2][0] = getPotision(2,0);
	grid[2][1] = getPotision(2,1);
	grid[2][2] = getPotision(2,2);

	if(playerColor == "green" && myturn == 1 && finish == 0 && (grid[0][0] > 0 || grid[0][1] > 0 || grid[0][2]>0 ||
		grid[1][0]>0 || grid[1][1] > 0 || grid[1][2] > 0 || grid[2][0] > 0 || grid[2][1] > 0
		|| grid[2][2] > 0)){
		boardMsg(playerName+"'s turn now!");
	}
	else if(myturn<oppturn && (grid[0][0] > 0 || grid[0][1] > 0 || grid[0][2]>0 ||
		grid[1][0]>0 || grid[1][1] > 0 || grid[1][2] > 0 || grid[2][0] > 0 || grid[2][1] > 0
		|| grid[2][2] > 0) && finish == 0 ){
		boardMsg(playerName+"'s turn now!");
	}
	else if(myturn>oppturn && finish == 0 && (grid[0][0] > 0 || grid[0][1] > 0 || grid[0][2]>0 ||
		grid[1][0]>0 || grid[1][1] > 0 || grid[1][2] > 0 || grid[2][0] > 0 || grid[2][1] > 0
		|| grid[2][2] > 0)){
		boardMsg(opponentName+"'s turn now!");
	}else if(
		playerColor == "red" && (grid[0][0] > 0 || grid[0][1] > 0 || grid[0][2]>0 ||
		grid[1][0]>0 || grid[1][1] > 0 || grid[1][2] > 0 || grid[2][0] > 0 || grid[2][1] > 0
		|| grid[2][2] > 0) && finish == 0){
		boardMsg(playerName+"'s turn now!");
	}
},2000);
/////////////////////////////////////////-------EDW ARXIZEI
$(document).ready(function(){
	playerColor = getColor();
	playerName = $('#myUserName').text();
	opponentName = $('#oppName').text();
	setTurn();
});
/////////////////////////////////////////////////////My opponent Left
function OppoenentExist(){
	var oppID = $('#opponentID').text();
	var retur;
		$.ajax({
			type: "POST",
			url: "main_functions.php",
			data: {opponentID_exist:oppID},
			dataType: "json",
			async:false,
			success:function(data){
				//console.log(data.msg);
				retur = data.msg;
		}
	});
	return retur;
}

setInterval(function(){
	var checkOppoennt_exist = OppoenentExist();
	if(checkOppoennt_exist == 1){
		$('#GameStatus').text("Your Opponent left!!!");
	}
},3500);

$("#leaveNow").click(function (){
	var finish = finishMessage();
	var	myturn = getMyTurn();
	var	oppturn = getOppTurn();
	if(finish > 0 || (myturn<2 && oppturn<2))
	{
		window.location.href = "http://localhost:8081/tic-tac-toeMult/tic-tac-toe.php";
	}
	else if(finish == 0 || myturn > 1 || oppturn>1)
	{
		var id = $('#playerID').text();
		var oppID = $('#opponentID').text();
		$.ajax({
			type: "POST",
			url: "main_functions.php",
			data: {leaveID:id,oppID:oppID},
			dataType: "json",
			async:false,
			success:function(data){
				console.log(data.msg);
				window.location.href = "http://localhost:8081/tic-tac-toeMult/tic-tac-toe.php";
			}
		});
	}
});
//////////////////////////////////////////////////////START AGAIN NEW GAME
//to button gia na arxisei neo paixnidi
$("#newGameID").click(function (){
	var finish = finishMessage();
	$('#endID').text(''); //gia na mhin grafei tipota to mhnuma
	if(finish>0 && finish<4)
	{
		var myID = $('#playerID').text();
		var oppID = $('#opponentID').text();
		var ret;
		$.ajax({
			type: "POST",
			url: "main_functions.php",
			data: {myNewGameID:myID,oppID:oppID},
			dataType: "json",
			async:false,
			success:function(data){
				console.log(data.msg);
				window.location.href = "index.php";
			}
		});
	}
	else
	{
		$('#endID').text('Finish that Game first!!!');
	}
});

//edw ginete i kinisi
$(".columin").click(function (){

	if(playerName =="" || opponentName ==""){
		alert("Please set player all the names.");
		return;
	}
	/*----------Arxika elegxoume an einai i seira mas na kanoume kinisi
		vlepoume se poio guro eimaste an exoume ta prasina tote exoume rito arithmo kinisewn 
		alliws o arithmos mas tha einai zugos----*/
	var myturn = getMyTurn();
	var oppturn = getOppTurn();

	//alert("myturn = " + myturn + ",oppturn = "+oppturn);

	/*		   
			      col			
	row	   ___0____1____2__
		 0| (0,0)(0,1)(0,2)|
		 1| (1,0)(1,1)(1,2)|   	
		 2| (2,0)(2,1)(2,2)|
	*/
	row = $(this).parent().index();
	col = $(this).index();
	position = getPotision(row,col);
	//console.log(position);
	first_move = getFirstMove();
	//console.log(first_move);

	if(position != 0){
		alert("This position is taken. Please try other position.");
		return;
	}

	if(myturn>=9 || oppturn>=9){
		alert("Please click play again");
		return;
	}

	if(myturn == 1 && playerColor == "green" && first_move == "failed"){
		writePot = writePotision(row,col); //edw grafetai o pinakas
		//alert(writePot);
		moveCount++;
		$(this).text("O");
		boardMsg(opponentName+"'s turn now!");
		return;
	}
	else if(myturn<oppturn && playerColor == "green")
	{
		updateTur = updateTurn(); //auxanoume to guro ana 2
		writePot = writePotision(row,col); //edw grafetai o pinakas
		myturn = getMyTurn();
		oppturn = getOppTurn();
		//alert(writePot);
		$(this).text("O");
		boardMsg(opponentName+"'s turn now!");
		
		var ifWon = winnerCheck();
		
		if(!ifWon){
			if(myturn>=9 || oppturn>=9){
				var win = getDraw();
				$("#playButton").text("Play again");
				hasWinner=1;
				return;
			}else if(myturn<9 || oppturn<9){
				//turn = player2Name;
				//boardMsg(player2Name+"'s turn now!");
			}
			return;	
		}
		else{
			return;
		}
	}
	else if(myturn<oppturn && playerColor == "red" && first_move == "success")
	{
		updateTur = updateTurn(); //auxanoumet to guro ana 2
		writePot = writePotision(row,col);
		myturn = getMyTurn();
		oppturn = getOppTurn();

		$(this).text("X");
		boardMsg(opponentName+"'s turn now!");
		var ifWon = winnerCheck();
		if(!ifWon){
			if(myturn>=9 || oppturn>=9){
				var win = getDraw();
				$("#playButton").text("Play again");
				hasWinner=1;
				return;
			}else if(myturn<9 || oppturn<9){
				
			}
			return;	
		}
		else{
			return;
		}
	}

});
///ISOPALIA
function getDraw(){
	var myID = $('#playerID').text();
	var oppID = $('#opponentID').text();
	var ret;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {myDrawID:myID,oppID:oppID},
		dataType: "json",
		async:false,
		success:function(data){
			console.log(data.msg);
			ret = data.msg;
		}
	});
	return ret;
}
/*
	Elegxei an exoume ena mia nea kinisi sti vasi mas kai apeikonizei to board antistoixa
	an nai.
*/

function loadLMove(){ 
	grid[0][0] = getPotision(0,0);
	grid[0][1] = getPotision(0,1);
	grid[0][2] = getPotision(0,2);
	grid[1][0] = getPotision(1,0);
	grid[1][1] = getPotision(1,1);
	grid[1][2] = getPotision(1,2);
	grid[2][0] = getPotision(2,0);
	grid[2][1] = getPotision(2,1);
	grid[2][2] = getPotision(2,2);
	/////////////////////////////green
	if(grid[0][0] == 1)
	{
		$('#col_1').text("O");
	}
	if(grid[0][1] == 1)
	{
		$('#col_2').text("O");
	}
	if(grid[0][2] == 1)
	{
		$('#col_3').text("O");
	}
	if(grid[1][0] == 1)
	{
		$('#col_4').text("O");
	}
	if(grid[1][1] == 1)
	{
		$('#col_5').text("O");
	}
	if(grid[1][2] == 1)
	{
		$('#col_6').text("O");
	}
	if(grid[2][0] == 1)
	{
		$('#col_7').text("O");
	}
	if(grid[2][1] == 1)
	{
		$('#col_8').text("O");
	}
	if(grid[2][2] == 1)
	{
		$('#col_9').text("O");
	}
	////////////////////////////red
	if(grid[0][0] == 2)
	{
		$('#col_1').text("X");
	}
	if(grid[0][1] == 2)
	{
		$('#col_2').text("X");
	}
	if(grid[0][2] == 2)
	{
		$('#col_3').text("X");
	}
	if(grid[1][0] == 2)
	{
		$('#col_4').text("X");
	}
	if(grid[1][1] == 2)
	{
		$('#col_5').text("X");
	}
	if(grid[1][2] == 2)
	{
		$('#col_6').text("X");
	}
	if(grid[2][0] == 2)
	{
		$('#col_7').text("X");
	}
	if(grid[2][1] == 2)
	{
		$('#col_8').text("X");
	}
	if(grid[2][2] == 2)
	{
		$('#col_9').text("X");
	}

}
//------------------------EDW GINETE I FORTWSI TIS KINISIS---------------------------------
loadLMove();
setInterval(loadLMove,2000);
//-----------------------------------------------------------------------------------------

function getWinnerGreen(){
	var color = playerColor;
	var myID = $('#playerID').text();
	var oppID = $('#opponentID').text();
	var ret;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {winnerID:myID,oppID:oppID,color:playerColor},
		dataType: "json",
		async:false,
		success:function(data){
			console.log(data.msg);
			ret = data.msg;
		}
	});
	return ret;
}

function getWinnerRed(){
	var color = playerColor;
	var myID = $('#playerID').text();
	var oppID = $('#opponentID').text();
	var ret;
	$.ajax({
		type: "POST",
		url: "main_functions.php",
		data: {winnerRedID:myID,oppID:oppID,color:playerColor},
		dataType: "json",
		async:false,
		success:function(data){
			console.log(data.msg);
			ret = data.msg;
		}
	});
	return ret;
}

function winnerCheck(){
		grid[0][0] = getPotision(0,0);
		grid[0][1] = getPotision(0,1);
		grid[0][2] = getPotision(0,2);
		grid[1][0] = getPotision(1,0);
		grid[1][1] = getPotision(1,1);
		grid[1][2] = getPotision(1,2);
		grid[2][0] = getPotision(2,0);
		grid[2][1] = getPotision(2,1);
		grid[2][2] = getPotision(2,2);
		//kerdizei o prasinos
	if(	
		(grid[0][0]==1 && grid[0][1]==1 && grid[0][2]==1) ||
		(grid[1][0]==1 && grid[1][1]==1 && grid[1][2]==1) ||
		(grid[2][0]==1 && grid[2][1]==1 && grid[2][2]==1) ||

		(grid[0][0]==1 && grid[1][0]==1 && grid[2][0]==1) ||
		(grid[0][1]==1 && grid[1][1]==1 && grid[2][1]==1) ||
		(grid[0][2]==1 && grid[1][2]==1 && grid[2][2]==1) ||

		(grid[0][0]==1 && grid[1][1]==1 && grid[2][2]==1)||
		(grid[0][2]==1 && grid[1][1]==1 && grid[2][0]==1)


		){

			var winner = getWinnerGreen();

		boardMsg(playerName+" won the game!");
		hasWinner = 1;
		return true;
	}//kerdizei o kokkinos
	else if(
		(grid[0][0]==2 && grid[0][1]==2 && grid[0][2]==2) ||
		(grid[1][0]==2 && grid[1][1]==2 && grid[1][2]==2) ||
		(grid[2][0]==2 && grid[2][1]==2 && grid[2][2]==2) ||

		(grid[0][0]==2 && grid[1][0]==2 && grid[2][0]==2) ||
		(grid[0][1]==2 && grid[1][1]==2 && grid[2][1]==2) ||
		(grid[0][2]==2 && grid[1][2]==2 && grid[2][2]==2) ||

		(grid[0][0]==2 && grid[1][1]==2 && grid[2][2]==2)||
		(grid[0][2]==2 && grid[1][1]==2 && grid[2][0]==2)
		){
			var winner = getWinnerRed();

			hasWinner = 1;
			return true;
	}
	return false;
}

