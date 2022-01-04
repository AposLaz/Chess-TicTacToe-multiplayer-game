<?php
	session_start();
	require_once('csrf.php'); 
	require_once("config.php");
	  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
	    $token_cookie = Token::verify_user($_COOKIE['token']);
	    $part = explode("|",$_COOKIE['token']);
	    if($token_cookie !== $part[0]){
	      header("Location: logout.php");
	    }
	  }
	  if(!(isset($_SESSION['loggedin']))){
	    header('Location: index.php');
	  }
	//tha exei oles tis sunartiseis gia crud ajax tis php

	//display the data
	function display_Record(){
		global $link;
		$value = "";
		$tmp=0;
		$myidnew = $_SESSION['user'];
		$value = '<table class = "table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Surname</th>
						<th scope="col">Email</th>
						<th scope="col">Role</th>
						<th scope="col">Action</th>
					</tr>
				</thead>';
		$sql = "SELECT * FROM Users WHERE ID<>'$myidnew' ORDER BY USERNAME";
		$result = mysqli_query($link, $sql) or die("Bad Connection");

		while ($row=mysqli_fetch_assoc($result)) {
			$tmp=$tmp+1;
			$value .= '<tbody>
							<tr>
								<td>'.$tmp.'</td>
								<td>'.$row['USERNAME'].'</td>
								<td>'.$row['EMAIL'].'</td>
								<td>'.$row['ROLE'].'</td>
								<td>
									 <button type="button" data-id='.$row['ID'].' class="viewid btn-primary" data-toggle="modal" data-target="#viewModal" id="viewid" title="View"><i class="material-icons">&#xE417;</i></button>
									 <button type="button" data-id='.$row['ID'].' class="edit btn-success" id="editID" title="edit" data-toggle="modal" data-target="#editModal"><i class="material-icons">&#xE254;</i></button>
									<button class="delete btn-danger" id="deleteid" data-id='.$row['ID'].' title="Delete" data-toggle="modal" data-target="#deleteModal"><i class="material-icons">&#xE872;</i></button>
								</td>
							</tr>
						</tbody>';
		}
		$value .= '</table>';
		echo json_encode(['status'=>'success','html'=>$value]);
	}


	//Get Particular Record
	function get_record(){
		global $link;
		$id = $_POST['userID'];
		$sql = "SELECT * FROM Users WHERE ID='$id' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");

		while ($row=mysqli_fetch_assoc($result)) 
		{
			$user_data = "";
			$user_data = array($row['ID'],$row['USERNAME'],$row['FIRSTNAME'],$row['LASTNAME'] ,$row['EMAIL'] ,$row['ROLE'],$row['created_at'] );
		}
		echo json_encode($user_data);
	}

	//-------------------------------------------update record---------------------------------
	function update_value(){
		global $link;

		$id = $_POST['id'];
		$new_role = $_POST['role_user'];

		$sql = "UPDATE Users SET ROLE = '$new_role' WHERE ID = '$id' ";
		$result = mysqli_query($link, $sql) or die("Error in connection");
		
		if($result)
			{
				echo " ROLE UPDATED SUCCESSFULLY";
			}
			else {
				echo "Something goes wrong";
			}
	}
	//-------------------------------------------end update record-------------------------------
	
	//------------------------------------------delete record------------------------------------
	function delete_record()
	{
		global $link;

		$delid = $_POST['deleteId'];

		$sql = "DELETE FROM Users WHERE ID = '$delid' ";
		$result = mysqli_query($link, $sql) or die("Bad Connection");
		if($result)
			{
				echo "The User deleted";
			}
			else {
				echo "Something goes wrong";
			}
	}
	//---------------------------------------end delete record------------------------------------

	//=====================================------SEARCH FOR USER-----=============================================//
	function search_data(){
		global $link;
		$key = $_POST['search'];
		$myidnew = $_SESSION['user'];
		$value = "";
		$tmp=0;
		$value = '<table class = "table table-striped table-hover table-bordered" >
				<thead>
					<tr>
						<th style="color:black;">ID</th>
						<th style="color:black;">Surname</th>
						<th style="color:black;">Email</th>
						<th style="color:black;">Role</th>
						<th style="color:black;">Action</th>
					</tr>
				</thead>';
		$sql = "SELECT * FROM Users WHERE ID<>'$myidnew' AND (USERNAME LIKE '%$key%' OR EMAIL LIKE '%$key%' OR ROLE LIKE '%$key%')";
		$result = mysqli_query($link, $sql) or die("Bad Connection");

		while ($row=mysqli_fetch_assoc($result)) {
			$tmp=$tmp+1;
			$value .= '<tbody>
							<tr>
								<td>'.$tmp.'</td>
								<td>'.$row['USERNAME'].'</td>
								<td>'.$row['EMAIL'].'</td>
								<td>'.$row['ROLE'].'</td>
								<td>
									 <button type="button" data-id='.$row['ID'].' class="viewid btn-primary" data-toggle="modal" data-target="#viewModal" id="viewid" title="View"><i class="material-icons">&#xE417;</i></button>
									 <button type="button" data-id='.$row['ID'].' class="edit btn-success" id="editID" title="edit" data-toggle="modal" data-target="#editModal"><i class="material-icons">&#xE254;</i></button>
									<button class="delete btn-danger" id="deleteid" data-id='.$row['ID'].' title="Delete" data-toggle="modal" data-target="#deleteModal"><i class="material-icons">&#xE872;</i></button>
								</td>
							</tr>
						</tbody>';
		}
		$value .= '</table>';
		echo json_encode(['status'=>'success','html'=>$value]);
	}


