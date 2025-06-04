<style>
    .chart-wrapper {
        position: relative;
        height: 400px;
        width: 100%;
        margin-bottom: 24px;
    }

    .positive {
        color: var(--positive-balance);
    }

    .negative {
        color: var(--negative-balance);
    }

    #dailySpendChart {
        position: relative;
    }

    @media (max-width: 768px) {
        .chart-wrapper {
            height: 350px;
        }
    }

    @media (max-width: 600px) {
        .chart-wrapper {
            height: 300px;
        }
    }
</style>

<div class="chart chart-wrapper">
    <canvas id="dailySpendChart"></canvas>
</div>


<script>
    $(document).ready(function() {
        const fullData = {
            labels: [],
            expenses: []
        };
        let date = new Date();

        for(let i=1; i<=((new Date(date.getFullYear(), date.getMonth() + 1, 0)).getDate()); i++) {
            fullData.labels.push(i);
        }

        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON expenses.incomeId=income.incomeId WHERE MONTH(expenses.date)=" . date("m") . " AND expenses.email='" . $_COOKIE["email"] . "' ORDER BY `date`");
        $sel->execute();
        $sel = $sel->fetchAll();
        $expenses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($sel as $r) {
            $expenses[date("d", strtotime($r["date"])) - 1] += $r["expense"];
        }
        for ($i = 0; $i < 31; $i++) { ?>
            fullData.expenses.push(<?php echo $expenses[$i]; ?>);
        <?php } ?>

        let avgExp = 0;
        fullData.expenses.forEach(ele => {
            avgExp += ele;
        });
        avgExp /= fullData.expenses.length;




        // Initialize chart
        function initChart(data) {
            let dailySpendChart;
            const ctx = document.getElementById('dailySpendChart').getContext('2d');
            if (dailySpendChart) {
                dailySpendChart.destroy();
            }

            // Create chart
            dailySpendChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Spendings',
                        data: data.expenses,
                        backgroundColor: '#6e8efb',
                        borderRadius: 2.5,
                        borderSkipped: false,
                        hoverBackgroundColor: '#0E9F6E',
                        barPercentage: 0.8,
                        categoryPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ₹${context.raw.toLocaleString()}`;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            onClick: function(e, legendItem, legend) {
                                const index = legendItem.datasetIndex;
                                const ci = legend.chart;
                                const meta = ci.getDatasetMeta(index);

                                meta.hidden = meta.hidden === null ? !ci.data.datasets[index].hidden : null;
                                ci.update();
                            },
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    onClick: function(e, elements) {
                        if (elements.length > 0) {
                            const monthIndex = elements[0].index;
                            const month = this.data.labels[monthIndex];
                            alert(`Viewing transactions for ${month} (would open detailed view in a real app)`);
                        }
                    }
                }
            });
        }

        // Function to get data for selected period
        function getDataForPeriod(days) {
            return {
                labels: fullData.labels.slice(0, days),
                expenses: fullData.expenses.slice(0, days)
            };
        }

        // Initialize with 6 days data
        initChart(getDataForPeriod(31));

        // Handle window resize
        $(window).on('resize', function() {
            if (dailySpendChart) {
                dailySpendChart.resize();
            }
        });
    });
</script>