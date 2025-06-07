<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");
require DRIVE_PATH . "login/Oauth.php";
require_once 'vendor/autoload.php';

// Initialize Google Client
$client = new Google\Client();

// Set your credentials
$client->setClientId("789780569480-uaet6cqqc0e98k49416v13nvj2g7m1jr.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri('http://localhost/php/CashFlow/login/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

try {
    if (!isset($_GET['code'])) {
        throw new Exception('Authorization code missing');
    }

    // Fix: Ensure proper response handling
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token["access_token"]);

    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();

    if (isset($_SESSION["error"])) unset($_SESSION["error"]);   

    $sel = $conn->prepare("SELECT * FROM `users` WHERE `email`='" . $userinfo["email"] . "'");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (isset($sel[0])) {
        setcookie("name", $userinfo["name"], time() + (10 * 24 * 60 * 60), "/");
        setcookie("email", $userinfo["email"], time() + (10 * 24 * 60 * 60), "/");

        header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
        return;
    }

    if (empty($token)) {
        throw new Exception('Empty token received from Google');
    }

    $in = $conn->prepare("INSERT INTO `users` VALUES('" . $userinfo["name"] . "', '" . $userinfo["email"] . "', '', 0)");
    $in->execute();

    include(DRIVE_PATH . "email/welcome.php");
    welcomeMsg($userinfo["name"], $userinfo["email"]);

    setcookie("name", $userinfo["name"], time() + (10 * 24 * 60 * 60), "/");
    setcookie("email", $userinfo["email"], time() + (10 * 24 * 60 * 60), "/");

    header("Location: " . HTTP_PATH . "dashboard/dashboard.php");
}
//
catch (Exception $e) {
    error_log('Google Auth Error: ' . $e->getMessage());

    $_SESSION["error"] = "Something went wrong, Please! Try again later";

    header("Location: " . DRIVE_PATH . "index.php");
    exit();
}
