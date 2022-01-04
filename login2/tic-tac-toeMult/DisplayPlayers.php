<?php
/* display the users */
	session_start();
	include "classes/userTic.php";
	$user = new userTic();
	$user->DisplayAvailablePlayers();
?>