<style>
    /* //! Common Styling */
    :root {
        --primary: #53ab3b;
        --secondary: #79C963;
        --dark: #2d3436;
        --light: #f5f6fa;
        --success: #00b894;
        --warning: #fdcb6e;
        --danger: #d63031;
        --card-bg: #ffffff;
        --text: #2d3436;
        --text-light: #636e72;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        transition: background-color 0.3s, color 0.3s;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--light);
        color: var(--text);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
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
        color: white;
        background-color: red;
        border-radius: 5px;
        display: grid;
        place-items: center;
    }

    .btn {
        padding: 15px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        font-size: 1rem;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        box-shadow: 0 4px 15px #aedea0;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px #9dd88d;
    }

    .btn-secondary {
        background-color: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-secondary:hover {
        background-color: var(--primary);
        color: white;
    }

    header {
        background-color: var(--light);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        width: 100%;
        z-index: 49;
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
    }

    .logo {
        width: 120px;
    }

    .logo img {
        width: 100%;
    }

    .hamburger {
        display: none;
        background: none;
        border: none;
        color: var(--text);
        font-size: 1.5rem;
        cursor: pointer;
    }

    .login-btn {
        font-size: 1rem;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        background-color: var(--primary);
        color: white;
        box-shadow: 0 4px 15px #aedea0;
    }

    .login-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px #9dd88d;
    }

    @media (max-width: 560px) {
        .logo {
            width: 100px;
        }
    }
</style>


<?php if (isset($_SESSION["error"])) { ?>
<div class="alert alert-danger"><?php echo $_SESSION["error"]; ?></div>
    <div class="brightness"></div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut(5000);
                $(".brightness").fadeOut(5500);
            });
        });
    </script>
<?php }
unset($_SESSION["error"]); ?>

<header>
    <div class="container">
        <nav>
            <div class="logo">
                <img src="logo.png" alt="">
            </div>

            <button class="login-btn"><b>Login</b></button>

            <button class="hamburger">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </div>
</header>


<!-- Login Modal -->
<?php include(DRIVE_PATH . "login/login.php"); ?>