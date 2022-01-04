<?php 

class Token{
	public static function generate(){
		//create a key hash_hmac function
		if(empty($_SESSION['key']))
		{
			$_SESSION['key']=bin2hex(random_bytes(32));
		}
		//session id random
		$sessionID = session_id(); //Setting and storing session ID
		return $_SESSION['token'] = hash_hmac('sha256', $sessionID ,$_SESSION['key']);
	} 

	public static function check($token){
		if (isset($_SESSION['token']) && $token === $_SESSION['token']) {
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
	//verfy with token the user
	public function verify_user($cookie){
		//connect to database
		$link = mysqli_connect("db","root","root","project");
		if($link === false)
		{
			die("ERROR: Could not connect. ");
		}

		$token = explode("|", $cookie);
		//check the user and verify their values
		$sql = "SELECT * FROM Users WHERE ID = '$token[1]' ";
		$result = mysqli_query($link, $sql) or die("Bad request");

		if (mysqli_num_rows($result)) {
			while ($obj=mysqli_fetch_object($result))
			{
					$token_ver = md5(md5($obj->USERNAME . $obj->PASSWORD . $obj->PASSWORD . $obj->USERNAME));

					if($token_ver == $token[0]){
						return $token_ver;
					}
					else{
						return 0;
					}
			}
		}
	}

}

?>