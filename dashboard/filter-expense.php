<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");

$_SESSION["year"] = $_POST["year"];
?>

<h3 style="text-align: center;color: maroon;padding-bottom: 1.5rem;">Year ( <?php echo $_SESSION["year"]; ?> )</h3>

<table id="expenseTable" data-year="<?php echo $_SESSION["year"]; ?>">
    <thead>
        <tr>
            <th>Month</th>
            <th>Name</th>
            <th>Category</th>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON income.incomeId=expenses.incomeId WHERE YEAR(expenses.date)=" . $_SESSION["year"] . " AND expenses.email='" . $_COOKIE["email"] . "' ORDER BY expenses.date");
        $sel->execute();
        $sel = $sel->fetchAll();

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
            } ?>

            <tr style="background-color: <?php echo $color; ?>;">
                <td style='<?php echo ($currMonth != $nextMonth || $i + 1 == sizeof(($sel))) ? "border-bottom: 1px solid #e2e8f0;" : "border-bottom: none;"; ?>font-size: 0.9rem;color: maroon;'>
                    <?php if ($currMonth != $prevMonth) {
                        echo $currMonth;
                    } ?>
                </td>

                <!-- //! All Data -->
                <td style="display: none;" class="expense-id" data-text="<?php echo $r["expenseId"]; ?>"></td>

                <td style="border-left: 1px solid #e2e8f0;" class="name" data-text="<?php echo $r["name"]; ?>"><?php echo $r["name"]; ?></td>

                <td class="type" data-text="<?php echo $r["type"]; ?>"><span class="category-badge <?php echo $r["type"]; ?>"><?php echo $r["type"]; ?></span></td>

                <td class="date" data-text="<?php echo date("Y-m-d", strtotime($r["date"])); ?>">
                    <?php echo date("M d, Y", strtotime($r["date"])); ?>
                </td>
                <td class="description" data-text="<?php echo $r["description"]; ?>"><?php echo $r["description"]; ?></td>

                <td class="expense" data-text="<?php echo $r["expense"]; ?>">&#8377;<?php echo $r["expense"]; ?></td>
                <td class="actions-cell">
                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                </td>
            </tr>

            <?php if ($currMonth != $nextMonth || $i + 1 == sizeof(($sel))) { ?>
                <tr style="background-color: <?php echo $color; ?>;">
                    <td></td>
                    <td colspan="4" style="color: maroon;text-align:center;">[ <?php echo date("M Y", strtotime($r["date"])); ?> ]&ensp;Subtotal ( Income - ₹<?php echo $r["income"]; ?> )</td>
                    <td colspan="2" style="color: maroon;">₹<?php echo $monExp; ?></td>
                </tr>
            <?php
                $monExp = 0;
                $yearIn += $r["income"];
                $color = ($color == "white") ? "#e6ffe6" : "white";
            } ?>

            <?php if ($i + 1 == sizeof($sel)) { ?>
                <tr>
                    <td colspan="5" class="total">[ <?php echo $_SESSION["year"]; ?> ]&ensp;Total of Year ( Income - ₹<?php echo $yearIn; ?> )</td>
                    <td colspan="2">₹<?php echo $yearExp; ?></td>
                </tr>
        <?php $yearExp = 0;
            }

            $prevMonth = date("M", strtotime($r["date"]));
        } ?>
    </tbody>
</table>