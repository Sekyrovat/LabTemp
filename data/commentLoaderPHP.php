<?php

header('Content-type: application/json');

session_start();

require('connect.php');

if(empty($_SESSION['userId']) || !isset($_SESSION['userId']) || $_SESSION['userId'] === 'undefined')
{
    echo json_encode(array('status' => 'notLoggedIn'));
    die();
}
   
$query = "SELECT pt1.postPosterId, pt1.postText, pt1.postImage, useraccounts.userId, useraccounts.username, useraccounts.userProfilePic FROM (SELECT userposts.postPosterId, userposts.postText, userposts.postImage FROM userposts WHERE userposts.postPosterId = ? OR userposts.postPosterId = (SELECT user1 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y') OR userposts.postPosterId = (SELECT user2 FROM friendrelations WHERE (user1 = ? OR user2 = ?) AND areFriends = 'Y')) as pt1 INNER JOIN useraccounts ON pt1.postPosterId=useraccounts.userId";

$stmt = $conn->prepare($query);
$temp = $_SESSION['userId'];
$stmt->bind_param("iiiii",$temp,$temp,$temp,$temp,$temp);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $arrOfPosts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $currentRow = array("posterId" => $row["postPosterId"], "postText" => $row["postText"], "postImage" => $row["postImage"], "posterProfilePic" => $row["userProfilePic"], "posterUserName" => $row["username"]);
        array_push($arrOfPosts, $currentRow);
    }
    mysqli_free_result($result);
    echo json_encode($arrOfPosts);
} 
else {
    header('HTTP/1.1 500 Bad connection, retrieval error');
    die("Error: " . mysqli_error($conn));
}

?>