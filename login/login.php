<!-- //! Google Login -->
<?php
require_once 'vendor/autoload.php';
require HTTP_PATH . "login/Oauth.php";


// Initialize the Google Client
$client = new Google\Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri('http://localhost/php/CashFlow/login/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

// Generate the authentication URL
$authUrl = $client->createAuthUrl();
?>


<style>
    :root {
        --accent-color: #4895ef;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #4bb543;
        --error-color: #ff3333;
        --google-blue: #4285F4;
        --google-red: #DB4437;
        --google-yellow: #F4B400;
        --google-green: #0F9D58;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: var(--transition);
    }

    .modal-overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    .login-modal {
        background-color: white;
        border-radius: 12px;
        width: 100%;
        max-width: 420px;
        padding: 30px;
        box-shadow: var(--shadow);
        transform: translateY(-20px);
        transition: var(--transition);
        position: relative;
    }

    .modal-overlay.active .login-modal {
        transform: translateY(0);
    }

    .login-modal .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--dark-color);
        opacity: 0.7;
        transition: var(--transition);
    }

    .login-modal .close-btn:hover {
        opacity: 1;
        color: var(--error-color);
    }

    .login-modal .modal-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .login-modal .modal-header h2 {
        color: var(--dark-color);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .login-modal .modal-header p {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .login-modal .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .login-modal .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark-color);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .login-modal .input-with-icon {
        position: relative;
    }

    .login-modal .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .login-modal .form-control {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .login-modal .form-control:focus {
        border-color: var(--accent-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
    }

    .login-modal .password-toggle {
        position: absolute;
        right: 12%;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
    }

    .login-modal .options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .login-modal .forgot-password {
        color: var(--accent-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .login-modal .forgot-password:hover {
        text-decoration: underline;
    }

    .login-modal .btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-modal .btn-primary {
        background-color: var(--primary);
        color: white;
        margin-bottom: 15px;
    }

    .login-modal .btn-primary:hover {
        background-color: var(--secondary);
        transform: translateY(-2px);
    }

    .login-modal .btn-google {
        background-color: white;
        color: var(--dark-color);
        border: 1px solid #ced4da;
        margin-top: 20px;
        position: relative;
        padding: 0.5rem 1rem;
    }

    .login-modal .btn-google svg {
        height: 27px;
    }

    .login-modal .btn-google:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
    }

    @media (max-width: 480px) {
        .login-modal {
            padding: 20px;
        }

        .login-modal .modal-header h2 {
            font-size: 1.4rem;
        }
    }
</style>


<!-- Login Modal -->
<div class="modal-overlay" id="loginModal">
    <div class="login-modal">
        <button class="close-btn" id="closeModal">&times;</button>

        <div class="modal-header">
            <h2>Welcome Back</h2>
            <p>Log in to your Expense Tracker account</p>
        </div>

        <form action="<?php echo HTTP_PATH . "login/verify.php"; ?>" method="post" id="loginForm">
            <div class="form-group">
                <label for="email">Email or Username</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email or username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="options">
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary">Log In</button>

            <a href="<?php echo $authUrl; ?>" type="button" class="btn btn-google">
                <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                &ensp;Continue with Google
            </a>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".login-btn").click(function() {
            $("#loginModal").addClass("active");
        });
        $("#closeModal").click(function() {
            $("#loginModal").removeClass("active");
        });
    });
</script>