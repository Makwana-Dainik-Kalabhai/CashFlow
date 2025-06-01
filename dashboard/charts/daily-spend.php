<style>
    :root {
        --primary-color: #6e8efb;
        --primary-dark: #4a6cf7;
        --high-spending: #ef4444;
        --average-line: #64748b;
        --current-day: #10b981;
        --tooltip-bg: #1e293b;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --bg-color: #ffffff;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .daily-spending-widget {
        max-width: 1000px;
        margin: 0 auto;
        background: var(--bg-color);
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        padding: 24px;
        overflow: hidden;
    }

    .time-period-toggle {
        display: flex;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 4px;
    }

    .time-period-btn {
        border: none;
        background: transparent;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .time-period-btn.active {
        background: white;
        box-shadow: var(--shadow-sm);
        font-weight: 600;
    }

    .chart-container {
        position: relative;
        width: 100%;
        min-height: 350px;
    }

    .chart-legend {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin-top: 20px;
        font-size: 0.85rem;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 50%;
    }

    .chart-bars-container {
        position: relative;
        height: 300px;
        margin-top: 40px;
    }

    .chart-y-axis {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 40px;
        width: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-right: 10px;
        text-align: right;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .chart-bars {
        display: flex;
        align-items: flex-end;
        height: 260px;
        margin-left: 40px;
        position: relative;
        padding-top: 20px;
    }

    .average-line {
        position: absolute;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--average-line);
        z-index: 1;
    }

    .average-line::after {
        content: 'Daily Average';
        position: absolute;
        right: 0;
        top: -22px;
        font-size: 0.75rem;
        color: var(--average-line);
        background: var(--bg-color);
        padding: 2px 6px;
        border-radius: 4px;
    }

    .bar-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        position: relative;
        margin: 0 2px;
    }

    .bar {
        width: 50%;
        background: var(--primary-color);
        border-radius: 4px 4px 0 0;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
        max-width: 40px;
    }

    .bar:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        opacity: 0.9;
    }

    .bar.current-day {
        background: var(--current-day);
    }

    .bar.high-spending {
        background: var(--high-spending);
    }

    .day-label {
        margin-top: 8px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-align: center;
        width: 100%;
    }

    .current-day .day-label {
        font-weight: bold;
        color: var(--text-primary);
    }

    .tooltip {
        position: absolute;
        bottom: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        background: var(--tooltip-bg);
        color: white;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        opacity: 0;
        pointer-events: none;
        transition: var(--transition);
        min-width: 160px;
        text-align: center;
        box-shadow: var(--shadow-md);
        z-index: 10;
    }

    .tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 6px;
        border-style: solid;
        border-color: var(--tooltip-bg) transparent transparent transparent;
    }

    .tooltip-title {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .tooltip-value {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 4px 0;
    }

    .tooltip-detail {
        font-size: 0.8rem;
        opacity: 0.9;
        margin: 2px 0;
    }

    .transactions-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        background: #f8fafc;
        border-radius: 8px;
        margin-top: 20px;
    }

    .transactions-panel.active {
        max-height: 500px;
        padding: 20px;
        border: 1px solid #e2e8f0;
    }

    .transactions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .transactions-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .close-transactions {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--text-secondary);
        padding: 4px;
    }

    .transactions-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        background: white;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        align-items: center;
    }

    .transaction-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .transaction-category {
        font-weight: 500;
        color: var(--text-primary);
    }

    .transaction-description {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    .transaction-amount {
        font-weight: 600;
    }

    .transaction-item.high-spending .transaction-amount {
        color: var(--high-spending);
    }

    .transaction-total {
        font-weight: 700;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
    }

    .no-transactions {
        text-align: center;
        padding: 20px;
        color: var(--text-secondary);
        font-style: italic;
    }

    @media (max-width: 768px) {
        .daily-spending-widget {
            padding: 16px;
        }

        .chart-bars-container {
            height: 280px;
        }

        .chart-bars {
            height: 240px;
            margin-left: 30px;
        }

        .chart-y-axis {
            width: 30px;
            font-size: 0.7rem;
        }

        .bar {
            width: 85%;
            max-width: 30px;
        }

        .time-period-toggle {
            width: 100%;
            justify-content: center;
        }

        .transactions-panel.active {
            padding: 16px;
        }

        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }

    /* Animations */
    @keyframes barGrow {
        from {
            height: 0;
        }

        to {
            height: var(--target-height);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>


<div class="chart-container">
    <div class="chart-bars-container">
        <div class="chart-y-axis" id="yAxis">
            <!-- Y-axis labels will be added by JavaScript -->
        </div>
        <div class="chart-bars" id="chartBars">
            <!-- Bars will be inserted here by jQuery -->
        </div>
    </div>
</div>

<div class="chart-legend">
    <div class="legend-item">
        <div class="legend-color" style="background: var(--primary-color);"></div>
        <span>Normal Spending</span>
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background: var(--current-day);"></div>
        <span>Today</span>
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background: var(--high-spending);"></div>
        <span>High Spending</span>
    </div>
</div>

<div class="transactions-panel" id="transactionsPanel">
    <!-- Transaction details will be inserted here when a bar is clicked -->
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Sample data - in a real app, this would come from an API
        const spendingData = {
            month: "May 2023",
            daily_spending: [{
                    "day": 1,
                    "amount": 45.00,
                    "transactions": [{
                            "category": "Groceries",
                            "amount": 25.00,
                            "description": "Weekly grocery shopping"
                        },
                        {
                            "category": "Transport",
                            "amount": 20.00,
                            "description": "Taxi ride"
                        }
                    ]
                },
                {
                    "day": 2,
                    "amount": 32.50,
                    "transactions": [{
                        "category": "Entertainment",
                        "amount": 32.50,
                        "description": "Movie tickets"
                    }]
                },
                {
                    "day": 3,
                    "amount": 28.75,
                    "transactions": [{
                            "category": "Dining",
                            "amount": 18.75,
                            "description": "Lunch with colleagues"
                        },
                        {
                            "category": "Utilities",
                            "amount": 10.00,
                            "description": "Mobile top-up"
                        }
                    ]
                },
                {
                    "day": 4,
                    "amount": 65.20,
                    "transactions": [{
                        "category": "Shopping",
                        "amount": 65.20,
                        "description": "New shoes"
                    }]
                },
                {
                    "day": 5,
                    "amount": 42.30,
                    "transactions": [{
                            "category": "Dining",
                            "amount": 22.30,
                            "description": "Dinner out"
                        },
                        {
                            "category": "Transport",
                            "amount": 20.00,
                            "description": "Bus pass"
                        }
                    ]
                },
                {
                    "day": 6,
                    "amount": 18.50,
                    "transactions": [{
                        "category": "Dining",
                        "amount": 18.50,
                        "description": "Coffee shop"
                    }]
                },
                {
                    "day": 7,
                    "amount": 55.00,
                    "transactions": [{
                        "category": "Entertainment",
                        "amount": 55.00,
                        "description": "Concert tickets"
                    }]
                },
                {
                    "day": 8,
                    "amount": 72.40,
                    "transactions": [{
                        "category": "Shopping",
                        "amount": 72.40,
                        "description": "Online purchase"
                    }]
                },
                {
                    "day": 9,
                    "amount": 38.25,
                    "transactions": [{
                        "category": "Groceries",
                        "amount": 38.25,
                        "description": "Supermarket"
                    }]
                },
                {
                    "day": 10,
                    "amount": 29.90,
                    "transactions": [{
                        "category": "Transport",
                        "amount": 29.90,
                        "description": "Ride sharing"
                    }]
                }
            ],
            "average_daily": 45.23,
            "total_budget": 2000.00,
            "budget_remaining": 845.00
        };

        <?php
        $sel = $conn->prepare("SELECT * FROM `expenses` JOIN `income` ON expenses.incomeId=income.incomeId WHERE MONTH(expenses.date)=" . date("m") . " AND expenses.email='" . $_SESSION["email"] . "'");
        $sel->execute();
        $sel = $sel->fetchAll();
        $types = [];
        $exp = [];
        $transactions = ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];

        foreach ($sel as $r) {
            
            $transactions[date("d", strtotime($r["date"])) - 1] = [$types, $exp];
        } ?>



        // Get current day for highlighting
        const currentDate = new Date();
        const currentDay = currentDate.getDate();
        const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed

        // Calculate max spending for scaling
        let maxSpending = 0;
        spendingData.daily_spending.forEach(day => {
            if (day.amount > maxSpending) maxSpending = day.amount;
        });

        // Create Y-axis labels
        const yAxisSteps = 5;
        const yAxisIncrement = maxSpending / yAxisSteps;
        for (let i = yAxisSteps; i >= 0; i--) {
            const value = Math.round(i * yAxisIncrement);
            $('#yAxis').append(`<div>&#8377;${value}</div>`);
        }

        // Add average line
        const averageLineHeight = (spendingData.average_daily / maxSpending) * 100;
        $('#chartBars').append(`<div class="average-line" style="bottom: ${averageLineHeight}%"></div>`);

        // Create bars for each day
        spendingData.daily_spending.forEach(day => {
            const barHeight = (day.amount / maxSpending) * 100;
            const isCurrentDay = (currentMonth === 5 && day.day === currentDay); // May is month 5
            const isHighSpending = day.amount > spendingData.average_daily * 1.5;

            const barClass = isCurrentDay ? 'current-day' : isHighSpending ? 'high-spending' : '';
            const dayClass = isCurrentDay ? 'current-day' : '';

            // Calculate percentage of monthly budget
            const budgetPercentage = (day.amount / spendingData.total_budget) * 100;

            // Calculate difference from average
            const diffFromAverage = day.amount - spendingData.average_daily;
            const diffSign = diffFromAverage >= 0 ? '+' : '';

            const barHtml = `
                    <div class="bar-container ${dayClass}" aria-label="Day ${day.day}, spent $${day.amount.toFixed(2)}">
                        <div class="tooltip" role="tooltip">
                            <div class="tooltip-title">May ${day.day}</div>
                            <div class="tooltip-value">$${day.amount.toFixed(2)}</div>
                            <div class="tooltip-detail">${budgetPercentage.toFixed(1)}% of monthly budget</div>
                            <div class="tooltip-detail">${diffSign}$${Math.abs(diffFromAverage).toFixed(2)} ${diffFromAverage >= 0 ? 'above' : 'below'} average</div>
                            <div class="tooltip-detail">${day.transactions.length} transaction${day.transactions.length !== 1 ? 's' : ''}</div>
                        </div>
                        <div class="bar ${barClass}" data-day="${day.day}" style="height: ${barHeight}%;" aria-hidden="true" data-height="${barHeight}"></div>
                        <div class="day-label">${day.day}</div>
                    </div>
                `;

            $('#chartBars').append(barHtml);
        });

        // Tooltip hover effects
        $('.bar-container').hover(
            function() {
                // Mouse enter
                $(this).find('.bar').addClass('hover');
                $(this).find('.tooltip').css('opacity', '1');
            },
            function() {
                // Mouse leave
                $(this).find('.bar').removeClass('hover');
                $(this).find('.tooltip').css('opacity', '0');
            }
        );

        // Click on bar to show transactions
        $('.bar').click(function() {
            const day = $(this).data('day');
            const dayData = spendingData.daily_spending.find(d => d.day === day);

            // Build transactions HTML
            let transactionsHtml = `
                    <div class="transactions-header">
                        <h3 class="transactions-title">Transactions for May ${day}</h3>
                        <button class="close-transactions" aria-label="Close transactions">&times;</button>
                    </div>
                `;

            if (dayData.transactions.length > 0) {
                transactionsHtml += '<div class="transactions-list">';

                dayData.transactions.forEach(transaction => {
                    const isHigh = transaction.amount > (spendingData.average_daily / 3);
                    const itemClass = isHigh ? 'high-spending' : '';

                    transactionsHtml += `
                            <div class="transaction-item ${itemClass}">
                                <div class="transaction-info">
                                    <div>
                                        <div class="transaction-category">${transaction.category}</div>
                                        <div class="transaction-description">${transaction.description}</div>
                                    </div>
                                </div>
                                <div class="transaction-amount">$${transaction.amount.toFixed(2)}</div>
                            </div>
                        `;
                });

                transactionsHtml += `
                        <div class="transaction-total">
                            <span>Total for May ${day}:</span>
                            <span class="transaction-amount">$${dayData.amount.toFixed(2)}</span>
                        </div>
                    `;

                transactionsHtml += '</div>';
            } else {
                transactionsHtml += '<div class="no-transactions">No transactions recorded for this day</div>';
            }

            // Update and show transactions panel
            $('#transactionsPanel').html(transactionsHtml).addClass('active');

            // Close button event
            $('.close-transactions').click(function() {
                $('#transactionsPanel').removeClass('active');
            });

            // Scroll to panel if on mobile
            if ($(window).width() < 768) {
                $('html, body').animate({
                    scrollTop: $('#transactionsPanel').offset().top - 20
                }, 300);
            }
        });

        // Time period toggle
        $('.time-period-btn').click(function() {
            $('.time-period-btn').removeClass('active').attr('aria-selected', 'false');
            $(this).addClass('active').attr('aria-selected', 'true');

            // In a real app, this would fetch new data for the selected time period
            const period = $(this).text().toLowerCase();
            console.log(`Switching to ${period} view...`); // Would be replaced with actual data loading

            // For demo purposes, just animate a refresh
            $('.bar').css('height', '0');
            $('.bar').each(function(index) {
                $(this).delay(index * 30).animate({
                    height: $(this).attr('style').match(/height: (\d+)%/)[1] + '%'
                }, 400, 'easeOutQuad');
            });
        });

        // Keyboard navigation
        $('.bar').keypress(function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                $(this).click();
            }
        });
    });
</script>