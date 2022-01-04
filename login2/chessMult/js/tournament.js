$(document).ready(function(){
	insertUserTour();
	CreateTournament();
	MessageUser();
	DeleteTournament();
	BeginTour();
	DeleteTourByAdmin();
});

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
				   window.location.href = 'chess.php';
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
		var delay = Math.floor(Math.random() * 60000) + 1000;
		//var delay = random * 1000;
		setInterval(function() {
			var id = $("#myid").val(); 
			$.ajax({
				type: "POST",
				url: "tour_functions.php",
				data: {BeginTourid:id},
				dataType: "json",
				success:function(data){
					console.log(delay);
					if(data.msg == "success")
					{
						window.location.href = 'ChTournament/index.php';
					}
				}
			});
		}, delay);
	});
}

function MessageUser(){
	$(document).ready(function(){
		var round = $("#round_id").val();
		var id = $("#myid").val();

		if(round > 0){
			$.ajax({
				type: "POST",
				url: "tour_functions.php",
				data: {userID_msg:id},
				dataType: "json",
				success:function(data){
					console.log(data.msg);
				}
			});
		}

		if(round > 1){
				Swal.fire({
				  title: "You won the tournament",
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

		if(round == 1){
				Swal.fire({
				  title: "You Lost the tournament",
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

				setTimeout(function(){ window.location = "chess.php"; }, 3000);
			}
		});
	});
}