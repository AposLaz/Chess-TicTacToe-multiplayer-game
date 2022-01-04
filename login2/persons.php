<?php

session_start();
require_once('csrf.php');
require_once("config.php");
require_once("resetGameID.php");

  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
    $token_cookie = Token::verify_user($_COOKIE['token']);
    $part = explode("|",$_COOKIE['token']);
    if($token_cookie !== $part[0] || $_SESSION['token'] != $_SESSION['loggedin']){
      header("Location: logout.php");
    }
  }
  if(!(isset($_SESSION['loggedin']))){
    header('Location: index.php');
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GameLab</title>
<link rel="stylesheet" href="header.css">-
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/myjs.js"></script>
  <style type="text/css">
    body {
        color: #566787;
        background: #f5f5f5;
		font-family: 'Roboto', sans-serif;
  }
  
	.table-wrapper {
        background: #fff;
        padding: 20px;
        margin: 30px 0;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 8px 0 0;
        font-size: 22px;
    }

    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table td:last-child {
        width: 130px;
    }
    table.table td a {
        color: #a0a5b1;
        display: inline-block;
        margin: 0 5px;
    }
	table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }    
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 95%;
        width: 30px;
        height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 30px !important;
        text-align: center;
        padding: 0;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 6px;
        font-size: 95%;
    }    
</style>
<script type="text/javascript">
  // Prevent dropdown menu from closing when click inside the form
  $(document).on("click", ".navbar-right .dropdown-menu", function(e){
    e.stopPropagation();
  });
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body style="background-color:#4d004d">
  
     <!-- Navbar -->
       <?php
          include("header.php");
       ?>
     <!-----END Navbar ----->
     
        <!------------------------ VIEW MODAL ------------------->
        <!-- Modal View-->
                <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document" >
                    <div class="modal-content">
                      <div class="modal-header" align="center">
                        <h5 class="modal-title"  style="font-size:20px;" id="exampleModalLabel"><strong>View Person</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                          <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="view_userid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" class="form-control" id="view_usernameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salary">Email</label>
                            <input type="text" class="form-control" id="view_emailid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Firstame</label>
                            <input type="text" class="form-control" id="view_firstnameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salary">Lastname</label>
                            <input type="text" class="form-control" id="view_lastnameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salary">Role</label>
                            <input type="text" class="form-control" id="view_roleid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salary">Create Date-Time</label>
                            <input type="text" class="form-control" id="view_createdid" value="" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="close_create3">Close</button>
                        </div>

                    </div>
                        </form>
                    </div>
                  </div>
                </div>
                <!-------------------------------END VIEW MODAL------------------------------------------>

        <!----======================================--EDIT MODAL--=======================================-->
        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleeditModal" aria-hidden="true">
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header" align="center">
                <h5 class="modal-title"  style="font-size:20px;" id="exampleeditModal">Upgrade a User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <p align="center" style="color:red;" id="up_msgid"></p>
              <p id="up_msgSuccess" align="center" style="color:green;"></p>
              <form id="update_form">
                  <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="up_userid" name="idname" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" class="form-control" id="up_usernameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" id="up_emailid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salary">Firstname</label>
                            <input type="text" class="form-control" id="up_firstnameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Lastname</label>
                            <input type="text" class="form-control" id="up_lastnameid" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Role before update</label>
                            <input type="text" class="form-control" id="up_default_roleid" value="" readonly>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label for="name">Give a new Role</label>
                                <select class="selectpicker form-control" id="up_roleid" name="role_option">
                                  <option value="Player">Player</option>
                                  <option value="Official">Official</option>
                                  <option value="Admin">Admin</option>
                                </select>
                              </div>
                          </div>
                        </div>
                    </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="close_create2">Close</button>
                    <button type="button" id="updateid" name="updatePerson" class="btn btn-success" >Save</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
         <!--=================================----END EDIT MODAL--------======================================->

        ---------------------------------------DELETE MODAL----------------------------------------->
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampledeleteModalModal" aria-hidden="true">
          <div class="modal-dialog" role="document" >
            <div class="modal-content">
              <div class="modal-header" align="center">
                <h5 class="modal-title"  style="font-size:20px;" id="exampledeleteModalModal">Delete Person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <p align="center" style="color:red;font-size:20px;" >Do you want to Delete this User?</p>
              <form id="delete_form">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal" id="close_create4">Close</button>
                    <button type="button" id="deleteid-btn" name="deletePerson" class="btn btn-danger" >Delete Now</button>
                  </div>
                </form>
            </div>
          </div>
        </div>

         <!----------------------------------------END DELETE MODAL----------------------------------------->

    <div class="container">
        <div class="table-wrapper" style="margin-top: 150px;border-radius:6px;">
            <div class="table-title">
                <div class="row" >
                    <div class="col-lg-8" style="color:black;"><h2>User <b style="color:red;">Details</b></h2></div>
                    <div class="col-lg-4">
                       <!--===========================================================================================BUTTON FOR ADD PERSON 
                         <div class="search-box" style="float:right;">
                            <button type="button" style="margin-right: 20px;" class="btn btn-info add-new form-control" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add New</button>
                        </div> -->
                        <form method="post" action="">
                          <!-- style="margin-left:50px;" --> 
                            <div class="search-box">
                                <input type="text" id="searchid" name="search-text" class="form-control" placeholder="Search&hellip;" style="width:50%;color:black;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p align="center" style="font-size: 30px;" id="del_msgid"></p>
            <div id="myTable" class="table-responsive">
            </div>

            <!--<div class="clearfix">
                <div class="hint-text">There are <b><?php echo $tmp ?></b> entries</div>  
            </div>-->
        </div>
    </div>



    <!-- Js -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

     

    
</body>
</html>                                		                            