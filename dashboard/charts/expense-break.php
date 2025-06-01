<style>
    .chart-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .chart-total {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .chart-subtitle {
        font-size: 0.875rem;
        color: #64748b;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .chart-legend-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        background: #f8fafc;
        cursor: pointer;
        transition: var(--transition);
    }

    .chart-legend-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .chart-legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        margin-right: 0.5rem;
    }

    .chart-legend-text {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .chart-legend-value {
        margin-left: 0.5rem;
        color: #64748b;
        font-size: 0.75rem;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        z-index: 10;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e2e8f0;
        border-top-color: #a777e3;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748b;
    }
</style>

<div class="chart chart-wrapper">
    <!-- Loading state -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Empty state (hidden by default) -->
    <div class="empty-state" id="emptyState" style="display: none;">
        <i class="fas fa-chart-pie" style="font-size: 2rem; margin-bottom: 1rem;"></i>
        <h3>No Expense Data</h3>
        <p>Add expenses to see your spending breakdown</p>
    </div>

    <!-- Chart canvas -->
    <canvas id="expenseChart"></canvas>

    <!-- Center text -->
    <div class="chart-center-text">
        <div class="chart-total" id="chartTotal">₹0</div>
        <div class="chart-subtitle">Total Expenses (<?php echo date("M Y"); ?>)</div>
    </div>
</div>
<div class="chart-legend" id="chartLegend"></div>

<script>
    $(document).ready(function() {
        const expenseData = {
            categories: [],
        };

        let colors = ["#F59E0B", "#3B82F6", "#8B5CF6", "#EC4899", "#10B981", "#EF4444", "#64748B"];
        let save = 0;

        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` WHERE `monthYear`='" . date("m Y") . "' AND `email`='" . $_SESSION["email"] . "'");
        $sel->execute();
        $sel = $sel->fetchAll();
        $total = [0, 0, 0, 0, 0, 0, 0];

        foreach ($sel as $r) {
            if (strtolower($r["type"]) == "food") $total[0] += $r["expense"];
            if (strtolower($r["type"]) == "transport") $total[1] += $r["expense"];
            if (strtolower($r["type"]) == "housing") $total[2] += $r["expense"];
            if (strtolower($r["type"]) == "entertainment") $total[3] += $r["expense"];
            if (strtolower($r["type"]) == "utilities") $total[4] += $r["expense"];
            if (strtolower($r["type"]) == "health") $total[5] += $r["expense"];
            if (strtolower($r["type"]) == "other") $total[6] += $r["expense"];
        } ?>

        insertDate();

        function insertDate() {

            expenseData.categories.push({
                name: "Food",
                amount: <?php echo $total[0]; ?>,
                color: colors[0]
            });
            expenseData.categories.push({
                name: "Transport",
                amount: <?php echo $total[1]; ?>,
                color: colors[1]
            });
            expenseData.categories.push({
                name: "Housing",
                amount: <?php echo $total[2]; ?>,
                color: colors[2]
            });
            expenseData.categories.push({
                name: "Entertainment",
                amount: <?php echo $total[3]; ?>,
                color: colors[3]
            });
            expenseData.categories.push({
                name: "Utilities",
                amount: <?php echo $total[4]; ?>,
                color: colors[4]
            });
            expenseData.categories.push({
                name: "Health",
                amount: <?php echo $total[5]; ?>,
                color: colors[5]
            });
            expenseData.categories.push({
                name: "Other",
                amount: <?php echo $total[6]; ?>,
                color: colors[6]
            });
        }

        // Initialize chart
        let expenseChart;
        let activeSegment = null;

        initChart(expenseData);
        $('#loadingOverlay').fadeOut();

        function initChart(data) {
            const ctx = document.getElementById('expenseChart').getContext('2d');
            const totalAmount = data.categories.reduce((sum, category) => sum + category.amount, 0);

            // Update center text
            $('#chartTotal').text(`₹${totalAmount.toLocaleString()}`);

            // Build legend
            const legendHtml = data.categories.map(category => {
                const percentage = ((category.amount / totalAmount) * 100).toFixed(1);

                if (category.amount > 0) {
                    return `
                        <div class="chart-legend-item" data-category="${category.name}">
                            <div class="chart-legend-color" style="background: ${category.color};"></div>
                            <span class="chart-legend-text">${category.name}</span>
                            <span class="chart-legend-value">&#8377;${category.amount} (${percentage}%)</span>
                        </div>
                    `;
                }
            }).join('');

            $('#chartLegend').html(legendHtml);

            // Create chart
            expenseChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.categories.map(c => c.name),
                    datasets: [{
                        data: data.categories.map(c => c.amount),
                        backgroundColor: data.categories.map(c => c.color),
                        borderWidth: 0,
                        hoverBorderWidth: 0,
                        hoverOffset: 15,
                        borderRadius: 6,
                        spacing: 2
                    }]
                },
                options: {
                    cutout: '70%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ₹${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                }
            });

            // Legend click to filter
            $('.chart-legend-item').click(function() {
                const category = $(this).data('category');
                const index = data.categories.findIndex(c => c.name === category);
                if (index !== -1) {
                    toggleActiveSegment(index);
                }
            });
        }
    });
</script>