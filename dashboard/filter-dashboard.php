<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");


$currMon = date("m") - $_POST["month"];
$prevMon = $currMon + 1;


//! For Previous Month
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y", strtotime("-$prevMon months")) . "' AND expenses.email='" . $_SESSION["email"] . "'");
$sel->execute();
$sel = $sel->fetchAll();

$prevIncome = 0;
$prevExpense = 0;
$prevRemainingBal = 0;
$prevSave = 0;
$prevSaveRate = 0;

if (isset($sel[0])) {
    $prevIncome = $sel[0]["income"];

    foreach ($sel as $r)
        $prevExpense += $r["expense"];

    $prevRemainingBal = $prevIncome - $prevExpense;
    $prevSave = $prevRemainingBal;
    $prevSaveRate = round(($prevRemainingBal * 100) / $prevIncome, 2);
}


//! For Current Month
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y", strtotime("-$currMon months")) . "' AND expenses.email='" . $_SESSION["email"] . "'");
$sel->execute();
$sel = $sel->fetchAll();

$currIncome = 0;
$currExpense = 0;
$incomeFromPrev = 0;
$expenseFromPrev = 0;
$currRemainingBal = 0;
$currSave = 0;
$currSaveRate = 0;
$saveImprove = 0;

if (isset($sel[0])) {
    $currIncome = $sel[0]["income"];

    foreach ($sel as $r)
        $currExpense += $r["expense"];

    $incomeFromPrev = round(($currIncome - $prevIncome) / 100, 2);
    $currRemainingBal = $currIncome - $currExpense;

    $currSave = $currRemainingBal - $prevRemainingBal;
    $currSaveRate = round(($currRemainingBal * 100) / $currIncome, 2);
    
    $expenseFromPrev = round(((100-$currSaveRate)-(100-$prevSaveRate)), 2);

    $saveImprove = -$expenseFromPrev;
} else {
    $_SESSION["add-income"] = date("m Y");
}
?>

<!-- Overview Cards -->
<div class="overview-cards">
    <div class="card income flip-animation" style="animation-delay: 0.1s">
        <div class="card-header">
            <div>
                <div class="card-title">Total Income</div>
                <div class="card-value">&#8377;<?php echo $currIncome; ?></div>
                <div class="card-change <?php echo ($incomeFromPrev <= 0) ? "down" : "up"; ?>" style="color: var(<?php echo ($incomeFromPrev <= 0) ? "--danger" : "--success"; ?>);">
                    <?php if ($incomeFromPrev != 0) { ?><i class="fas fa-arrow-<?php echo ($incomeFromPrev < 0) ? "down" : "up"; ?>"></i><?php } ?>

                    &nbsp;<?php if ($incomeFromPrev == 0) echo "Equals to last Month";
                            else echo (($incomeFromPrev < 0) ? substr($incomeFromPrev, 1) : $incomeFromPrev) . "% from last month"; ?>
                </div>
            </div>
            <div class="card-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="card expense flip-animation" style="animation-delay: 0.2s">
        <div class="card-header">
            <div>
                <div class="card-title">Total Expenses</div>
                <div class="card-value">&#8377;<?php echo $currExpense; ?></div>
                <div class="card-change <?php echo ($expenseFromPrev <= 0) ? "down" : "up"; ?>" style="color: var(<?php echo ($expenseFromPrev <= 0) ? "--danger" : "--success"; ?>);">
                    <?php if ($expenseFromPrev != 0) { ?><i class="fas fa-arrow-<?php echo ($expenseFromPrev < 0) ? "down" : "up"; ?>"></i><?php } ?>

                    &nbsp;<?php if ($expenseFromPrev == 0) echo "Equals to last Month";
                            else echo (($expenseFromPrev < 0) ? substr($expenseFromPrev, 1) : $expenseFromPrev) . "% from last month"; ?>
                </div>
            </div>
            <div class="card-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>

    <div class="card balance flip-animation" style="animation-delay: 0.3s">
        <div class="card-header">
            <div>
                <div class="card-title">Remaining Balance</div>
                <div class="card-value">&#8377;<?php echo $currRemainingBal; ?></div>
                <div class="card-change <?php echo ($currSave < 0) ? "down" : "up"; ?>" style="color: var(<?php echo ($currSave <= 0) ? "--danger" : "--success"; ?>);">
                    <?php if ($currSave != 0) { ?><i class=" fas fa-arrow-<?php echo ($currSave < 0) ? "down" : "up"; ?>"></i><?php } ?>

                    &nbsp;&#8377;<?php echo ($currSave < 0) ? substr($currSave, 1) : $currSave; ?> saved from last month
                </div>
            </div>
            <div class="card-icon">
                <i class="fas fa-piggy-bank"></i>
            </div>
        </div>
    </div>

    <div class="card savings flip-animation" style="animation-delay: 0.4s">
        <div class="card-header">
            <div>
                <div class="card-title">Savings Rate</div>
                <div class="card-value"><?php echo $currSaveRate; ?>%</div>
                <div class="card-change <?php echo ($saveImprove > 0) ? "up" : "down"; ?>">
                    <?php if ($saveImprove != 0) { ?><i class="fas fa-arrow-<?php echo ($saveImprove < 0) ? "down" : "up"; ?>"></i><?php } ?>

                    &nbsp;<?php echo ($saveImprove < 0) ? substr($saveImprove, 1) : $saveImprove; ?>% Improvement
                </div>
            </div>
            <div class="radial-progress">
                <span class="progress-value">-<?php echo ($currSaveRate < 0) ? substr($currSaveRate, 1) : 100 - $currSaveRate; ?>%</span>
            </div>
        </div>
    </div>
</div>





<!-- Expense Table -->
<div class="expense-table-container grow-animation" style="animation-delay: 0.9s">
    <div class="table-header">
        <h3 class="table-title">Recent Transactions (<?php echo date("M Y", strtotime("-1 months")); ?>)</h3>
        <div class="table-actions">
            <button class="btn btn-primary" id="addExpenseBtn">
                <i class="fas fa-plus"></i> Add Expense
            </button>

            <a href="http://localhost/php/CashFlow/dashboard/expense-table.php?active=expenses" class="btn btn-outline"><i class="fa-solid fa-list"></i> All Transactions</a>
        </div>
    </div>
    <div class="table-responsive">
        <table id="expenseTable">
            <thead>
                <tr>
                    <th>SR.</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sel as $i => $r) { ?>
                    <tr>
                        <td><?php echo $i + 1; ?>)</td>
                        <td><?php echo $r["name"]; ?></td>
                        <td><span class="category-badge <?php echo $r["type"]; ?>"><?php echo $r["type"]; ?></span></td>
                        <td>&#8377;<?php echo $r["expense"]; ?></td>
                        <td><?php echo date("M d, Y", strtotime($r["date"])); ?></td>
                        <td><?php echo $r["description"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>