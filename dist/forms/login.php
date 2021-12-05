<?php

function function_alert($message) { 
    echo "<script>alert('$message');</script>";
}

if (isset($_POST['submit'])) {
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        function_alert("Please Fill In All Fields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            function_alert("SqlError");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $passCheck = password_verify($password, $row['password']);
                if ($passCheck == false) {
                    function_alert("Wrong Password!");
                    exit();
                } elseif ($passCheck == true) {
                    session_start();
                    $_SESSION['sessionId'] = $row['id'];
                    $_SESSION['sessionUser'] = $row['username'];
                    header("Location: ../home.html");
                    exit();
                } else {
                    function_alert("Wrong Password!");
                    exit();
                }
            } else {
                function_alert("No User!");
                exit();
            }
        }
    }
} else {
    function_alert("Access Forbidden!");
    exit();
}

?>