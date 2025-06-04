<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");
if (isset($_GET["year"])) $_SESSION["year"] = $_GET["year"];


$firstYear = $conn->prepare("SELECT * FROM `expenses` WHERE `email`='" . $_COOKIE["email"] . "' ORDER BY YEAR(date)");
$firstYear->execute();
$firstYear = $firstYear->fetchAll();
$firstYear = date("Y", strtotime($firstYear[0]["date"]));

$html = "";

$html .= "<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Download Now</title>
    <link rel='stylesheet' href='http://localhost/php/IFS/css/bootstrap.min.css' type='text/css'>
</head>

<style>
    .logo {
        position: absolute;
        right: -5%;
        bottom: -3%;
        width: 11%;
        z-index: -1;
    }

    h3 {
        font-size: 0.9rem;
        text-align: center;
        color: maroon;
        padding-bottom: 1rem;
        text-decoration: underline;
    }
    table {
        width: 100%;
        margin-bottom: 5rem;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 0.75rem 1rem;
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--secondary);
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        font-size: 0.65rem;
        padding: 0.6rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        line-height: 1;
    }
    .total {
        font-size: 0.77rem;
        text-align: center;
        color: #53ab3b;
        background-color: #f8fafc;
        border-bottom: 1px solid gray;
    }
        
    .total+td {
        font-size: 0.74rem;
        border-bottom: 1px solid gray;
        color: white;
        background-color: #53ab3b;
    }
</style>

<body>
    <img src='" . HTTP_PATH . "logo.png' class='logo' />";

$start = ((isset($_SESSION["year"]) && $_SESSION["year"] != "all") ? $_SESSION["year"] : $firstYear);
$end = ((isset($_SESSION["year"]) && $_SESSION["year"] != "all") ? $_SESSION["year"] : date("Y"));

for ($j = $start; $j <= $end; $j++) {

    $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON income.incomeId=expenses.incomeId WHERE YEAR(expenses.date)=$j AND expenses.email='" . $_COOKIE["email"] . "' ORDER BY expenses.date");
    $sel->execute();
    $sel = $sel->fetchAll();

    if (isset($sel[0]) && date("Y", strtotime($sel[0]["date"])) == $j) {

        $html .= "<h3>Year ( $j )</h3>

                        <table>
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>";

        $prevMonth = "";
        $currMonth = "";
        $nextMonth = "";
        $monExp = 0;
        $yearExp = 0;
        $yearIn = 0;
        $color = "white";

        foreach ($sel as $i => $r) {
            $monExp += $r["expense"];
            $yearExp += $r["expense"];

            $currMonth = date("M", strtotime($r["date"]));

            if ($i + 1 < sizeof($sel)) {
                $nextMonth = date("M", strtotime($sel[$i + 1]["date"]));
            }

            $html .= "<tr style='background-color: $color;'>
                <td style='" . ((($currMonth != $nextMonth) || ($i + 1 == sizeof($sel))) ? "border-bottom: 1px solid #e2e8f0;" : "border-bottom: none;") . "font-size: 0.75rem;color: maroon;'>";

            if ($currMonth != $prevMonth) {
                $html .= $currMonth;
            }

            $html .= "</td>

                <td style='border-left: 1px solid #e2e8f0;'>" . $r["name"] . "</td>
                <td>" . $r["type"] . "</td>
                <td>" . date("M d, Y", strtotime($r["date"])) . "</td>
                <td>" . $r["description"] . "</td>

                <td>&#8377;" . $r["expense"] . "</td>
            </tr>";

            if ($currMonth != $nextMonth || $i + 1 == sizeof(($sel))) {
                $html .= "<tr style='background-color: $color;'>
                                            <td></td>
                                            <td colspan='4' style='color: maroon;text-align:center;'>[ " . date("M Y", strtotime($r["date"])) . " ]&ensp;Subtotal ( Income - ₹" . $r["income"] . " )</td>
                                            <td colspan='2' style='color: maroon;'>₹$monExp</td>
                                        </tr>";

                $monExp = 0;
                $yearIn += $r["income"];
                $color = ($color == "white") ? "#e6ffe6" : "white";
            }


            if ($i + 1 == sizeof($sel)) {
                $html .= "<tr>
                                            <td colspan='5' class='total'>[ $j ]&ensp;Total of Year ( Income - ₹$yearIn )</td>
                                            <td colspan='2'>₹$yearExp</td>
                                        </tr>";
                $yearExp = 0;
            }

            $prevMonth = date("M", strtotime($r["date"]));
        }
        $html .= "</tbody>
        </table>";
    }
}
$html .= "</body>

</html>";
