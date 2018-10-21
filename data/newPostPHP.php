<?php
header ( 'Accept: application/json' );
header ( 'Content-type: application/json' );

session_start();

require ( 'connect.php' );

if(empty($_SESSION['userId']) || !isset($_SESSION['userId']) || $_SESSION['userId'] === 'undefined')
{
    echo json_encode(array('status' => 'notLoggedIn'));
    die();
}
  
$query = "INSERT INTO userposts  ( postPosterId, postText, postImage ) 
            VALUES  ( :postPosterId, :postText, :postImage )";
$prepared_stmt = $conn -> prepare ( $query );

$prepared_stmt -> bindParam ( ':postPosterId' , $_SESSION['userId'] );

if  ( $_POST['newInput'] === NULL ) {
    $prepared_stmt -> bindParam ( ':postText' , "" );
} else {
    $prepared_stmt -> bindParam ( ':postText' , $_POST['postText'] );
}

if  ( $_POST['newImage'] === NULL ) {
    $prepared_stmt -> bindParam ( ':postImage' , "" );
} else {
    $prepared_stmt -> bindParam ( ':postImage' , $_POST['postImage'] );
}

if  ( $prepared_stmt -> execute() ) {
    $response = array ( "status" => "success" );
    $prepared_stmt -> close();
    echo json_encode ( $response );
} else {
    header ( 'HTTP/1.1 500 Conflict, something went wrong, try again later.' );
    $prepared_stmt -> close();
    die ( "Service unreachable" );
}

?>