<?php
session_start();
// Include config file
require_once('config.php');
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $firstname = $lastname = $hashing = $hash = '';
$username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $lastname_err = '';

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

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["user"]))){
        $username_err = "Please enter a username.";
    }
    else{
        $username = trim($_POST["user"]);
        // Prepare a select statement
        $sql_u = "SELECT * FROM Users WHERE USERNAME = '$username' ";
        $res_u = mysqli_query($link, $sql_u) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_u) > 0){
                $username_err = "This username is already exist.Give a valid username.";
        } else{
                $username = trim($_POST["user"]);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["pwd"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["pwd"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        //generate encrypt password
        $password1 = generatePassword($_POST["pwd"]);
        $password = $password1['encrypted'];
        $hashing = $password1['hash'];
        $password_check = $password1['password'];
    }
    
    // Validate confirm password
    if(empty(trim($_POST["pwd-repeat"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        if(empty($password_err) && ($password_check != trim($_POST["pwd-repeat"]))){
            $confirm_password_err = "Password did not match.Try again.";
        }
    }
    

    // Validate FirstName
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter Firstname.";     
    }
    else{

        if(!ctype_alpha(trim($_POST["firstname"]))){
            $firstname_err = "Invalid Character.Use only english characters.Try again.";
        }
        else
        {
             $firstname = trim($_POST["firstname"]);
        }
    }

    // Validate LastName
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter Laststname.";     
    }else{

        if(!ctype_alpha((trim($_POST["lastname"])))){
            $lastname_err = "Invalid Character.Use only english characters.Try again.";
        }
        else
        {
             $lastname = trim($_POST["lastname"]);
        }
    }



    //Validate Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
    }else{
        $email = (trim($_POST["email"]));
        // Prepare a select statement
        $sql_e = "SELECT * FROM Users WHERE EMAIL = '$email' ";
        $res_e = mysqli_query($link, $sql_e) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res_e) > 0){
                $email_err = "This email is already exist.Give a valid email.";
        } elseif(!filter_var((trim($_POST["email"])), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.Try again.";
        }   
        else{ 
            $email = trim($_POST["email"]);
        }
        
    }

    //role default  value
    $role = "player";


    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($adress_err) && empty($mobile_phone_err)){


    $sql = "INSERT INTO Users (USERNAME, FIRSTNAME, LASTNAME, EMAIL, PASSWORD , HASH , ROLE)VALUES ('$username','$firstname','$lastname','$email','$password','$hashing' , '$role')" ;

    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    if($result)
    {
     $_SESSION['success_message'] = "Your account created succesfully.";
     //Create Scores Table
     $num = 0;
     $sql = "SELECT * FROM Users WHERE USERNAME = '$username'";
     $result1 = mysqli_query($link, $sql) or die(mysqli_error($link));
     $row1 = mysqli_fetch_assoc($result1);
     $use_id = $row1['ID'];
////////////////////////////////////////////---------INSERT SCORE CHESS
      $sql1 = "INSERT INTO Scores ( Pwin, Ploose, Pdraw , Twin , Tloose , Tdraw , TournamentsWin , TournamentsNum , User_id)VALUES ('$num','$num','$num','$num' , '$num' ,'$num' ,'$num' , '$num' , '$use_id')" ;
      $result2 = mysqli_query($link, $sql1) or die("Error in connection");
//////////////////////////////////////////-----------INSERT SCORE TIC_TAC_TOE
      $sql3 = "INSERT INTO ScoresTic ( Pwin, Plosse, Pdraw , Twin , Tlosse , Tour_wins , Tour_nums , User_id)VALUES ('$num','$num','$num','$num' ,'$num' ,'$num' , '$num' , '$use_id')" ;
      $result3 = mysqli_query($link, $sql3) or die(mysqli_error($link));
    }
    else
    {
     echo "Oups try later";
    }

    }
}
mysqli_close($link);
?>
 
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>Congratulation</title>
	<link rel="stylesheet" type="text/css" href="css/reg2.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



</head>

<body>
<div class="container" align="center">
	<div class="signup signup-med1">
		<form class="form-inline" action="register.php"  method="post" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }">
            <?php if (isset($_POST['sub'])) { if(isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])){ ?>
                        <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                        <?php
                      }  
                      unset($_SESSION['success_message']);
                    }
                    ?>
			<h2 style="color: #fff;">Sign Up</h2>
			<div class="fs">
				<div class="fs1 <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>"> 
					<input type="text" name="firstname" placeholder="Firstname" value="<?=(isset($_POST['firstname']) ? $_POST['firstname'] : '');?>">
					 <span class="help-block"><?php echo $firstname_err; ?></span>
				</div>
				<div class="fs2 <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="lastname" placeholder="Lastname" value="<?=(isset($_POST['lastname']) ? $_POST['lastname'] : '');?>">
					 <span class="help-block"><?php echo $lastname_err; ?></span>
				</div>
			</div>
             
			<div class="fs">
				<div class="fs3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="user" placeholder="Username" value="<?=(isset($_POST['user']) ? $_POST['user'] : '');?>">
					 <span class="help-block"><?php echo $username_err; ?></span>
				</div>
				<div class="fs4 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
					<input type="text" name="email" placeholder="Email" value="<?=(isset($_POST['email']) ? $_POST['email'] : '');?>">
					 <span class="help-block"><?php echo $email_err; ?></span>
				</div>
			</div>
			<div class="fs">
				<div class="fs5 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<input type="password" name="pwd" placeholder="Password" value="<?=(isset($_POST['pwd']) ? $_POST['pwd'] : '');?>">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="fs6 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<input type="password" name="pwd-repeat" placeholder="Repeat-Password" value="<?=(isset($_POST['pwd-repeat']) ? $_POST['pwd-repeat'] : '');?>">
					 <span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>
			</div>
            <br>
            <div class="fs" align="center" style="width:70%;margin-left:40px;">
                <div class="fs5" style="flex:1;width:10%">
                    <input style="margin-top:3px;" type="checkbox" name="checkbox" value="check" id="agree" />
                </div>
                <div class="fs6">
                    <label style="font-size: 12px">I have read and agree to the <strong>Terms and Conditions</strong></label>
                </div>
            </div>
            <br>
			<input name="sub" type="submit" value="Sign Up!" ><br><br>

				<span style="margin-left:;">Already have an account?</span><a href="index.php" style="text-decoration: none;font-family: 'Play',sans-serif; color: #2196F3;">&nbsp;Log In</a>
		</form>
	</div>
</div>
</body>
</html>
