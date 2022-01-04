$(document).ready(function(){
	insertUserTour();
	CreateTournament();
	MessageUser();
	//DeleteTournament();
	BeginTour();
	DeleteTourByAdmin();
	//ExistTour();
});

/*function ExistTour(){
	$(document).ready(function(){
		setInterval(function() {
			var id = $("#myid").val();
			$.ajax({
			type: "POST",
			url: "tour_functions.php",
			data: {ExistTourID:id},
			dataType: "json",
			success:function(data){
				console
			}
		},3000);
	}
}*/

function CreateTournament(){
	$(document).on('click','#createID',function(){
		var id = $("#myid").val();
		$.ajax({
			type: "POST",
			url: "tour_functions.php",
			data: {createID:id},
			dataType: "json",
			success:function(data){
				console.log(data.msg);
				Swal.fire({
				  title: data.msg,
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

				setTimeout(function() {
				   window.location.href = 'tic-tac-toe.php';
				  }, 3000);
			}
		});
	});
}

function insertUserTour(){
	$(document).on('click','#partButt',function(){
		var id = $("#myid").val();
		$.ajax({
			type: "POST",
			url: "tour_functions.php",
			data: {PartId:id},
			dataType: "json",
			success:function(data){
				//console.log(data.msg);

				Swal.fire({
				  title: data.msg,
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
			}
		})
	});
}

function BeginTour(){
	$(document).ready(function(){
		//tha kanoume enan elegxo kathe 15 deuterolepta
		var delay = Math.floor(Math.random() * 120000) + 1000;
		var round = $("#round_id").val();
		//var delay = random * 1000;
		setInterval(function() {
			var id = $("#myid").val(); 
			$.ajax({
				type: "POST",
				url: "tour_functions.php",
				data: {BeginTourid:id,round:round},
				dataType: "json",
				async:false,
				success:function(data){
					console.log(data.msg);
					if(data.msg == "success")
					{
						window.location.href = 'TicTour/index.php';
					}
				}
			});
		}, delay);
		console.log(delay);
	});
}

function MessageUser(){
	$(document).ready(function(){
		var round = $("#round_id").val();
		var id = $("#myid").val();
		var result = "";
		if(round > 0){
			$.ajax({
				type: "POST",
				url: "tour_functions.php",
				data: {userID_msg:id,round:round},
				dataType: "json",
				async:false,
				success:function(data){
					console.log(data.msg);
					result = data.msg;
				}
			});

			Swal.fire({
				  title: result,
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
		}

		
	});
}

function DeleteTournament(){
	var id = $("#myid").val();
	$.ajax({
		type: "POST",
		url: "tour_functions.php",
		data: {DeleteID:id},
		dataType: "json",
		success:function(data){
			console.log(data.msg);
		}
	});
}

function DeleteTourByAdmin(){
	$(document).on('click','#deleteTour',function(){
		var id = $("#myid").val();
		$.ajax({
			type: "POST",
			url: "tour_functions.php",
			data: {DeleteID_Admin:id},
			dataType: "json",
			success:function(data){
				Swal.fire({
				  title: "Tournament Deleted!!!",
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

				setTimeout(function(){ window.location = "tic-tac-toe.php"; }, 3000);
			}
		});
	});
}