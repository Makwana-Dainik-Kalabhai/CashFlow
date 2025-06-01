<canvas id="trendChart"></canvas>

<script>
    $(document).ready(function() {
        // Sample Data
        const data = {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4", "Week 5"],
            spending: []
        };

        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON expenses.incomeId=income.incomeId WHERE MONTH(expenses.date)=" . date("m") . " AND expenses.email='" . $_SESSION["email"] . "'");
        $sel->execute();
        $sel = $sel->fetchAll();
        $expenses = [0, 0, 0, 0, 0];

        foreach ($sel as $r) {
            $day = date("d", strtotime($r["date"]));

            if ($day >= 1 && $day <= 7) $expenses[0] += $r["expense"];
            if ($day >= 8 && $day <= 14) $expenses[1] += $r["expense"];
            if ($day >= 15 && $day <= 21) $expenses[2] += $r["expense"];
            if ($day >= 22 && $day <= 28) $expenses[3] += $r["expense"];
            if ($day >= 29) $expenses[4] += $r["expense"];
        }
        foreach ($expenses as $ex) { ?>
            data.spending.push(<?php echo $ex; ?>);
        <?php } ?>

        
        // Initialize Chart
        const ctx = document.getElementById('trendChart').getContext('2d');
        const trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Total Spending',
                    data: data.spending,
                    borderColor: '#6e8efb',
                    backgroundColor: 'rgba(110, 142, 251, 0.1)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6e8efb',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: (ctx) => `₹${ctx.raw}`
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => `₹${value}`
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
</script>