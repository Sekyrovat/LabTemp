<?php
session_start();

require('connect.php');

if(empty($_SESSION['userId']) || !isset($_SESSION['userId']) || $_SESSION['userId'] === 'undefined')
{
    echo json_encode(array('status' => 'notLoggedIn'));
    die();
}

if ($conn->connect_error) 
{
    header('HTTP/1.1 500 Bad connection to Database');
    die("The server is down, we couldn't establish the DB connection");
}
else
{

    $query = "INSERT INTO userposts (postPosterId, postText, postImage) 
        VALUES (:postPosterId, :postText, :postImage)";

    $prepared_stmt = $conn->prepare($query);
    $prepared_stmt->bindParam(':postPosterId',$_SESSION['userId']);
    $prepared_stmt->bindParam(':postText',$_POST['postText']);
    $prepared_stmt->bindParam(':postImage',$_POST['postImage']);

    if ($prepared_stmt->execute()) 
    {
        $response = array("status" => "success");
        echo json_encode($response);
    }
    else 
    {
        header('HTTP/1.1 500 Conflict, something went wrong, try again later.');
        die("Service unreacheable.");
    }
}