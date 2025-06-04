<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<style>
    /* Modal */
    .income-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 30;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }
</style>


<?php if (isset($_POST["addIncome"])) {
    $in = $conn->prepare("INSERT INTO `income` VALUES(0, '" . $_COOKIE["email"] . "', " . $_POST["income"] . ", '" . $_SESSION["monthYear"] . "')");
    $in->execute();

    $_SESSION["success"] = "Income inserted successfully";
} ?>



<?php if (isset($_SESSION["add-income"])) { ?>
    <!-- Add Income Modal -->
    <div class="income-modal in-exp-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Income ( <?php echo $_SESSION["add-income"]; ?> )</h3>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            <form action="" method="post" id="expenseForm">
                <div class="form-group">
                    <label for="income" class="form-label">Add Income of the Month <b style="color: red;">*</b></label>
                    <input type="number" name="income" class="form-control" placeholder="Amount"
                        required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelExpense">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="addIncome">Save Income</button>
                </div>
            </form>
        </div>
    </div>
<?php $_SESSION["monthYear"] = $_SESSION["add-income"];
}
unset($_SESSION["add-income"]); ?>

<script>
    $(document).ready(function() {
        $(".close-btn").click(function() {
            $(".income-modal .modal-content").delay(500).css("transform", "translateY(200%)");
            $(".income-modal").fadeOut(400);
        });
    });
</script>