//-----------------------------------------------OTHERS----------------------------------------------------------//

//================================ DON'T USE UNTIL NOW ============================================/
	//=====================================-display order by--===================================
	/*function display_order_asc(){
		global $link;
		$value = "";
		$tmp=0;
		$value = '<table class = "table table-striped table-hover table-bordered ">
				<thead>
						<tr>
						<th scope="col">ID</th>
						<th scope="col">Surname</th>
						<th scope="col">Email</th>
						<th scope="col">Role</th>
						<th scope="col">Action</th>
					</tr>
				</thead>';
		$sql = "SELECT * FROM Users ORDER BY USERNAME ASC";
		$result = mysqli_query($link, $sql) or die("Bad Connection");

		while ($row=mysqli_fetch_assoc($result)) {
			$tmp=$tmp+1;
			$value .= '<tbody>
							<tr>
								<td>'.$tmp.'</td>
								<td>'.$row['USERNAME'].'</td>
								<td>'.$row['EMAIL'].'</td>
								<td>'.$row['ROLE'].'</td>
								<td>
									 <button type="button" data-id='.$row['ID'].' class="viewid btn-primary" data-toggle="modal" data-target="#viewModal" id="viewid" title="View"><i class="material-icons">&#xE417;</i></button>
									 <button type="button" data-id='.$row['ID'].' class="edit btn-success" id="editID" title="edit" data-toggle="modal" data-target="#editModal"><i class="material-icons">&#xE254;</i></button>
									<button class="delete btn-danger" id="deleteid" data-id='.$row['ID'].' title="Delete" data-toggle="modal" data-target="#deleteModal"><i class="material-icons">&#xE872;</i></button>
								</td>
							</tr>
						</tbody>';
		}
		$value .= '</table>';
		echo json_encode(['status'=>'success','html'=>$value]);
	}
	function display_order_desc(){
		global $link;
		$value = "";
		$tmp=0;
		$value = '<table class = "table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Surname</th>
						<th scope="col">Email</th>
						<th scope="col">Role</th>
						<th scope="col">Action</th>
					</tr>
				</thead>';
		$sql = "SELECT * FROM Users ORDER BY USERNAME DESC";
		$result = mysqli_query($link, $sql) or die("Bad Connection");

		while ($row=mysqli_fetch_assoc($result)) {
			$tmp=$tmp+1;
			$value .= '<tbody>
							<tr>
								<td>'.$tmp.'</td>
								<td>'.$row['USERNAME'].'</td>
								<td>'.$row['EMAIL'].'</td>
								<td>'.$row['ROLE'].'</td>
								<td>
									 <button type="button" data-id='.$row['ID'].' class="viewid btn-primary" data-toggle="modal" data-target="#viewModal" id="viewid" title="View"><i class="material-icons">&#xE417;</i></button>
									 <button type="button" data-id='.$row['ID'].' class="edit btn-success" id="editID" title="edit" data-toggle="modal" data-target="#editModal"><i class="material-icons">&#xE254;</i></button>
									<button class="delete btn-danger" id="deleteid" data-id='.$row['ID'].' title="Delete" data-toggle="modal" data-target="#deleteModal"><i class="material-icons">&#xE872;</i></button>
								</td>
							</tr>
						</tbody>';
		}
		$value .= '</table>';
		echo json_encode(['status'=>'success','html'=>$value]);
	}
	//=====================================----END DISPLAY ORDER USER----========================================//

	//CREATE PERSON
	function InsertRecord()
	{
		//connection variable name
		global $link;
		$id = $_POST['UuserID'];
		$name = $_POST['Uname'];
		$surname = $_POST['Usurname'];
		$salary = $_POST['Usalary'];

		$sql = "INSERT INTO Users (ID,NAME,SURNAME,SALARY) values('$id','$name','$surname','$salary')";
		$result = mysqli_query($link, $sql) or die(mysqli_error($link));

			if($result)
			{
				echo $name. " DATA SAVED SUCCESSFULLY";
			}
			else {
				echo "Something goes wrong";
			}
	}*/


?>


