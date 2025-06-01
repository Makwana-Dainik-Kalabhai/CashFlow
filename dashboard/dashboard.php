<?php include("C:/xampp/htdocs/php/CashFlow/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow - Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Overview Cards */
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


        /* Expense Table */
        .expense-table-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .table-actions {
            display: flex;
            gap: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: var(--secondary);
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #e2e8f0;
        }

        .food {
            background: #fef3c7;
            color: #92400e;
        }

        .transport {
            background: #dbeafe;
            color: #1e40af;
        }

        .housing {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .entertainment {
            background: #fce7f3;
            color: #9d174d;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .overview-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .overview-cards {
                grid-template-columns: 1fr;
            }

            .table-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes flipInY {
            from {
                transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
                opacity: 0;
            }

            40% {
                transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
            }

            60% {
                transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
            }

            80% {
                transform: perspective(400px) rotate3d(0, 1, 0, -5deg);
            }

            to {
                transform: perspective(400px);
                opacity: 1;
            }
        }

        @keyframes growIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .flip-animation {
            animation: flipInY 0.7s ease-out forwards;
        }

        .grow-animation {
            animation: growIn 0.5s ease-out forwards;
        }

        /* Particle.js container */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 200px;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>
</head>


<?php

//! For Previous Month
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y", strtotime("-1 months")) . "' AND expenses.email='" . $_SESSION["email"] . "'");
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
$sel = $conn->prepare("SELECT * FROM `income` JOIN `expenses` ON income.monthYear=expenses.monthYear WHERE expenses.monthYear='" . date("m Y") . "' AND expenses.email='" . $_SESSION["email"] . "'");
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

<body>
    <!-- Sidebar -->
    <?php include(DRIVE_PATH . "dashboard/sidebar.php"); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div id="particles-js"></div>

        <div class="header">
            <h1>Expense Dashboard</h1>
            <div class="user-profile">
                <span><?php echo $_SESSION["name"]; ?></span>
                <h2 class="user-avatar"><?php echo $_SESSION["name"][0]; ?></h2>
            </div>
        </div>

        <div class="header-filter" style="padding: 1rem 0;">
            <?php
            $year = date("Y");
            //! Provide Months for filter
            $months = $conn->prepare("SELECT * FROM `expenses` WHERE `year`=$year GROUP BY MONTH(date) ORDER BY MONTH(date)");
            $months->execute();
            $months = $months->fetchAll();

            foreach ($months as $i => $m) { ?>
                <button class="<?php if (date("m") == date("m", strtotime($m["date"]))) echo "active"; ?>" value="<?php echo date("m", strtotime($m["date"])); ?>">
                    <h4><?php echo date("M", strtotime($m["date"])); ?></h4>
                </button>
            <?php } ?>
        </div>


        <div class="filter-dashboard">
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
                    <h3 class="table-title">Recent Transactions (<?php echo date("M Y"); ?>)</h3>
                    <div class="table-actions">
                        <button class="btn btn-primary" id="addExpenseBtn">
                            <i class="fas fa-plus"></i> Add Expense
                        </button>

                        <a href="<?php echo HTTP_PATH . "dashboard/expense-table.php?active=expenses"; ?>" class="btn btn-outline"><i class="fa-solid fa-list"></i> All Transactions</a>
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
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $(".header-filter button").click(function() {
                $(".header-filter button").removeClass("active");
                $(this).addClass("active");

                $.ajax({
                    type: "POST",
                    url: "<?php echo HTTP_PATH . "dashboard/filter-dashboard.php"; ?>",
                    data: {
                        month: $(this).val(),
                    },
                    success: function(res) {
                        $(".filter-dashboard").html(res);
                    }
                });
            });
        });
    </script>
</body>

</html>