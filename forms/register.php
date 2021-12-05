<?php

function function_alert($message) { 
    echo "<script>alert('$message');</script>";
}

if (isset($_POST['submit'])) {
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];

    if ($username === '' || $password === '' || $confirmPass === '') {
        function_alert("Please enter all fields!");
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*/", $username)) {
        function_alert("Invalid Username!");
        exit();
    } else if ($password !== $confirmPass) {
        function_alert("Passwords do not match!");
        exit();
    }

    else {
        $sql = "SELECT username FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            function_alert("SqlError");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);
            header("Location: ../login.html");

            if ($rowCount > 0) {
                function_alert("Username Taken!");
                exit();
            } else {
                $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    function_alert("SqlError!");
                    exit();
                } else {
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPass);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

?>