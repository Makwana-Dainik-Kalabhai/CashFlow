<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "phpmailer/src/Exception.php";
require "phpmailer/src/PHPMailer.php";
require "phpmailer/src/SMTP.php";


function welcomeMsg($name, $email)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "dainikmakwana31@gmail.com";
    $mail->Password = "kjhc tkbb hzcn ciep";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("dainikmakwana31@gmail.com");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Welcome to CashFlow - Start Tracking Your Expenses Effortlessly!";

    $msg = "<p>Hi&ensp;$name,</p>

    <p style='text-align: right;'>Welcome to CashFlow! 🎉 We're thrilled to have you on board. Now you can take control of your finances with ease—track expenses, set budgets, and gain insights into your spending habits — all in one place. Start managing your money smarter today</p>

    <img style='display: block;width: 15rem;margin: auto;' src='http://localhost/php/CashFlow/logo.png' alt='' /><br/><br/>

    <b style='line-height: 1.5;'><u>Here's how to get started:</u></b><br />
    <span style='line-height: 1.3;'>1) Add your first expense - Log your transactions in seconds.</span><br />
    <span style='line-height: 1.3;'>2) Set a budget - Stay on track with personalized spending limits.</span><br />
    <span style='line-height: 1.3;'>3) View reports - Analyze your spending patterns with intuitive charts.</span><br />

    <p>Need help? Check out our Website or reply to email. We're happy to assist!</p>

    <span style='float: right;'>Happy Tracking!</span>
    <br /><span style='float: right;'>Team of CashFlow</span>
    <br /><span style='float: right;'>CashFlow</span>
    <br /><span style='float: right;'>cashflow123@gmail.com</span>";

    $mail->Body = $msg;
    $mail->send();
}
