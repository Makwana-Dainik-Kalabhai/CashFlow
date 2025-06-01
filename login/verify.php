<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");

$sel = $conn->prepare("SELECT * FROM `users` WHERE `email`='" . $_POST["email"] . "' AND `password`='" . $_POST["password"] . "'");
$sel->execute();
$sel = $sel->fetchAll();

if (isset($sel[0]["email"])) {
    $_SESSION["name"] = $sel[0]["name"];
    $_SESSION["email"] = $sel[0]["email"];

    header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
}
//
else {
    $_SESSION["error"] = "Invalid Email ID or Password";
    
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
