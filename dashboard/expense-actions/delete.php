<?php
$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");

$del = $conn->prepare("DELETE FROM `expenses` WHERE `expenseId`=" . $_POST["expenseId"] . "");
$del->execute();