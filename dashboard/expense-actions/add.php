<?php include("C:/xampp/htdocs/php/CashFlow/config.php");

$mon = date("m Y", strtotime($_POST["date"]));

$expense = $conn->prepare("SELECT * FROM `expenses` WHERE `monthYear`='$mon' AND `email`='" . $_SESSION["email"] . "'");
$expense->execute();
$expense = $expense->fetchAll();
$totalExp = 0;

if (isset($expense[0])) {
    foreach ($expense as $ex) {
        if ($ex["expenseId"] != $_POST["expenseId"]) $totalExp += $ex["expense"];
    }
}
$totalExp += $_POST["expense"];


$income = $conn->prepare("SELECT * FROM `income` WHERE `monthYear`='$mon' AND `email`='" . $_SESSION["email"] . "'");
$income->execute();
$income = $income->fetchAll();

if (!isset($income[0])) {
    $_SESSION["error"] = "Please! Insert your Income first, then we can deduct your expenses";
    $_SESSION["add-income"] = $mon;
}
//
else if ($totalExp > $income[0]["income"]) {
    $_SESSION["error"] = date("M Y", strtotime($_POST["date"])) . " - Insufficient Income(₹" . $income[0]["income"] . ") - Expense(₹$totalExp)";
}
//
else {
    $in = $conn->prepare("INSERT INTO `expenses` VALUES(0, " . $income[0]["incomeId"] . ", '" . $_SESSION["email"] . "', '" . $_SESSION["name"] . "', '" . $_POST["type"] . "', " . $_POST["expense"] . ", '" . date("Y-m-d", strtotime($_POST["date"])) . " 00:00:00', " . date("Y", strtotime($_POST["date"])) . ", '" . date("m Y", strtotime($_POST["date"])) . "', '" . $_POST["description"] . "')");

    $in->execute();

    $_SESSION["success"] = "Expense Inserted Successfully";
}

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
