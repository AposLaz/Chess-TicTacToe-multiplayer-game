<?php
session_start();

  require_once('../../csrf.php');
  require_once("../../config.php");
  if(isset($_COOKIE['token']) && isset($_SESSION['loggedin'])){
    $token_cookie = Token::verify_user($_COOKIE['token']);
    $part = explode("|",$_COOKIE['token']);
    if($token_cookie !== $part[0]){
      header("Location: ../../logout.php");
    }
  }
  if(!(isset($_SESSION['loggedin']))){
    header('Location: ../../index.php');
  }
        //take the name from User
        $user_id = $_SESSION['user'];
        $sql = "SELECT * FROM Users WHERE ID = '$user_id' ";
        $result = mysqli_query($link, $sql) or die("Bad connection.Try later");
        $row = mysqli_fetch_assoc($result);
        $username = $row['USERNAME'];                
   
 

?>

<nav style="border-bottom-right-radius: 25px;border-top-left-radius: 25px;border:2px solid black;" class="navbar navbar-default navbar-expand-lg navbar-light fixed-top sticky-top">
  <div class="navbar-header d-flex col">
    <a class="navbar-brand" href="../../home.php" style="color:purple">Game<b style="color:red">Lab</b></a>     
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
      <span class="navbar-toggler-icon"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <!-- Collection of nav links, forms, and other content for toggling -->
  <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    <ul class="nav navbar-nav">
      <li class="nav-item"><a href="../../home.php" class="nav-link" style="color:black"><strong>Home</strong></a></li>
      <?php 
          if($row['ROLE']==="Admin")
          {
       ?>
      <li class="nav-item"><a href="../../persons.php" class="nav-link" style="color:black"><strong>Admin_Functions</strong></a></li>    
      <?php } ?>  
     
      
  
    </ul>


    <ul class="nav navbar-nav  navbar-right ml-auto "> 
      <li class="nav-item">
        <a href="#" data-toggle="dropdown"  class="btn-login btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1" style="background-color:red;color:white;border-radius:100px;">
        <?php echo $username; ?></a>
        <ul class="dropdown-menu form-wrapper">         
          <li>

              <p class="hint-text" style="color:black">Make a choice for your account!</p>
            <form action="../UpdateProfile.php" method="post">
              <div class="form-group">
                <input type="submit" style="background-color:#660066;" class="btn btn-primary btn-block" value="Settings for your account" >
              </div>
            </form>
            <form action="../../logout.php" method="post" > 
              <input type="submit" class="btn btn-primary1 btn-block" value="Log out">
            </form>
          </li>
        </ul>
      </li>

    </ul>

  </div>
</nav>


</body>
   
   
    





