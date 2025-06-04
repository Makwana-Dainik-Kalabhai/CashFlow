<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");
require DRIVE_PATH . "login/Oauth.php";

try {
    if (!isset($_GET['code'])) {
        throw new Exception('Authorization code missing');
    }

    // Fix: Ensure proper response handling
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token["access_token"]);

    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();


    $sel = $conn->prepare("SELECT * FROM `users` WHERE `email`='" . $userinfo["email"] . "'");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (isset($sel[0]["email"])) {
        setcookie("name", $userinfo["name"], time() + (10 * 24 * 60 * 60), "/");
        setcookie("email", $userinfo["email"], time() + (10 * 24 * 60 * 60), "/");

        $_SESSION["success"] = "Login Successfully";
        header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
        return;
    }

    $in = $conn->prepare("INSERT INTO `users` VALUES('" . $userinfo["name"] . "', '" . $userinfo["email"] . "', '')");
    $in->execute();

    if (empty($token)) {
        throw new Exception('Empty token received from Google');
    }
    header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
} catch (Exception $e) {
    error_log('Google Auth Error: ' . $e->getMessage());
    header('Location: login.php?error=auth_failed');
    exit();
}
