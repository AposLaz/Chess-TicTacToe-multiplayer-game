<?php
/* display the users */
	session_start();
	include "classes/user.php";
	$user = new user();
	$user->DisplayAvailablePlayers();
?>