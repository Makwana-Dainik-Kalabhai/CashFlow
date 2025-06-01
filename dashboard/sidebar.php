<style>
    :root {
        --primary: #53ab3b;
        --secondary: #79C963;
        --dark: #2d3436;
        --light: #f5f6fa;
        --success: #00cc00;
        --warning: #fdcb6e;
        --danger: #d63031;
        --card-bg: #ffffff;
        --text-light: #636e72;
        --primary-gradient: linear-gradient(135deg, #53ab3b, #79C963);
        --income-color: #10b981;
        --expense-color: #ef4444;
        --savings-color: #f59e0b;
        --positive-balance: #00cc00;
        --negative-balance: #ef4444;
        --glass-bg: rgba(255, 255, 255, 0.15);
        --glass-border: rgba(255, 255, 255, 0.18);
        --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        font-family: 'Poppins', sans-serif;
        background: #f1f5f9;
        color: var(--dark);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .brightness {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: black;
        opacity: 0.6;
        z-index: 50;
    }

    .alert {
        position: fixed;
        top: 5%;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 51;
        padding: 0.7rem 1rem;
        background-color: red;
        border-radius: 5px;
        display: grid;
        place-items: center;
    }

    .alert-danger {
        color: #e60000;
        background-color: #ffb3b3;
        border: 1px solid #e60000;
    }

    .alert-success {
        color: #009900;
        background-color: #b3ffb3;
        border: 1px solid #009900;
    }

    .btn {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        color: white;
        background: var(--primary-gradient);
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .btn-outline {
        color: black;
        background: transparent;
        border: 1px solid #cbd5e1;
    }

    .btn-outline:hover {
        background: #f8fafc;
    }


    /* Main Content Styles */
    .main-content {
        width: 75%;
        height: 100%;
        margin: auto;
        padding: 2rem;
        background: #f1f5f9;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--dark);
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        display: grid;
        place-items: center;
        line-height: 1;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: var(--shadow-sm);
        color: var(--light) !important;
        background-color: var(--primary);
    }

    .header-filter button {
        padding: 0.55rem 1rem;
        margin: 0.2rem;
        color: var(--primary);
        background-color: white;
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: 0.3s all ease;
    }

    .header-filter button.active {
        color: var(--light);
        background-color: var(--primary);
    }

    /* Sidebar Styles */
    .sidebar {
        width: 20%;
        height: 100%;
        padding-top: 2rem;
        background: white;
        box-shadow: var(--shadow-sm);
        z-index: 10;
        transition: var(--transition);
    }

    .logo {
        width: 100%;
    }

    .logo img {
        display: block;
        width: 60%;
        margin: auto;
    }

    .sidebar-menu {
        padding: 1rem 0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: gray;
        text-decoration: none;
        transition: var(--transition);
    }

    .menu-item:hover,
    .menu-item.active {
        background: #f8fafc;
        color: var(--dark);
        border-left: 4px solid var(--primary);
    }

    .menu-item i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }


    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        cursor: pointer;
        transition: var(--transition);
        z-index: 20;
        border: none;
    }

    .fab:hover {
        transform: scale(1.1) translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 1024px) {
        .sidebar {
            width: 30%;
        }

        .main-content {
            width: 70%;
        }
    }
</style>

<?php if (!isset($_GET["active"])) $_GET["active"] = "dashboard"; ?>

<aside class="sidebar">
    <div class="logo">
        <img src="<?php echo HTTP_PATH . "logo.png"; ?>" alt="">
    </div>
    <nav class="sidebar-menu">
        <a href="<?php echo HTTP_PATH . "dashboard/dashboard.php?active=dashboard"; ?>" class="menu-item <?php if (isset($_GET["active"]) && $_GET["active"] == "dashboard") echo "active"; ?>"><i class="fas fa-home"></i> Dashboard</a>
        <a href="<?php echo HTTP_PATH . "dashboard/analytics.php?active=analytics"; ?>" class="menu-item <?php if (isset($_GET["active"]) && $_GET["active"] == "analytics") echo "active"; ?>"><i class="fas fa-chart-pie"></i> Analytics</a>
        <a href="<?php echo HTTP_PATH . "dashboard/expense-table.php?active=expenses"; ?>" class="menu-item <?php if (isset($_GET["active"]) && $_GET["active"] == "expenses") echo "active"; ?>"><i class="fas fa-exchange-alt"></i> Transactions</a>
        <a href="#" class="menu-item"><i class="fas fa-bullseye"></i> Goals</a>
        <a href="#" class="menu-item"><i class="fas fa-cog"></i> Settings</a>
        <a href="#" class="menu-item"><i class="fas fa-question-circle"></i> Help</a>
        <a href="<?php echo HTTP_PATH . "dashboard/logout.php"; ?>" class="menu-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </nav>
</aside>


<!-- Floating Action Button -->
<button class="fab" id="fab">
    <i class="fas fa-plus"></i>
</button>


<?php include(DRIVE_PATH . "dashboard/add-expense.php"); ?>
<?php include(DRIVE_PATH . "dashboard/add-income.php"); ?>