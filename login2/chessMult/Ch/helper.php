$("#newGameID").click(function () {	
	var newGameID = $("#playerID").html();
	//elegxoume prwta an exei teleiwsei to trxon paixnidi
	$.ajax({
			type: 'POST',
			url:'winner.php',
			data:{newGameID:newGameID},
			dataType:'json',
			success:function(data){
				console.log(data.msg);
				if(data.msg == "success"){
					NewGame();
					var MoveString = BoardToFen();
						$.ajax({
							type:'POST',
							url:'../InsertMove.php',
							data:{MoveString:MoveString},
							dataType:'json',
							success:function(data1){
								//alert(data.msg);
								$("#endID").text("");
							}
						})
				}
				else{
					$("#endID").text(data.msg);
				}

			}
	})
});
