<?php
session_start();
unset($_SESSION["email"]);

header("Location: http://localhost/php/CashFlow/index.php");