<?php include("C:/xampp/htdocs/php/CashFlow/config.php"); ?>

<link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>logo.ico" type="image/x-icon">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashflow | Analysis of Income/Expenses</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Charts Section */
        .charts-section {
            width: 100%;
        }

        .chart-container {
            width: 100%;
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .chart-actions {
            display: flex;
            gap: 0.5rem;
        }

        .chart-btn {
            background: #f8fafc;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .chart-btn:hover {
            background: #e2e8f0;
        }

        .chart {
            position: relative;
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

<body>
    <!-- Sidebar -->
    <?php include(DRIVE_PATH . "dashboard/sidebar.php"); ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <div id="particles-js"></div>
        
        <?php include(DRIVE_PATH . "dashboard/header.php"); ?>


        <!-- Overview Cards -->
        <?php include(DRIVE_PATH . "dashboard/overview-cards.php"); ?>


        <!-- Charts Section -->
        <div class="charts-section">
            <!-- Expense Breakdown Chart -->
            <div class="chart-container grow-animation" style="animation-delay: 0.5s">
                <div class="chart-header">
                    <h3 class="chart-title">Expense Breakdown</h3>
                </div>
                <?php include(DRIVE_PATH . "dashboard/charts/expense-break.php"); ?>
            </div>

            <div class="chart-container grow-animation" style="animation-delay: 0.6s">
                <div class="chart-header">
                    <h3 class="chart-title">Income vs Expenses</h3>
                </div>
                <?php include(DRIVE_PATH . "dashboard/charts/in-vs-exp.php"); ?>

                <div class="summary-card">
                    <div class="summary-item">
                        <div class="summary-label">Total Income</div>
                        <div class="summary-value" id="total-income">$0</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Total Expenses</div>
                        <div class="summary-value" id="total-expenses">$0</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Net Difference</div>
                        <div class="summary-value" id="net-difference">$0</div>
                    </div>
                </div>
            </div>

            <div class="chart-container grow-animation" style="animation-delay: 0.7s">
                <div class="chart-header">
                    <h3 class="chart-title">Spending Trend</h3>
                </div>
                <div class="chart">
                    <?php include(DRIVE_PATH . "dashboard/charts/sprend-trend.php"); ?>
                </div>
            </div>

            <div class="chart-container grow-animation" style="animation-delay: 0.8s">
                <div class="chart-header">
                    <h3 class="chart-title">Daily Spending</h3>
                </div>
                <div class="chart">
                    <?php include(DRIVE_PATH . "dashboard/charts/daily-spend.php"); ?>
                </div>
            </div>
        </div>
    </main>


    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cal-heatmap/3.6.5/cal-heatmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.0.0/d3.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".header-filter button").click(function() {
                $(".header-filter button").css("transition", "0.3s all ease");
                $(".header-filter button").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
</body>

</html>