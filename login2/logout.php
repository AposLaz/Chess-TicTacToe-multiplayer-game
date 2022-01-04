<?php
session_start();
require_once("resetGameID.php");
session_destroy();
if (isset($_COOKIE['token'])) {
    unset($_COOKIE['token']); 
    setcookie('token', null, -3600, '/'); 
}
header("Location:index.php");

?>