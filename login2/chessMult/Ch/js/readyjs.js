$(document).ready(function(){
	//your opponent left
	setInterval(function(){
		var idleft = $("#playerID").html();
		$.ajax({
			type: "POST",
			url: "winner.php",
			data: {idleft:idleft},
			dataType: "json",
			success:function(data){
				console.log(data.msg);
				$("#GameStatus").text(data.msg);
			}
		});
	},5000);	

	//newGame Cases
	$(document).on('click','#NewGameButton',function(){
		$('#newGameModal').modal('show');
	})

	//onclick new game button


})