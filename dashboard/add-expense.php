<style>
    /* Modal */
    .expense-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 30;
        visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        overflow: auto;
    }

    .expense-modal.active {
        visibility: visible;
        pointer-events: all;
    }

    .modal-content {
        margin: 2rem 0;
        background: white;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        padding: 1.5rem 2rem;
        box-shadow: var(--shadow-lg);
        transform: translateY(20px);
        transition: var(--transition);
    }

    .modal.active .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .close-btn {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--secondary);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-family: inherit;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: #a777e3;
        box-shadow: 0 0 0 3px rgba(167, 119, 227, 0.2);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }
</style>

<?php if (isset($_SESSION["error"])) { ?>
    <div class="alert alert-danger"><?php echo $_SESSION["error"]; ?></div>
    <div class="brightness"></div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut(6000);
                $(".brightness").fadeOut(6500);
            });
        });
    </script>
<?php }
unset($_SESSION["error"]); ?>

<?php if (isset($_SESSION["success"])) { ?>
    <div class="alert alert-success"><?php echo $_SESSION["success"]; ?></div>
    <div class="brightness"></div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut(4000);
                $(".brightness").fadeOut(4500);
            });
        });
    </script>
<?php }
unset($_SESSION["success"]); ?>


<!-- Add Expense Modal -->
<div class="expense-modal" id="expenseModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add New Expense</h3>
            <button class="close-btn" id="closeModal">&times;</button>
        </div>
        <form action="<?php echo HTTP_PATH . "dashboard/expense-actions/add.php"; ?>" method="post" id="expenseForm">
            <input type="hidden" name="expenseId" />
            <div class="form-group">
                <label for="expenseName" class="form-label">Expense Name <b style="color: red;">*</b></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Grocery Shopping" required>
            </div>
            <div class="form-group">
                <label for="expenseCategory" class="form-label">Category <b style="color: red;">*</b></label>
                <select name="type" class="form-control" required>
                    <option value="">Select a category</option>
                    <option value="food">Food</option>
                    <option value="transport">Transport</option>
                    <option value="housing">Housing</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="utilities">Utilities</option>
                    <option value="health">Health</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expenseAmount" class="form-label">Amount <b style="color: red;">*</b></label>
                <input type="number" name="expense" class="form-control" placeholder="0.00" step="0.01"
                    required>
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Date <b style="color: red;">*</b></label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Add any notes about this expense"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="cancelExpense">Cancel</button>
                <button type="submit" class="btn btn-primary" name="add">Save Expense</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#addExpenseBtn").click(function() {
            $("#expenseForm").attr("action", "<?php echo HTTP_PATH . "dashboard/expense-actions/add.php"; ?>");
            $("#expenseForm button[type='submit']").attr("name", "add");
            $(".expense-modal").addClass("active");
        });
        $(".fab").click(function() {
            $("#expenseForm").attr("action", "<?php echo HTTP_PATH . "dashboard/expense-actions/add.php"; ?>");
            $("#expenseForm button[type='submit']").attr("name", "add");
            $(".expense-modal").addClass("active");
        });
        $(".close-btn").click(function() {
            $(".expense-modal").removeClass("active");
        });
        $("#cancelExpense").click(function() {
            $(".expense-modal").removeClass("active");
        });
    });
</script>