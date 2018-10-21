<?php
	if (isset($_SESSION['userId'])) 
	{
		session_unset();
		session_destroy();
		die("You have logged out");
	}
?>