<?php
include("C:/xampp/htdocs/php/CashFlow/config.php");

$sel = $conn->prepare("SELECT * FROM `expenses` WHERE `email`='" . $_SESSION["email"] . "' ORDER BY date");
$sel->execute();
$sel = $sel->fetchAll();

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
        font-size: 0.95rem;
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
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--secondary);
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        font-size: 0.7rem;
        padding: 1rem 0.5rem;
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

for ($j = 2023; $j <= date("Y"); $j++) {
    $sel = $conn->prepare("SELECT * FROM `expenses` WHERE YEAR(date)=$j AND email='" . $_SESSION["email"] . "' ORDER BY date");
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
        $total = 0;

        foreach ($sel as $i => $r) {
            $total += $r["expense"];

            $currMonth = date("M", strtotime($r["date"]));

            if ($i + 1 < sizeof($sel)) {
                $nextMonth = date("M", strtotime($sel[$i + 1]["date"]));
            }

            $html .= "<tr>
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

            if ($i + 1 == sizeof($sel)) {
                $html .= "<tr>
                    <td colspan='5' class='total'>Total of Year ( $j )</td>
                    <td colspan='2'>₹$total</td>
                </tr>";
                $total = 0;
            }

            $prevMonth = date("M", strtotime($r["date"]));
        }
        $html .= "</tbody>
        </table>";
    }
}
$html .= "</body>

</html>";
