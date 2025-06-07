<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require DRIVE_PATH . "email/phpmailer/src/Exception.php";
require DRIVE_PATH . "email/phpmailer/src/PHPMailer.php";
require DRIVE_PATH . "email/phpmailer/src/SMTP.php";


$html = "";
$prevExp = 0;
$currExp = 0;
$save = 0;
$monExp = 0;
$income = 0;
$highCat = ["Food", "Transport", "Housing", "Entertainment", "Utilities", "Health", "Other"];
$highSpend = [0, 0, 0, 0, 0, 0, 0];



function createTable($email)
{
    global $html, $conn, $prevExp, $income, $currExp, $highCat, $highSpend, $monExp, $save;

    $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON income.incomeId=expenses.incomeId WHERE MONTH(expenses.date)=" . date("m", strtotime("-2 month")) . " AND YEAR(expenses.date)=" . date("Y", strtotime("-1 month")) . " AND expenses.email='$email' ORDER BY expenses.date");
    $sel->execute();
    $sel = $sel->fetchAll();

    foreach ($sel as $r) {
        $prevExp += $r["expense"];
    }


    $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON income.incomeId=expenses.incomeId WHERE MONTH(expenses.date)=" . date("m", strtotime("-1 month")) . " AND YEAR(expenses.date)=" . date("Y", strtotime("-1 month")) . " AND expenses.email='$email' ORDER BY expenses.date");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (!isset($sel[0])) return false;

    $income = (isset($sel[0])) ? $sel[0]["income"] : 0;

    $html .= "<table id='expenseTable'>
    <thead>
        <tr>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>SR.</th>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>Name</th>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>Category</th>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>Date</th>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>Description</th>
            <th style='color: black;border: 1px solid #d9d9d9;padding: 1rem 0.8rem;'>Amount</th>
        </tr>
    </thead>
    <tbody>";


    foreach ($sel as $i => $r) {
        $currExp += $r["expense"];

        $highSpend[array_search((strtoupper($r["type"][0]) . substr($r["type"], 1)), $highCat)] += $r["expense"];

        $html .= "<tr>
                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;'>" . ($i + 1) . ")</td>

                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;'>" . $r["name"] . "</td>

                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;'>" . strtoupper($r["type"][0]) . substr($r["type"], 1) . "</td>

                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;'>" . date("d / m / Y", strtotime($r["date"])) . "</td>
                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;'>" . $r["description"] . "</td>

                <td style='color: rgba(0, 0, 0, 0.8);border: 1px solid #d9d9d9;padding: 0.4rem 0.8rem;text-align: center;'>₹" . $r["expense"] . "</td>
            </tr>";
        $monExp += $r["expense"];

        if ($i == sizeof($sel) - 1) {
            $html .= "<tr>
                    <th colspan='5' style='border: 1px solid #d9d9d9;padding: 1rem 0.8rem;color: maroon;text-align:center;'>Subtotal ( Income - ₹$income )</th>
                    <th colspan='2' style='border: 1px solid #d9d9d9;padding: 1rem 0.8rem;color: " . (($monExp >= $income) ? "#ff4d4d" : "#00b300") . ";'>₹$monExp</th>
                </tr>";
        }
    }

    $save = $prevExp - $currExp;

    $html .= "</tbody>
</table>";

    return true;
}



$users = $conn->prepare("SELECT * FROM `users`");
$users->execute();
$users = $users->fetchAll();

foreach ($users as $user) {
    if (!isset($_COOKIE["monthExpEmail"]) && $user["monExpEmail"] == 0) {
        if (createTable($user["email"])) {

            //! Send Email
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "dainikmakwana31@gmail.com";
            $mail->Password = "kjhc tkbb hzcn ciep";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setFrom("dainikmakwana31@gmail.com");
            $mail->addAddress($user["email"]);

            $mail->isHTML(true);
            $mail->Subject = "Track Your Monthly Expenses";

            $msg = "<br/>Hi " . $user["name"] . ",
            <br/><h4>Here's a summary of your expenses for " . date("M Y", strtotime("-1 month")) . ":</h4>
            Total Income: ₹$income
            <br/>Total Expenses: ₹$monExp
            <br/>Budget Remaining: ₹" . ($income - $monExp) . "

            <br/><h4>Breakdown by Category:</h4>
            $html

            <br/><h4>Highlights:</h4>
            Highest spending category: [" . $highCat[array_search(max($highSpend), $highSpend)] . "] [₹" . max($highSpend) . "]

            <br/>You saved <span style='color: " . (($currExp >= $prevExp) ? "#ff4d4d" : "#00b300") . ";'>" . round((($save * 100) / max($currExp, $prevExp)), 2) . "%</span> ( " . (($save < 0) ? (substr($save, 0, 1) . "₹" . substr($save, 1)) : ("₹$save")) . " ) compared to last month! [Prev. Exp.: ₹$prevExp, Curr. Exp.: ₹$currExp]

            <br/><br/>View Detailed Report on CashFlow Website
            <br/>Need help analyzing your spending or adjusting your budget? Let us know!

            <br/><br/>Happy Tracking,
            <br/>Team of CashFlow
            <br/>CashFlow
            <br/>cashflow123@gmail.com";

            $mail->Body = $msg;
            $mail->send();

            $setEmailSent = $conn->prepare("UPDATE `users` SET `monExpEmail`=1 WHERE `email`='" . $user["email"] . "'");
            $setEmailSent->execute();

            if ((int)date("d") == 2)
                setcookie("monthExpEmail", "", time() + (28 * 24 * 60 * 60), "/");
            else
                setcookie("monthExpEmail", "", time() + (30 * 24 * 60 * 60), "/");
        }
    }
    //
    else if (isset($_COOKIE["monthExpEmail"]) && $user["monExpEmail"] == 1) {
        $setEmailSent = $conn->prepare("UPDATE `users` SET `monExpEmail`=1");
        $setEmailSent->execute();
    }
}
