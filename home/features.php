<style>
    .features {
        padding: 100px 0;
        background-color: var(--light);
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
        font-size: 2.5rem;
        color: var(--text);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        z-index: 2;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        border-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        color: white;
        font-size: 1.5rem;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: var(--text);
    }

    .feature-card p {
        color: var(--text-light);
        margin-bottom: 20px;
    }
</style>


<section class="features" id="features">
    <div class="container">
        <h2 class="section-title">Powerful Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <h3>Expense Entry</h3>
                <p>Log expenses in seconds with smart suggestions.</p>
                <div class="pulsing-input"></div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3>Categories & Tags</h3>
                <p>Organize spending with custom categories.</p>
                <div class="category-selector">
                    <span class="category-tag">Food, Transport, Entertainment</span>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3>Budget Alerts</h3>
                <p>Set budgets and get notified before overspending.</p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%;"></div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3>Reports & Charts</h3>
                <p>Visualize spending trends with beautiful graphs.</p>
                <div class="mini-chart"></div>
            </div>
        </div>
    </div>
</section>