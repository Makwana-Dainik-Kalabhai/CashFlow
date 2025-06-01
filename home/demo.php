<style>
    /* Interactive Demo */
    .demo {
        padding: 100px 0;
        background-color: var(--card-bg);
    }

    .demo-container {
        display: flex;
        align-items: center;
        gap: 50px;
    }

    .demo-content {
        flex: 1;
    }

    .demo-ui {
        flex: 1;
        background-color: var(--light);
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        transform-style: preserve-3d;
        transform: perspective(1000px) rotateY(10deg);
        transition: transform 0.5s;
    }

    .demo-ui:hover {
        transform: perspective(1000px) rotateY(0deg);
    }

    .demo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .demo-tabs {
        display: flex;
        gap: 10px;
    }

    .demo-tab {
        padding: 8px 15px;
        border-radius: 5px;
        background-color: var(--primary);
        color: white;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .demo-tab.inactive {
        background-color: var(--card-bg);
        color: var(--text-light);
    }

    .demo-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .demo-input {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: var(--card-bg);
        color: var(--text);
    }

    .demo-button {
        padding: 12px;
        border-radius: 8px;
        background-color: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .demo-button:hover {
        background-color: var(--secondary);
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }
</style>


<section class="demo" id="demo">
    <div class="container">
        <h2 class="section-title">Interactive User Interface</h2>
        <div class="demo-container">
            <div class="demo-content">
                <h3>See CashFlow in Action</h3>
                <p>Experience our intuitive interface that makes expense tracking effortless and even enjoyable.</p>
                <p>Hover over the demo to see interactive elements and animations.</p>
            </div>
            <div class="demo-ui">
                <div class="demo-header">
                    <h4>CashFlow</h4>
                    <div class="demo-tabs">
                        <div class="demo-tab">Expenses</div>
                        <div class="demo-tab inactive">Income</div>
                        <div class="demo-tab inactive">Reports</div>
                    </div>
                </div>
                <div class="demo-form">
                    <input type="text" class="demo-input" placeholder="Description" value="Groceries">
                    <input type="number" class="demo-input" placeholder="Amount" value="45.99">
                    <select class="demo-input">
                        <option>Food & Dining</option>
                        <option>Transportation</option>
                        <option>Entertainment</option>
                        <option>Utilities</option>
                    </select>
                    <input type="date" class="demo-input" value="2023-06-15">
                    <button class="demo-button">Add Expense</button>
                </div>
            </div>
        </div>
    </div>
</section>