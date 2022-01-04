$(document).ready(function() {
	setInterval(function() {
   		var id = document.getElementById("myid").value;
		//console.log(id);
		$.ajax({
			type: "POST",
			url: "findOpponent.php",
			data: {id:id},
			dataType: "json",
			success:function(data){
				//console.log(data.msg);
				if (data.msg == "success"){
					window.location = "UserLogin.php";
				}
			}
	});
	},2000); 
});