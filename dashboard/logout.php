<?php
setcookie("name", "", time()-1, "/");
setcookie("email", "", time()-1, "/");

header("Location: http://localhost/php/CashFlow/index.php");