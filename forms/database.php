<?php

//Params to connect to a database
$dbHost = "https://daleroberts0712.github.io/account-login/";
$dbUser = "root";
$dbPass = "";
$dbName = "phpcourse";

//Connection to database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database connection failed!");
}

?>
