<?php
session_start();

if (isset($_COOKIE["otp"])) setcookie("otp", "", time() - 10, "/");
if (isset($_COOKIE["setPass"])) setcookie("setPass", "", time() - 10, "/");

define("HTTP_PATH", "http://localhost/php/CashFlow/");
define("DRIVE_PATH", "C:/xampp/htdocs/php/CashFlow/");

$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");
?>

<link rel="shortcut icon" href="<?php echo HTTP_PATH."logo.ico"; ?>" type="image/x-icon" />

<!-- //! Link Tags -->
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<!-- //! Script Tags -->
<!-- jQuery Link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>