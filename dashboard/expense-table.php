<?php include("C:/xampp/htdocs/php/CashFlow/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow - All Expenses</title>
</head>

<style>
    .main-content {
        width: 85% !important;
    }

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
        margin-bottom: 5rem;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: white;
        background: #79C963;
        border-bottom: 1px solid #e2e8f0;
    }

    /* #f8fafc */

    td {
        font-size: 0.9rem;
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
        background-color: #FFEEBA;
        color: maroon;
    }

    .transport {
        background-color: #B8E0FF;
        color: #005F8B;
    }

    .housing {
        background-color: #D1FFD7;
        color: #006D3A;
    }

    .utilities {
        background-color: #FFD1DC;
        color: #A11D54;
    }

    .entertainment {
        background-color: #E0D1FF;
        color: #4B0082;
    }

    .health {
        background-color: #FFD1D1;
        color: #8B0000;
    }

    .shopping {
        background-color: #FFC8A2;
        color: #A13D00;
    }

    .education {
        background-color: #C8A2FF;
        color: #4B0082;
    }

    .travel {
        background-color: #A2E3FF;
        color: #005F73;
    }

    .miscellaneous {
        background-color: #E3E3E3;
        color: #555555;
    }

    .actions-cell {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        background: transparent;
        border: none;
    }

    .action-btn:hover {
        background: #f8fafc;
    }

    .edit-btn {
        color: #3b82f6;
    }

    .delete-btn {
        color: #ef4444;
    }

    .total {
        font-size: 0.95rem;
        font-weight: 600;
        padding: 1.25rem 1rem;
        text-align: center;
        background-color: #e6e6e6;
        border-bottom: 1px solid gray;
    }

    .total+td {
        font-size: 0.95rem;
        font-weight: 600;
        background-color: #e6e6e6;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid gray;
    }
</style>

<body>
    <!-- Sidebar -->
    <?php include(DRIVE_PATH . "dashboard/sidebar.php"); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div id="particles-js"></div>

        <div class="header">
            <h1>All Transactions</h1>
            <div class="user-profile">
                <span><?php echo $_SESSION["name"]; ?></span>
                <h2 class="user-avatar"><?php echo $_SESSION["name"][0]; ?></h2>
            </div>
        </div>


        <div class="expense-table-container grow-animation" style="animation-delay: 0.9s">
            <div class="table-header">
                <h3 class="table-title">Fetch for all Years</h3>
                <div class="table-actions">
                    <button class="btn btn-primary" id="addExpenseBtn">
                        <i class="fas fa-plus"></i> Add Expense
                    </button>
                    <a href="<?php echo HTTP_PATH . "dashboard/print/print.php"; ?>" class="btn btn-outline"><i class="fa-solid fa-print"></i> Print</a>
                </div>
            </div>
            <div class="table-responsive">

                <?php
                for ($j = 2023; $j <= date("Y"); $j++) {
                    $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON income.incomeId=expenses.incomeId WHERE YEAR(expenses.date)=$j AND expenses.email='" . $_SESSION["email"] . "' ORDER BY expenses.date");
                    $sel->execute();
                    $sel = $sel->fetchAll();

                    if (isset($sel[0]) && date("Y", strtotime($sel[0]["date"])) == $j) {
                ?>

                        <h3 style="text-align: center;color: maroon;padding-bottom: 1.5rem;">Year ( <?php echo $j; ?> )</h3>

                        <table id="expenseTable" data-year="<?php echo date("Y", strtotime($r["date"])); ?>">
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
                                            <td colspan="5" class="total">[ <?php echo $j; ?> ]&ensp;Total of Year ( Income - ₹<?php echo $yearIn; ?> )</td>
                                            <td colspan="2">₹<?php echo $yearExp; ?></td>
                                        </tr>
                                <?php $yearExp = 0;
                                    }

                                    $prevMonth = date("M", strtotime($r["date"]));
                                } ?>
                            </tbody>
                        </table>
                <?php }
                } ?>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    $(document).ready(function() {

        $(".edit-btn").click(function() {
            let textData = {
                expenseId: $(this).parent("td").siblings(".expense-id").data("text"),
                name: $(this).parent("td").siblings(".name").data("text"),
                type: $(this).parent("td").siblings(".type").data("text"),
                expense: $(this).parent("td").siblings(".expense").data("text"),
                date: $(this).parent("td").siblings(".date").data("text"),
                description: $(this).parent("td").siblings(".description").data("text"),
            };

            let inputData = {
                expenseId: $(".expense-modal input[name='expenseId']"),
                name: $(".expense-modal input[name='name']"),
                type: $(".expense-modal select[name='type']"),
                expense: $(".expense-modal input[name='expense']"),
                date: $(".expense-modal input[name='date']"),
                description: $(".expense-modal textarea[name='description']"),
            };

            $("#expenseForm").attr("action", "<?php echo HTTP_PATH . "dashboard/expense-actions/edit.php"; ?>");
            inputData.expenseId.val(textData.expenseId);
            inputData.name.val(textData.name);
            inputData.type.val((textData.type).toLowerCase());

            inputData.expense.val(Number.parseInt(textData.expense));
            inputData.date.val(textData.date);
            inputData.description.val(textData.description);

            $("#expenseForm button[type='submit']").attr("name", "edit");

            $(".expense-modal").addClass("active");
        });

        $(".delete-btn").click(function() {
            if (confirm("Are You sure to delete?")) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo HTTP_PATH . "dashboard/expense-actions/delete.php"; ?>",
                    data: {
                        expenseId: $(this).parent("td").siblings(".expense-id").data("text")
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    });
</script>