<style>
    .chart-wrapper {
        position: relative;
        height: 400px;
        width: 100%;
        margin-bottom: 24px;
    }

    .summary-card {
        display: flex;
        justify-content: space-between;
        background: var(--card-bg);
        border-radius: 8px;
        padding: 16px;
        box-shadow: var(--shadow-sm);
    }

    .summary-item {
        text-align: center;
        flex: 1;
    }

    .summary-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }

    .summary-value {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .positive {
        color: var(--positive-balance);
    }

    .negative {
        color: var(--negative-balance);
    }

    @media (max-width: 768px) {
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .period-selector {
            align-self: flex-end;
        }

        .chart-wrapper {
            height: 350px;
        }
    }

    @media (max-width: 600px) {
        .chart-container {
            padding: 16px;
        }

        .chart-wrapper {
            height: 300px;
        }

        .summary-card {
            flex-direction: column;
            gap: 16px;
        }
    }
</style>

<div class="chart chart-wrapper">
    <canvas id="incomeExpenseChart"></canvas>
</div>


<script>
    $(document).ready(function() {
        const fullData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            income: [],
            expenses: []
        };

        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON expenses.incomeId=income.incomeId WHERE expenses.year=" . date("Y") . " AND expenses.email='" . $_SESSION["email"] . "'");
        $sel->execute();
        $sel = $sel->fetchAll();
        $income = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $expenses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($sel as $r) {
            $income[date("m", strtotime($r["date"])) - 1] = $r["income"];
            $expenses[date("m", strtotime($r["date"])) - 1] += $r["expense"];
        }
        for ($i = 0; $i < 12; $i++) { ?>
            fullData.income.push(<?php echo $income[$i]; ?>);
            fullData.expenses.push(<?php echo $expenses[$i]; ?>);
        <?php } ?>

        // Initialize chart

        function initChart(data) {
            let incomeExpenseChart;
            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            if (incomeExpenseChart) {
                incomeExpenseChart.destroy();
            }

            // Calculate totals for summary
            const totalIncome = data.income.reduce((a, b) => a + b, 0);
            const totalExpenses = data.expenses.reduce((a, b) => a + b, 0);
            const netDifference = totalIncome - totalExpenses;

            // Update summary values
            $('#total-income').text('₹' + totalIncome.toLocaleString());
            $('#total-expenses').text('₹' + totalExpenses.toLocaleString());
            $('#net-difference').text((netDifference >= 0 ? '+₹' : '-₹') + Math.abs(netDifference).toLocaleString());
            $('#net-difference').toggleClass('positive', netDifference >= 0);
            $('#net-difference').toggleClass('negative', netDifference < 0);

            // Create chart
            incomeExpenseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                            label: 'Income',
                            data: data.income,
                            backgroundColor: '#10B981',
                            borderRadius: 2.5,
                            borderSkipped: false,
                            hoverBackgroundColor: '#0E9F6E',
                            barPercentage: 0.8,
                            categoryPercentage: 0.6
                        },
                        {
                            label: 'Expenses',
                            data: data.expenses,
                            backgroundColor: '#EF4444',
                            borderRadius: 2.5,
                            borderSkipped: false,
                            hoverBackgroundColor: '#DC2626',
                            barPercentage: 0.8,
                            categoryPercentage: 0.6
                        }
                    ]
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
                                },
                                afterBody: function(context) {
                                    if (context.length === 2) {
                                        const income = context[0].raw;
                                        const expense = context[1].raw;
                                        const difference = income - expense;
                                        return `Net: ${difference >= 0 ? '+' : '-'}₹${Math.abs(difference).toLocaleString()}`;
                                    }
                                    return '';
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
        function getDataForPeriod(months) {
            return {
                labels: fullData.labels.slice(0, months),
                income: fullData.income.slice(0, months),
                expenses: fullData.expenses.slice(0, months)
            };
        }

        // Initialize with 6 months data
        initChart(getDataForPeriod(12));

        // Handle window resize
        $(window).on('resize', function() {
            if (incomeExpenseChart) {
                incomeExpenseChart.resize();
            }
        });
    });
</script>
</body>

</html>