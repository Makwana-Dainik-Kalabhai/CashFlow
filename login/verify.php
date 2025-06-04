<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");

$sel = $conn->prepare("SELECT * FROM `users` WHERE `name`='" . $_POST["email"] . "' OR `email`='" . $_POST["email"] . "'");
$sel->execute();
$sel = $sel->fetchAll();

if (isset($sel[0])) {

    foreach ($sel as $r) {
        if ($r["password"] == $_POST["password"]) {
            setcookie("name", $r["name"], time() + (10 * 24 * 60 * 60), "/");
            setcookie("email", $r["email"], time() + (10 * 24 * 60 * 60), "/");

            header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
            return;
        }
    }
}
//
else {
    $in = $conn->prepare("INSERT INTO `users` VALUES('" . $_POST["name"] . "', '" . $_POST["email"] . "', '" . $_POST["password"] . "')");
    $in->execute();

    setcookie("name", $_POST["name"], time() + (10 * 24 * 60 * 60), "/");
    setcookie("email", $_POST["email"], time() + (10 * 24 * 60 * 60), "/");

    header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
}
