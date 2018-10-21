<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "weblab";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error) 
	{
		header('HTTP/1.1 500 Bad connection to Database');
		die("The server is down, we couldn't establish the DB connection");
		exit('Error connecting to database'); //Should be a message a typical user could understand in production
	}
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn->set_charset("utf8mb4");
?>