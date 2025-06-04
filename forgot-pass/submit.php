<?php
session_start();

define("DRIVE_PATH", "C:/xampp/htdocs/php/CashFlow/");

$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send an email
function send_email($name, $email)
{

    require DRIVE_PATH . "forgot-pass/phpmailer/src/Exception.php";
    require DRIVE_PATH . "forgot-pass/phpmailer/src/PHPMailer.php";
    require DRIVE_PATH . "forgot-pass/phpmailer/src/SMTP.php";

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
    $mail->Subject = "For One Time Password(OTP)";
    $otp = mt_rand(100000, 999999);


    $msg = "Hey! " . $name . ". Your One Time Password(OTP) is $otp. If you want to reset password, then paste it in forgot password form.";


    $mail->Body = $msg;

    if ($mail->send()) {
        setcookie("otp", $otp, time() + (10 * 60), "/");
    }
}


//! Check email exist or not
if (isset($_POST["type"]) && $_POST["type"] == "email") {

    $sel = $conn->prepare("SELECT * FROM `users` WHERE `email`='" . $_POST["email"] . "'");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (isset($sel[0])) {

        send_email($sel[0]["name"], $sel[0]["email"]);
        echo "true";
    }
    //
    else {
        echo "false";
    }
}


//! Verify OTP
if (isset($_POST["type"]) && $_POST["type"] == "otp") { ?>

    <script>
        setTimeout(() => {
            <?php
            if ($_POST["otp"] == $_COOKIE["otp"]) {
                echo "true";
                setcookie("otp", "", time() - 10, "/");
                setcookie("setPass", "true", time() + (10 * 60), "/");
            }
            //
            else echo "false"; ?>
        }, 2000);
    </script>
<?php }



//! Set New Password
if (isset($_POST["type"]) && $_POST["type"] == "password") { ?>

    <script>
        setTimeout(() => {
            <?php
            $up = $conn->prepare("UPDATE `users` SET `password`='" . $_POST["password"] . "' WHERE `email`='" . $_COOKIE["email"] . "'");
            $up->execute();

            if ($up->rowCount() > 0) {
                setcookie("setPass", "", time() - 10, "/");
                echo "true";
            }
            //
            else echo "false";
            ?>
        }, 2000);
    </script>

<?php }
