<?php

header('Accept: application/json');
header('Content-type: application/json');

require('connect.php');

if ($conn->connect_error) 
{
    header('HTTP/1.1 500 Bad connection to Database');
    die("The server is down, we couldn't establish the DB connection");
}
else
{
    $userEmail = $_POST['userEmail'];
    $userName = $_POST['userName'];

    if(userEmail_exits($userEmail, $conn))
    {
        header('HTTP/1.1 409 Conflict, Email already in use.');
        die("Email already in use.");
    }
    elseif (userName_exits($userName, $conn)) 
    {
        header('HTTP/1.1 409 Conflict, Username already in use please select another one.');
        die("Username already in use.");
    }
    else
    {
        $userPassword = $_POST['userPassword'];

        $query = "INSERT INTO useraccounts (username, userFiName, userLaName, userEmail, userPwd, userGender, userCountry) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $prepared_stmt = $conn->prepare($query);
        $prepared_stmt->bind_param("sssssss", $uName,$fName, $lName,$uEmail, $uPassword, $uGender, $userCountry);

        $uName = $userName;
        $fName = $_POST['userFirstName'];
        $lName = $_POST['userLastName'];
        $uEmail = $userEmail;
        $uPassword = $userPassword;
        $uGender = $_POST['userGender'];
        $userCountry = $_POST['userCountry'];

        if ($prepared_stmt->execute()) 
        {
            $response = array("status" => "success");
            echo json_encode($response);
        } 
        else 
        {
            header('HTTP/1.1 500 Bad connection, something went wrong while saving your data, please try again later');
            die("Error: " . mysqli_error($conn));
        }
    }
}

/**
 * Check if a user with given e-mail exists.
 *
 * @param String $email
 *  The e-mail to id the user.
 *
 * @return Boolean
 *  True -> User exists.
 *  False -> User does not exists.
 */

function userEmail_exits($email, $conn)
{
    $prepared_stmtForEmailValidation = $conn->prepare('SELECT * FROM useraccounts WHERE userEmail = ?');
    $prepared_stmtForEmailValidation->bind_param("s", $email1);
    $email1 = $email;
    $prepared_stmtForEmailValidation->execute();
    $prepared_stmtForEmailValidation->store_result();
    
    if ($prepared_stmtForEmailValidation->num_rows()==0) {
        $prepared_stmtForEmailValidation->close();
        return false;
    } else {
        $prepared_stmtForEmailValidation->close();
        return true;
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
        return false;
    } else {
        $prepared_stmtForUserNameValidation->close();
        return true;
    }
}