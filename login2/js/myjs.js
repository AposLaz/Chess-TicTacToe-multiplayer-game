$(document).ready(function(){
	//Insert_record();
	ViewRecord();
	get_record();
	update_record();
	delete_record();
	//order_row();
	search_record();
})

//View Data From database

function ViewRecord(){
	$.ajax({
		url : 'view.php',
		method : 'post',
		success : function(data)
		{
			//data = $.parseJSON(data);
			//console.log(data);
			/*metatrepei ta dedomena apo json morfi se jquery morfi*/
			//JSON.stringify
			data = $.parseJSON(data);
			if(data.status == 'success')
			{
				$('#myTable').html(data.html);
			}
		}

	});
}

//get the particular record
function get_record(){
	$(document).on('click','#editID',function(){
		//to this einai gia to button editID
		var ID = $(this).attr('data-id');
		$.ajax({
			url : 'get_data.php',
			method : 'post',
			data : {userID:ID},
			dataType : 'JSON',
			success: function(data)
			{
				$('#up_userid').val(data[0]);
				$('#up_usernameid').val(data[1]);
				$('#up_firstnameid').val(data[2]);
				$('#up_lastnameid').val(data[3]);
				$('#up_emailid').val(data[4]);
				$('#up_default_roleid').val(data[5]);
				$('#editModal').modal('show');
			}
		})
	})

	$(document).on('click','#viewid', function(){
		var ID = $(this).attr('data-id');
		$.ajax({
			url : 'get_data.php',
			method : 'post',
			data : {userID:ID},
			dataType : 'JSON',
			success: function(data)
			{
				$('#view_userid').val(data[0]);
				$('#view_usernameid').val(data[1]);
				$('#view_firstnameid').val(data[2]);
				$('#view_lastnameid').val(data[3]);
				$('#view_emailid').val(data[4]);
				$('#view_roleid').val(data[5]);
				$('#view_createdid').val(data[6]);
				$('#viewModal').modal('show');
			}
		})

	})
}


//Update Particular Record
function update_record()
{

	$(document).on('click','#updateid',function(){

		var update_id = $('#up_userid').val();
		var role = $('#up_roleid').val();

		if(role=="")
		{
			$('#up_msgid').html('Please Fill in The Role');
			$('#editModal').modal('show');
			if($('#up_msgid').html()!="")
			{
				$('#up_msgSuccess').html('');
			}
		}
		else
		{
			$.ajax({
				url : 'update.php',
				method : 'post',
				data : {id:update_id,role_user:role},
				success: function(data)
				{
					$('#up_msgSuccess').html(data);
					$('#editModal').modal('show');
					ViewRecord();
					if($('#up_msgSuccess').html()!="")
					{
						$('#up_msgid').html('');
					}
				}
			})
		}
	})

	//gia na mn fainetai to mnm me to kleisimo tou modal
	$(document).on('click','#close_create2',function(){
		$('#update_form').trigger('reset');
		$('#up_msgSuccess').html('');
		$('#up_msgid').html('');
	})
}

//delete record
function delete_record()
{
	$(document).on('click','#deleteid',function(){
		var del = $(this).attr('data-id');

		$(document).on('click','#deleteid-btn',function(){
			$.ajax({
				url: 'delete.php',
				method: 'post',
				data:{deleteId:del},
				success: function(data){
					$('#del_msgid').html(data).hide(10000);
					ViewRecord();
				}
			})
		})
	})
}



function search_record()
{
	$('#searchid').keyup(function(){
		var txt = $(this).val();
		if(txt!="")
		{
			console.log('qwd');
			$.ajax({
				url : 'search.php',
				method : 'post',
				data:{search:txt},
				success : function(data)
				{
					data = $.parseJSON(data);
					if(data.status == 'success')
					{
						$('#myTable').html(data.html);
					}
				}

			})
		}
		else
		{
			$.ajax({
				url : 'view.php',
				method : 'post',
				success : function(data)
				{
					//data = $.parseJSON(data);
					//console.log(data);
					/*metatrepei ta dedomena apo json morfi se jquery morfi*/
					data = $.parseJSON(data);
					if(data.status == 'success')
					{
						$('#myTable').html(data.html);
					}
				}
			})
		}
	})
}



//------------------------------------------OTHERS-------------------------------------//
//ASC OR DESC ROW
/*function order_row()
{
	$(document).on('click','#ascid',function(){
		$.ajax({
			url : 'order_row1.php',
			method : 'post',
			success: function(data){
				data = $.parseJSON(data);
				if(data.status == 'success')
				{
					$('#myTable').html(data.html);
				}	
			}
		})
	})

	$(document).on('click','#descid',function(){
		$.ajax({
			url : 'order_row2.php',
			method : 'post',
			success: function(data){
				data = $.parseJSON(data);
				if(data.status == 'success')
				{
					$('#myTable').html(data.html);
				}	
			}
		})
	})
}*/


//Insert record in the Database
/*
function Insert_record()
{
	$(document).on('click','#createid',function(){
		//first need to take the text field from the input
		var userID = $('#userid').val();
		var name = $('#nameid').val();
		var surname = $('#surnameid').val();
		var salary = $('#salaryid').val();

		if(userID == "" || name =="" || surname == "" || salary=="")
		{
			$('#msgid').html('Please fill all the fields');
		}
		else
		{
			$.ajax({
				//tha steiloume ena aithma to php url
				url: 'create_person.php',
				method: 'post',
				data:{UuserID:userID,Uname:name,Usurname:surname,Usalary:salary},
				//oti onoma thelw mporw na tou dwsw den einai aparaitito data
				success: function(data)
				{
					$('#msgSuccess').html(data);
					//to id tou modal mou gia na emfanistei to munhma sto modal
					$('#exampleModal').modal('show');
					//gia na mn uparxoun text meta to succesfull sto modal
					$('#create_form').trigger('reset');
					//gia na emfanizontai ola ta dedomena meta kai ti prosthiki
					ViewRecord();
				}
			})
		}

	})
	//gia na mn fainetai to mnm me to kleisimo tou modal
	$(document).on('click','#close_create',function(){
		$('#create_form').trigger('reset');
		$('#msgSuccess').html('');
		$('#msgid').html('');
	})	
}*/