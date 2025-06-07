<?php
include("config.php");
if (isset($_SESSION["email"]) || isset($_COOKIE["email"])) header("Location:" . HTTP_PATH . "dashboard/dashboard.php");

include(DRIVE_PATH . "email/month-expense.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow - Modern Expense Tracker</title>
    <style>
        /* Responsive Design */
        @media (max-width: 992px) {
            .demo-container {
                flex-direction: column;
            }

            .hero h1 {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .hero {
                padding: 150px 0 80px;
                text-align: center;
            }

            .hero-content {
                margin: 0 auto;
            }

            .cta-buttons {
                justify-content: center;
            }

            .floating-coins {
                display: none;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .btn {
                padding: 12px 25px;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include(DRIVE_PATH . "header.php"); ?>

    <!-- Hero Section -->
    <?php include(DRIVE_PATH . "home/hero.php"); ?>

    <div class="wave-divider">
        <div class="wave"></div>
    </div>

    <!-- Features Section -->
    <?php include(DRIVE_PATH . "home/features.php"); ?>

    <!-- Interactive Demo Section -->
    <?php include(DRIVE_PATH . "home/demo.php"); ?>

    <!-- CTA Section -->
    <?php include(DRIVE_PATH . "home/cta.php"); ?>


    <?php include(DRIVE_PATH . "footer.php"); ?>
</body>

</html>