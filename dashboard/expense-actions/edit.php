<?php include("C:/xampp/htdocs/php/CashFlow/config.php");

if (isset($_POST["edit"])) {
    $mon = date("m Y", strtotime($_POST["date"]));

    $expense = $conn->prepare("SELECT * FROM `expenses` WHERE `expenseId`!=".$_POST["expenseId"]." AND `monthYear`='$mon' AND `email`='" . $_COOKIE["email"] . "'");
    $expense->execute();
    $expense = $expense->fetchAll();
    $totalExp = 0;

    if (isset($expense[0])) {
        foreach ($expense as $ex) {
            $totalExp += $ex["expense"];
        }
    }
    $totalExp += $_POST["expense"];


    $income = $conn->prepare("SELECT * FROM `income` WHERE `monthYear`='$mon' AND `email`='" . $_COOKIE["email"] . "'");
    $income->execute();
    $income = $income->fetchAll();

    if (!isset($income[0])) {
        $_SESSION["error"] = "Please! Insert your Income first, then we can deduct your expenses";
        $_SESSION["add-income"] = $mon;
    }
    //
    else if ($totalExp > $income[0]["income"]) {
        $_SESSION["error"] = date("M Y", strtotime($_POST["date"]))." - Insufficient Income(₹" . $income[0]["income"] . ") - Expense(₹$totalExp)";
    }
    //
    else {
        $up = $conn->prepare("UPDATE `expenses` SET `incomeId`=" . $income[0]["incomeId"] . ", `name`='" . $_POST["name"] . "', `type`='" . $_POST["type"] . "', `expense`='" . $_POST["expense"] . "', `date`='" . date("Y-m-d", strtotime($_POST["date"])) . " 00:00:00', `year`=" . date("Y", strtotime($_POST["date"])) . ", `monthYear`='$mon',`description`='" . $_POST["description"] . "' WHERE `expenseId`=" . $_POST["expenseId"] . "");
        $up->execute();
    }
    //
}

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
