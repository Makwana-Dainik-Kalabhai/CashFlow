<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");
require_once 'vendor/autoload.php';

// Initialize Google Client
$client = new Google\Client();

// Set your credentials
$client->setClientId('789780569480-uaet6cqqc0e98k49416v13nvj2g7m1jr.apps.googleusercontent.com');
$client->setClientSecret('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');
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


    $sel = $conn->prepare("SELECT * FROM `users` WHERE `email`='" . $userinfo["email"] . "'");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (isset($sel[0]["email"])) {
        $_SESSION["name"] = $userinfo["name"];
        $_SESSION["email"] = $userinfo["email"];


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
