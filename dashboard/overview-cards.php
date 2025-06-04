<style>
    .overview-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        z-index: -1;
        border-radius: 12px;
        border: 1px solid var(--glass-border);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .income .card-icon {
        background: var(--income-color);
    }

    .expense .card-icon {
        background: var(--expense-color);
    }

    .balance .card-icon {
        background: var(--primary-gradient);
    }

    .savings .card-icon {
        background: var(--savings-color);
    }

    .card-title {
        font-size: 0.875rem;
        color: gray;
        font-weight: 500;
    }

    .card-value {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0.5rem 0;
    }

    .positive {
        color: var(--positive-balance);
    }

    .negative {
        color: var(--negative-balance);
    }

    .card-change {
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .up {
        color: var(--positive-balance);
    }

    .down {
        color: var(--negative-balance);
    }

    /* Radial Progress Bar */
    .radial-progress {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .radial-progress::before {
        content: '';
        position: absolute;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: white;
    }

    .progress-value {
        position: relative;
        font-weight: 600;
        font-size: 1rem;
    }
</style>


<?php

//! For Previous Month
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y", strtotime("-1 months")) . "' AND expenses.email='" . $_COOKIE["email"] . "'");
$sel->execute();
$sel = $sel->fetchAll();

$prevIncome = 0;
$prevExpense = 0;

if (isset($sel[0])) {
    $prevIncome = $sel[0]["income"];

    foreach ($sel as $r)
        $prevExpense += $r["expense"];

    $prevRemainingBal = $prevIncome - $prevExpense;
    $prevSave = $prevRemainingBal;
    $prevSaveRate = round(($prevRemainingBal * 100) / $prevIncome, 2);
}


//! For Current Month
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y") . "' AND expenses.email='" . $_COOKIE["email"] . "'");
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

    $expenseFromPrev = round(((100 - $currSaveRate) - (100 - $prevSaveRate)), 2);

    $saveImprove = -$expenseFromPrev;
} else {
    $_SESSION["add-income"] = date("m Y");
}
?>


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
                    <i class=" fas fa-arrow-<?php echo ($currSave <= 0) ? "down" : "up"; ?>"></i>

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
                    <i class="fas fa-arrow-<?php echo ($saveImprove <= 0) ? "down" : "up"; ?>"></i>

                    &nbsp;<?php echo ($saveImprove <= 0) ? substr($saveImprove, 1) : $saveImprove; ?>% Improvement
                </div>
            </div>
            <div class="radial-progress">
                <span class="progress-value">-<?php echo ($currSaveRate < 0) ? substr($currSaveRate, 1) : 100 - $currSaveRate; ?>%</span>
            </div>
        </div>
    </div>
</div>