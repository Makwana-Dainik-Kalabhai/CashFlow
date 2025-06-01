<style>
    .cta {
        padding: 100px 0;
        text-align: center;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        position: relative;
        overflow: hidden;
    }

    .cta h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }

    .cta p {
        max-width: 600px;
        margin: 0 auto 30px;
        position: relative;
        z-index: 2;
    }

    .cta-button {
        background-color: white;
        color: var(--primary);
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        font-size: 1rem;
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
</style>

<section class="cta">
    <div class="container">
        <h2>Ready to Take Control of Your Finances?</h2>
        <p>Join thousands of happy users who are saving more and stressing less about money.</p>
        <button class="cta-button login-btn" id="ctaButton">Start Tracking Now - It's Free!</button>
    </div>
</section>