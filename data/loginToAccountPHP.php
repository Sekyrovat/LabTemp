<?php

header('Accept: application/json');
header('Content-type: application/json');

require('connect.php');

$user = $_POST['userName'];

if(userName_exits($user, $conn))
{
    header('HTTP/1.1 409 Invalid credentials.');
    die("Invalid credentials provided.");
}
else
{
    $userPassword = $_POST['userPassword'];

    $query = "SELECT userPwd, userId 
                FROM useraccounts 
                WHERE username = ? AND userPwd = ?";

    $prepared_stmt = $conn -> prepare($query);

    $prepared_stmt -> bind_param( 'ss' ,$user, $userPassword );

    if (!$prepared_stmt -> execute()) 
    {
        header('HTTP/1.1 500 Bad connection. Something happened while saving your data, please try again later');
        die("Error: " . $query . "\n" . mysqli_error($conn));
    }
    else 
    {
        $prepared_stmt -> store_result();
        $prepared_stmt -> bind_result($pwd, $unId);
        $prepared_stmt -> fetch();

        if ($pwd === $userPassword) 
        {
            session_start();
            $_SESSION['userId'] = $unId;

            $response = array("status" => "success");
            /* free results */
            /* close statement */
            $prepared_stmt -> free_result();
            $prepared_stmt -> close();
            echo json_encode($response);
        } 
        else 
        {
            /* free results */
            /* close statement */
            $prepared_stmt -> free_result();
            $prepared_stmt -> close();
            header('HTTP/1.1 409 Conflict, invalid user password combination.');
            die("Invalid user password combination.");
        }
    }
}


function userName_exits($userName, $conn)
{ 
    $prepared_stmtForUserNameValidation = $conn -> prepare('SELECT * FROM useraccounts WHERE username = ?');
    $prepared_stmtForUserNameValidation -> bind_param('s' , $userName);

    $prepared_stmtForUserNameValidation -> execute();
    $prepared_stmtForUserNameValidation -> store_result();

    if ($prepared_stmtForUserNameValidation -> num_rows() === 0) {
        $prepared_stmtForUserNameValidation -> close();
        return true;
    } else {
        $prepared_stmtForUserNameValidation -> close();
        return false;
    }
}