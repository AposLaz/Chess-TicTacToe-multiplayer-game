<?php				
session_start();
//include vendor
require_once('csrf.php');
require_once('config.php');

$login = $password = '';
$login_err = $password_err = $login_pass_err =  '';
//If a cookie exists check users values
if(isset($_COOKIE['token'])){
	$token_cookie = Token::verify_user($_COOKIE['token']);
	$part = explode("|",$_COOKIE['token']);
	//csrf
	$token = Token::generate();
	if(Token::check($token) && ($token_cookie === $part[0]))
	{
		$_SESSION['loggedin'] = $token;
		$_SESSION['user']= $part[1];
		header("Location: home.php");
	}
	else
	{
		header("Location: index.php");
	}
}
//login
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login2"])){
		
		if(empty(trim($_POST["user"])))
		{
			$login_err = "Enter your Username or Email";
		}
		elseif(empty(trim($_POST["pwd"])))
		{
			$password_err = "Enter the password";
		}
		else
		{
			if(isset($_POST['token'])){
				$login = mysqli_real_escape_string($link,trim($_POST["user"]));
				$password = mysqli_real_escape_string($link,trim($_POST["pwd"]));

				// Tsekaroume an o xrhsths uparxei sthn database

				$checkUserExists = mysqli_query($link, sprintf('SELECT * FROM Users WHERE USERNAME = "%s" OR EMAIL = "%s" ', $login ,$login));

				if(mysqli_num_rows($checkUserExists))
				{
					// o xrhsths uparxei, tsekare gia to password
					while ($obj=mysqli_fetch_object($checkUserExists))
					{
						// an o kwdikos tairiazei me ton kryptografhmeno kwdiko sthn database
						if($obj->PASSWORD == md5(md5($password).$obj->HASH))
						{
							//elegxos gia to na doume an ta tokens antistoixoun
							if(Token::check($_POST['token'])){
								$_SESSION['loggedin'] = $_POST['token'];
								$_SESSION['user']= $obj->ID;
								//cookies
								if(isset($_POST['remember']))
								{
									$token = md5(md5($obj->USERNAME . $obj->PASSWORD . $obj->PASSWORD . $obj->USERNAME));
									$cookie = $token . "|" . $obj->ID;
									//store cookie for 1 year
									setcookie("token",$cookie,time()+(60*60*24*30*12),'/',"localhost",false,true);
								}
								if(isset($_SESSION['user']))
								{
									header("Location: home.php");
									
								}
								else
								{
									echo "Something goes wrong";
								}
							}
							else
							{
								echo "Something goes wrong with the token";
							}
						}
						else
						{
							$login_pass_err = "Invalid Email/Username or Password.";
						}
					}
					mysqli_free_result($checkUserExists);

				}
				else
				{
					$login_pass_err = "Invalid Email/Username or Password.";
				}
			}
		}

}

?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8">
	<title>login and registerForm</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play">
	<link rel="stylesheet" type="text/css" href="css/style1.css" media="screen"/>
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">-->

</head>
<body>
<div class="container">
	<div class="signin">
	
	<?php if (isset($_GET['msg'])) {  ?>
                        <div class="success-message" style="text-align:center;margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_GET['msg']; ?></div>
						<?php
						}  
						$msg=NULL;
                
                    ?>

		<form method="post" action="index.php">
			<h2 style="color: #ffffff">Log in</h2>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<div class="usermail <?php echo (!empty($login_err)) ? 'has-error' : ''; ?>">
				<input type="text" name="user" placeholder="Enter Username/Email">
				<span class="help-block"><?php echo $login_err; ?></span>
			</div>
			<div class="pass <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
				<input type="password" name="pwd" placeholder="Enter Password">
				<span class="help-block"><?php echo $password_err; ?></span>
			</div><br><br>
			<div class="field-group">
				<div><input type="checkbox" name="remember" id="remember" value="1">
				<label for="remember-me">Remember me</label>
			</div><br>
			<div class="butt <?php echo (!empty($login_pass_err)) ? 'has-error' : ''; ?>" >
				<input type="submit" name="login2" value="Log in"><br>
				<span class="help-block"><?php echo $login_pass_err; ?></span>
			</div>
			<br><br><br>

      		</form>

			<div id="container">
				<!--<a href="resetpas.php" style="margin-right:0; display: inline;font-size:12px;font-family: Tahoma, Gevena, sans-serif;">Reset my password</a>-->
				<a href="forgetPass.php" style="margin-left:10.33%;margin-right:10.33;font-size:17px;font-family: Tahoma, Gevena, sans-serif;">Forgot my password</a>
			</div>
			
			<p style="text-align: center"> Don't have account?<a href="register.php" style="color:#2196F3">&nbsp;Sign Up</a></p>
		
	</div>
</div>
</body>
</html>
