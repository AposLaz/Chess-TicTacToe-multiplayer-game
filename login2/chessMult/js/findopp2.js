$(document).ready(function() {
	setInterval(function(){
		$('.displayDATA').click(function(){
	          var ID = $(this).attr('data-id');
	          console.log(ID);
	          $('#exampleModal').modal("show");
	    });
    },1500);
 
});