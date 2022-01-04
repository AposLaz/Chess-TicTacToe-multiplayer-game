<?php
session_start();

require_once('csrf.php');
require_once("config.php");
require_once("resetGameID.php");

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

 	//-----------------------------------------CHECK AND UPDATE--------------------------------//

 	if($_SERVER["REQUEST_METHOD"] == "POST"){
 	
 	if(isset($_POST['applybut'])){
        
        if(empty(trim($_POST['oldpwd'])))
        {
            $password_err = "! Fill your password";
        }
        elseif(empty(trim($_POST['newpwd'])))
        {
            $new_password_err = "! Fill your password";
        }elseif (empty(trim($_POST['repeat-newpwd']))) {
            $confirm_password_err = "! Fill your password";
        }
        else
        {
                if(($_POST['oldpwd']))
                {
                    $password = $_POST['oldpwd'];
                    $id = $_SESSION['user'];
                    $sql = "SELECT * FROM Users WHERE ID = '$id' ";
                    $result1 = mysqli_query($link, $sql) or die(mysqli_error($link));
                    $row = mysqli_fetch_assoc($result1);

                    $encr_pwd = $row['PASSWORD'];
                    $hash_pwd = $row['HASH'];

                   if($encr_pwd != md5(md5($password).$hash_pwd)){
                      $password_err = "This is not your password";
                    }
                }

                //functions for generate password
                function generateRandomString($length = 32) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }

                function generatePassword($pwd) {
                    $hash = generateRandomString(32);
                    $encrypted = md5(md5($pwd).$hash);

                    return ['password' => $pwd, 'encrypted' => $encrypted, 'hash' => $hash];
                    
                }

                 if(strlen(trim($_POST["newpwd"])) < 6){
                    $new_password_err = "Password must have atleast 6 characters.";
                 } else{
                    $new_password = trim($_POST["newpwd"]);
                    //generate encrypt password
                    $password1 = generatePassword($_POST["newpwd"]);
                    $password = $password1['encrypted'];
                    $hashing = $password1['hash'];
                    $password_check = $password1['password'];

                 }
                            // Validate confirm password
                if(empty(trim($_POST["repeat-newpwd"]))){
                    $confirm_password_err = "Please confirm password.";     
                } else{
                    if(empty($password_err) && ($password_check != trim($_POST["repeat-newpwd"]))){
                        $confirm_password_err = "Password did not match.Try again.";
                    }
                }


        }



    // Check input errors before inserting in database
    if(empty($password_err) && empty($confirm_password_err) && empty($new_password_err)){


	$sqlq = "UPDATE Users SET PASSWORD='$password' , HASH = '$hashing'  WHERE ID = '$id'";

    $resultq = mysqli_query($link, $sqlq) or die(mysqli_error($link));
    if($resultq)
    {
      $_SESSION['pass_message'] = "Your password changed successfully!!!";
      //$msg = "Your password changed successfully!!!";
    	 header("Location:UpdateProfile.php");      //"Location: UpdateProfile.php?msg=<?php echo $msg;
    }
    else
    {
     echo "Oups try later";
    }

    }
}
}



?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SchoolSystem/ChangePass</title>
<link rel="stylesheet" href="css/changePassword.css" type="text/css">
<link rel="stylesheet" href="header.css">-
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body style="background-color:#330033;">

<?php
  include('header.php');
?>

<form method="post">

  <div class="container" style="background-color: #e5e5c7;width:50%;border: 1px solid black;">
    <h1>Change the password</h1>
    <hr>
  <div class="cont1" >
    <div class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label for="oldpwd"><b>Old password</b></label>
             <input id="myInput" type="password" placeholder="Enter Password" name="oldpwd" >
             <span style="margin-top:-10px;" class="help-block"><?php echo $password_err; ?></span>
            <input type="checkbox" onclick="myFunction()">Show Password
        </div>
      <br><br>
      <div class="<?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label for="newpwd"><b>New password</b></label>
              <input id="myInput1" type="password" placeholder="Enter Password" name="newpwd" >
              <span style="margin-top:-10px;" class="help-block"><?php echo $new_password_err; ?></span>
              <input type="checkbox" onclick="myFunctionNEW()">Show Password
        </div>
           <br><br>
    <div class="<?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
          <label for="repeat-newpwd"><b>Confirm new password</b></label>
          <input id="myInput2" type="password" placeholder="Enter Password" name="repeat-newpwd" >
          <span style="margin-top:-10px;" class="help-block"><?php echo $confirm_password_err; ?></span>
          <input type="checkbox" style="display:border;border-radius:100%;" onclick="myFunctionNEW1()">Show Password
     </div>
  
  <div class="fs2">
    <hr>
    <button type="submit" name="applybut" class="applybut" style="float:right;">Apply</button>
    <a style="margin: 8px 0;padding: 16px 20px;text-decoration: none;text-align:center;color: white;opacity: 0.9;float:left;" href="UpdateProfile.php" class="cancelbtn">Cancel</a>
  </div>

  </div>
 </div> 

</form>





<script>
function myFunctionNEW1() {
  var x = document.getElementById("myInput2");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<script>
function myFunctionNEW() {
  var x = document.getElementById("myInput1");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>


</body>
</html>_