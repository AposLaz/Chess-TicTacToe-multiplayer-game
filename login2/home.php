<?php
    session_start();
require_once('csrf.php');
require_once("config.php");
require_once("resetGameID.php");

  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
    $token_cookie = Token::verify_user($_COOKIE['token']);
    $part = explode("|",$_COOKIE['token']);
    if($token_cookie !== $part[0] || ($_SESSION['token'] != $_SESSION['loggedin'])){
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
    .container{
        background-color:#660066;
        border-radius:20px;
        position: relative;
        text-align: center;
        padding:40px;
        border:1px solid black;
    }

    .responsive1{
        width:100%;
        height:500px;
        opacity: 0.8;
        border-radius:50px;
        border:8px solid black;
        background-color:black;
    }

    .responsive1:hover {
        opacity: 0.3;
        cursor:pointer;
        background-color:black;
    }

    .responsive2{
        width:100%;
        height:500px;
        opacity: 0.8;
        border-radius:50px;
        border:8px solid black;
        background-color:black;
    }

    .responsive2:hover {
        opacity: 0.3;
        cursor:pointer;
        background-color:black;
    }

        @media screen and (max-width: 450px) {
            .responsive1 {
                width:100%;
                height:300px;
            }
            .responsive2 {
                width:100%;
                height:300px;
            }
        }

        @media screen and (min-width: 700px) {
            .responsive1 {
                width:100%;
                height:500px;
            }
            .responsive2 {
                width:100%;
                height:500px;
                margin-left:0px;
            }
        }
        /* Centered text */
            .centered {
            cursor:pointer;
            position: absolute;
            top: 50%;
            font-size:50px;
            left: 50%;
            transform: translate(-50%, -50%);
            }


    }
</style>
<script type="text/javascript">
  // Prevent dropdown menu from closing when click inside the form
  $(document).on("click", ".navbar-right .dropdown-menu", function(e){
    e.stopPropagation();
  });
</script>
</head>
<body style="background: #330033">

<?php
    include('header.php');
?>




<div class="container">
    <div class="text1" align="center">
        <h1 style="color:white;font-size:50px;">Welcome to <strong style="color:#ace600">Game</strong><b style="color:#ace600">LAB</b></h1>
        <hr style="width:30%;border: 1px solid white;">
        <p style="color:white;font-size:20px;">Select and play a game</p>
        <br>
    </div>
  <div class="games">
    <div class="row">
        <div class="col-lg-6 img1"><a href="resetGameChess.php">
            <img class="responsive1" src="images/Chess.jpg" alt="Chess">
            <div class="centered"><strong style="color:black">CHESS MASTER</strong></div>
            </a>
        </div>
        <div class="col-lg-6"><a href="resetGameTicTacToe.php">
            <img class="responsive2" src="images/tac.jpg"  alt="Chess">
            <div class="centered"><strong style="color:black">TIC-TAC-TOE</strong></div>
            </a>
        </div>
    </div>
  </div>
</div>

<br>
<br>

     <!-- Js -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>