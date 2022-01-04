<?php 
	$delay = rand(1,10);
	echo $delay;
	$ok = sleep($delay);
	echo "----".$ok;
?>