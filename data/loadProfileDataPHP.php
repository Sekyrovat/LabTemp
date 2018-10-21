<?php

header('Accept: application/json');
header('Content-type: application/json');

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

    $query = "SELECT * FROM useraccounts WHERE userId = ?;";
    $stmt = $conn->prepare($query);
    $temp = 1;
    $stmt->bind_param("i", $temp);

    if (!$stmt->execute()) 
    {
        header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
        die("Error: " . $query . "\n" . mysqli_error($conn));
    }
    else 
    {       
        $result = $stmt->get_result();

        $arrOfData = array();
        $row = mysqli_fetch_assoc($result);

        $arrOfData = array("userCountry" => $row["userCountry"], "userEmail" => $row["userEmail"], "userFiName" => $row["userFiName"], "userLaName" => $row["userLaName"], "userGender" => $row["userGender"], "username" => $row["username"], "userProfilePic" => $row["userProfilePic"]);

        echo json_encode($arrOfData);

        /* free results */
        $stmt->free_result();

        /* close statement */
        $stmt->close();
    }
}
?>