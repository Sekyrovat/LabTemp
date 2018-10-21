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
    session_start();

    $uId = $_SESSION['userId'];

    $query = "SELECT userPwd,userId FROM useraccounts WHERE username = ?";

    $prepared_stmt = $conn->prepare($query);
    $prepared_stmt->bind_param("s",$user1);

    $user1 = $user;

    if (!$prepared_stmt->execute()) 
    {
        header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
        die("Error: " . $query . "\n" . mysqli_error($conn));
    }
    else 
    {       
        $prepared_stmt->execute();
        $prepared_stmt->store_result();
        $prepared_stmt->bind_result($pwd, $unId);
        $prepared_stmt->fetch();

        if ($pwd === $userPassword) 
        {
            session_start();
            $_SESSION['userId'] = $unId;

            $response = array("status" => "success");
            echo json_encode($response);
            /* free results */
            $prepared_stmt->free_result();

            /* close statement */
            $prepared_stmt->close();
        } 
        else 
        {
            header('HTTP/1.1 409 Conflict, invalid user password combination.');
            die("Invalid user password combination.");
            /* free results */
            $prepared_stmt->free_result();

            /* close statement */
            $prepared_stmt->close();
        }
    }
}


function userName_exits($userName, $conn)
{ 
    $prepared_stmtForUserNameValidation = $conn->prepare('SELECT * FROM useraccounts WHERE username = ?');
    $prepared_stmtForUserNameValidation->bind_param("s", $userName1);
    $userName1 = $userName;
    $prepared_stmtForUserNameValidation->execute();
    $prepared_stmtForUserNameValidation->store_result();

    if ($prepared_stmtForUserNameValidation->num_rows()==0) {
        $prepared_stmtForUserNameValidation->close();
        return true;
    } else {
        $prepared_stmtForUserNameValidation->close();
        return false;
    }
}