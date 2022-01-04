<?php
  /* 
    If a user chooses to play against someone, the user gets redirected to redirect.php 
    where information is given to the database. Like gameId and who is black who is white and so on
    
    The function DisplayMessage() in chatbox.js is diplaying the chats with a timeinterval. It also checks whether a user has 
    a gameId, if it does the user is also redirected to redirect.php
    If the information is already set it goes on the Ch/index.php and the connection has been made
  */
$check_round = "";

session_start();
require_once('../csrf.php');
require_once("../config.php");
include "classes/user.php";
include "classes/tournament.php";

  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
    $token_cookie = Token::verify_user($_COOKIE['token']);
    $part = explode("|",$_COOKIE['token']);
    if($token_cookie !== $part[0]){
      header("Location: ../logout.php");
    }
  }
  if(!(isset($_SESSION['loggedin']))){
    header('Location: ../index.php');
  }

  //take the name from User
  $user_id = $_SESSION['user'];
  $sql = "SELECT * FROM Users WHERE ID = '$user_id' ";
  $result = mysqli_query($link, $sql) or die("Bad connection.Try later");
  $row = mysqli_fetch_assoc($result);
  $username = $row['USERNAME']; 
  $SESSION['UserId'] = $user_id;

  /* This is to delete gameId if gameId exists for a user and its opponent */
  /* Auto simainei pws otan kapoios mpei se auti ti selida,simaini oti den paizei
  kapoio allo paixnidi opote prepei na svisoume to GameId tou kanontas to = 1 afou einai sto skaki.
    To kanoume gia kapoion pou itan se ena allo paixnidi kai twra exei teleiwsei
  i exei vgei apo auto.
    Sto Ch/index.php uparxei ena button pou leei "New opponent" An to patisoume tote 
  tha prepei na svisoume to palio mas GameId kai na paroume kapoio kainourio.*/
  $user = new user();
  if ($_SESSION['GameId']!=1){
    $user->DeleteGame($_SESSION['GameId']);
    $_SESSION['GameId']="";
  }

  /*Elegxoume an o paixtis einai se tournoua*/
  $tour = new tournament();
  $exist_user_in_tour = $tour->ExistUser($user_id);
  if($exist_user_in_tour == true){
    $check_round = $tour->getRound($user_id);
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <!--<script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/myjs.js"></script>-->

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
<input type="hidden" id="myid" value="<?php echo $user_id; ?>">
<input type="hidden" id="round_id" value="<?php echo $check_round; ?>">

<!-------------------------- SEE TOURNAMENT RESULTS --------------------------------->

  <!-- Find Tournaments Results from DB -->

  <?php 
          $sql = "SELECT * FROM Scores WHERE User_id = '$opponent' ";
          $result1 = mysqli_query($link,$sql)or die("Oups no connection");
          $row = mysqli_fetch_assoc($result1);
          $win1 = $row['Pwin']/2;
          $losses = $row['Ploose'];
          $draw = $row['Pdraw'];

          $win = round($win1) + $draw;
          $numGames = $win + $losses + $draw;
          if($numGames > 0)
          {
            $totalScore = round(($win*100)/$numGames);
          }
          else{
            $totalScore = 0;
          }

  //get role
      $role = $user->getUserRole($_SESSION['user']);
  ?>
  <!-------------------------------------->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #b35900;">
      <div class="modal-header">
        <h1 style="color:#331a00;text-align: center" class="modal-title" id="exampleModalLabel">Tournament Results</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="userid" name="idname" readonly>
        <h2 style="color: #331a00">Total Rounds : <span id="numID"></span></h2>
        <h2 style="color: #331a00">Round Wins : <span id="winsID"></span></h2>
        <h2 style="color: #331a00">Tournament Wins : <span id="tourWinsID"></span></h2>
        <h2 style="color: #331a00">Tournament Participations : <span id="tourNumID"></span></h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-----------------------------------END MODAL --------------------------------------->


<!-- Modal -->
<div class="modal fade" id="mydatas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #b35900;">
      <div class="modal-header">
        <h1 style="color:#331a00;text-align: center;" class="modal-title" id="exampleModalLabel">My Results</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="tour_userid" name="idname" readonly>
        <h1 style="color: #331a00">Practice Match</h1>
        <hr style="border:1px solid white">
        <h2 style="color: #331a00">Wins : <span id="pr_winID"></span></h2>
        <h2 style="color: #331a00">Losses : <span id="pr_lossesID"></span></h2>
        <h2 style="color: #331a00">Draws : <span id="pr_drawID"></span></h2>
        <h2 style="color: #331a00">Total Score : <span id="pr_totalID"></span>%</h2>
        <hr >
        <h1 style="color: #331a00">Tournament</h1>
        <hr style="border:1px solid white">
        <h2 style="color: #331a00">Participations : <span id="tour_numID"></span></h2>
        <h2 style="color: #331a00">Total Wins : <span id="tour_winsID"></span></h2>
        <h2 style="color: #331a00">Match Wins : <span id="t_winID"></span></h2>
        <h2 style="color: #331a00">Match Losses : <span id="t_lossesID"></span></h2>
        <h2 style="color: #331a00;display:none;">Match Draws : <span id="t_drawID"></span></h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-----------------------------------END MODAL --------------------------------------->

<!-----------------------------------CREATE TOUR --------------------------------------->
          <?php 
            $tournament = new tournament();
            $num_tour = $tournament->ExistTour();
           ?>
            <div class="tour_butt" align="center">
            <h2><strong>Options</strong></h2>
            <hr>
            <input style="margin:20px;" data-toggle="modal" data-target="#mydatas" id="resultID" type="button" data-id="<?php echo $user_id;?>" class="btn btn-success mydata" name="results" value="My Results">
            <br>
        <?php
          if($role == "Admin" || $role == "Official"){
        ?>
            <input style="margin:20px;" id="createID" type="button" class="btn btn-success" name="tourButt" value="Create_Tournament">            
          <?php
            }
            //tournament->There is ot not
            if ($num_tour > 0){
          ?>
              <br>
              <input style="margin:20px;" id="partButt" type="button" class="btn btn-danger" name="partButt" value="Play in Tour"> 
          <?php
            }
            
            if($role == "Admin"){
          ?>
              <br>
               <input style="margin:20px;" id="deleteTour" type="button" class="btn btn-danger" name="DeleteTour" value="Delete Tournament"> 
          <?php 
            }
          ?>
        </div>


<!-----------------------------------END CREATE TOUR --------------------------------------->

<div class="container" style="background-color: #cc6600;width:50%;border-radius: 20px;" align="center" >
    <h5 style="font-size: 30px;color: #331a00"><b>ALL TABLES</b></h5>
    <hr style="border: 1px solid #331a00;">
    <ul class="list-unstyled" id="AvailablePlayers" style="">

    </ul>
</div>


     <!-- Js -->
     <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->
    <!--<script src="js/jquery.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="js/availablePlayers.js"></script>
    <script src="js/findopp.js"></script>
    <script src="js/tournament.js"></script>
     <script>//show Tournament
       $(document).ready(function() {
          setInterval(function(){
            $('.displayDATA').click(function(){
                    var ID = $(this).attr('data-id');
                    console.log(ID);

                    $.ajax({
                      url : 'getData.php',
                      method : 'post',
                      data : {userID:ID},
                      dataType : 'JSON',
                      success: function(data)
                      {
                        console.log(data);
                        $('#userid').val(data[0]);
                        $('#numID').html(data[1]);
                        $('#winsID').html(data[2]);
                        $('#tourWinsID').html(data[3]);
                        $('#tourNumID').html(data[4]);
                        $('#exampleModal').modal('show');
                      }
                    })

              });
            },800);

            $('.mydata').click(function(){
                    var ID = $(this).attr('data-id');
                    console.log(ID);

                    $.ajax({
                      url : 'getData.php',
                      method : 'post',
                      data : {myID:ID},
                      dataType : 'JSON',
                      success: function(data)
                      {
                        console.log(data);
                        $('#tour_userid').val(data[0]);
                        $('#pr_winID').html(data[1]);
                        $('#pr_lossesID').html(data[2]);
                        $('#pr_drawID').html(data[3]);
                        $('#pr_totalID').html(data[4]);
                        $('#t_winID').html(data[5]);
                        $('#t_lossesID').html(data[6]);
                        $('#t_drawID').html(data[7]);
                        $('#tour_numID').html(data[8]);
                        $('#tour_winsID').html(data[9]);
                        
                        $('#mydatas').modal('show');
                      }
                    })

              });
          
         
        });
     </script>

</body>
</html>