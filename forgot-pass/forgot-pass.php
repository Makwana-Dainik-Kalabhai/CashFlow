<?php
define("HTTP_PATH", "http://localhost/php/CashFlow/");

$conn = new PDO("mysql:host=localhost;dbname=CashFlow", "root", "");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow - Forgot Password</title>
    <style>
        :root {
            --primary: #53ab3b;
            --secondary: #79C963;
            --dark: #2d3436;
            --light: #f5f6fa;
            --success: #00b894;
            --warning: #fdcb6e;
            --danger: #d63031;
            --card-bg: #ffffff;
            --text: #2d3436;
            --text-light: #636e72;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }

        .alert {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translate(-50%, 0);
            background-color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 7px;
            z-index: 2;
            transition: all 0.5s ease;
        }

        .alert.active {
            top: 10%;
        }

        .alert-danger {
            color: red;
            background-color: pink;
            filter: contrast(120%);
            border: 2px solid red;
        }

        .alert-success {
            color: green;
            background-color: rgba(0, 255, 0, 0.3);
            filter: contrast(120%);
            border: 2px solid green;
        }

        /* Modal Container */
        .modal-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            background-color: white;
            border-radius: 12px;
            width: 100%;
            padding: 3rem 0;
            max-width: 750px;
            transition: var(--transition);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .five-lines {
            position: absolute;
            left: -10%;
            width: 100%;
            height: 2px;
            transform: rotate(30deg);
            background-color: var(--primary);
            box-shadow: 0px 0px 5px 1px var(--secondary);
        }

        .five-lines:nth-of-type(1) {
            bottom: -42%;
        }

        .five-lines:nth-of-type(2) {
            bottom: -37%;
        }

        .five-lines:nth-of-type(3) {
            bottom: -32%;
        }

        .five-lines:nth-of-type(4) {
            bottom: -27%;
        }

        .five-lines:nth-of-type(5) {
            bottom: -22%;
        }

        .modal-container>div {
            width: 100%;
        }

        .modal-container .logo {
            display: grid;
            place-items: center;
        }

        .modal-container .logo img {
            width: 80%;
        }

        /* Modal Header */
        .modal-header {
            display: flex;
            justify-content: center;
            padding: 0 20px;
        }

        .modal-title {
            width: fit-content;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
        }

        /* Modal Body */
        .modal-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--card-bg);
            background-color: #f2f2f2;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-control::placeholder {
            color: var(--dark);
            opacity: 0.6;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .form-control.error {
            border-color: var(--error-color);
        }

        .form-control.error+.error-message {
            display: block;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .submit-btn:hover {
            background-color: var(--primary);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .submit-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
            display: none;
        }

        .submit-btn.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Footer Links */
        .modal-footer {
            padding: 0 25px 25px;
            text-align: center;
        }

        .footer-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition);
            cursor: pointer;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Responsive Adjustments */
        @media (max-width: 480px) {
            .modal-container {
                margin: 10px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 15px;
            }

            .modal-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo HTTP_PATH . "logo.ico"; ?>" type="image/x-icon" />

<!-- jQuery Link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    <h4 class="alert">OTP sent to verified email</h4>

    <div class="modal-container">
        <div class="five-lines"></div>
        <div class="five-lines"></div>
        <div class="five-lines"></div>
        <div class="five-lines"></div>
        <div class="five-lines"></div>


        <div class="logo">
            <img src="http://localhost/php/CashFlow/logo.png" alt="">
        </div>

        <div>
            <!-- //! Forgot Password Form -->
            <div class="modal-header email-form" style="display: <?php echo (isset($_COOKIE["otp"]) || isset($_COOKIE["setPass"])) ? "none" : "flex"; ?>;">
                <h2 class="modal-title">Reset Your Password</h2>
            </div>

            <div class="modal-body email-form" style="display: <?php echo (isset($_COOKIE["otp"]) || isset($_COOKIE["setPass"])) ? "none" : "block"; ?>;">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                </div>

                <button type="submit" class="submit-btn" name="send-otp">
                    <div class="spinner"></div>
                    <span>Send Reset Code</span>
                </button>
            </div>



            <!-- //! OTP Form -->
            <div class="modal-header otp-form" style="display: <?php echo (isset($_COOKIE["otp"]) && !isset($_COOKIE["setPass"])) ? "flex" : "none"; ?>;">
                <h2 class="modal-title">Submit OTP</h2>
            </div>

            <div class="modal-body otp-form" style="display: <?php echo (isset($_COOKIE["otp"]) && !isset($_COOKIE["setPass"])) ? "block" : "none"; ?>;">
                <div class="form-group">
                    <label for="email" class="form-label">Enter OTP</label>

                    <style>
                        input::-webkit-outer-spin-button,
                        input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                        }

                        .otp-inputs {
                            display: flex;
                        }

                        .otp-inputs .otp-input {
                            font-size: 1.1rem;
                            font-weight: 500;
                            width: 13%;
                            margin: 0 1%;
                            padding: 0.5rem;
                            border: none;
                            border-bottom: 3px solid #d9d9d9;
                            outline: none;
                            text-align: center;
                        }

                        .otp-inputs .otp-input:focus {
                            border-bottom: 3px solid var(--secondary);
                        }
                    </style>

                    <div class="otp-inputs">
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                        <input type="number" class="otp-input" minlength="1" maxlength="1" />
                    </div>
                </div>

                <button type="submit" class="submit-btn" name="verify-otp">
                    <div class="spinner"></div>
                    <span>Submit</span>
                </button>
            </div>





            <!-- //! Password Form -->
            <div class="modal-header password-form" style="display: <?php echo (isset($_COOKIE["setPass"]) && !isset($_COOKIE["otp"])) ? "flex" : "none"; ?>;">
                <h2 class="modal-title change-pass-form">Change Password Now</h2>
            </div>

            <div class="modal-body password-form" style="display: <?php echo (isset($_COOKIE["setPass"]) && !isset($_COOKIE["otp"])) ? "block" : "none"; ?>;">
                <div class="form-group">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="text" name="new-password" class="form-control" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="text" name="confirm-password" class="form-control" placeholder="Enter Confirm Password" required>
                </div>

                <button type="submit" class="submit-btn" name="change-password">
                    <div class="spinner"></div>
                    <span>Send Reset Code</span>
                </button>
            </div>

            <div class="modal-footer">
                <a onclick="history.back()" class="footer-link" id="back-to-login">
                    <h3>Back to Login</h3>
                </a>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $(".otp-input")[0].focus();
            $(".otp-input").keyup(function(e) {
                if (e.key >= 0 && e.key <= 9) $(this).next(".otp-input").focus();
                if (e.key == "Backspace") $(this).prev(".otp-input").focus();

                let curr = $(this);
                if ((curr.index() == $(".otp-input").length - 1) && (curr.length > 0)) $(this).blur();
                if (curr.val().length > 1) $(this).val(curr.val()[0]);
            });
            $(".otp-input").keydown(function(e) {
                let curr = $(this);

                if (curr.val().length > 0) {
                    $(this).val(curr.val()[0]);
                    $(this).next(".otp-input").focus();
                }
            });


            $("button[name='send-otp']").click(function() {
                let email = $("input[name='email']").val();

                if (email != "") {
                    sendAjaxReq({
                        email: email,
                        type: "email"
                    }, "OTP SENT TO VERIFIED EMAIL ID", "EMAIL ID NOT EXIST");
                }
                //
                else {
                    dangerAlert("PLEASE! ENTER EMAIL ID");
                }
            });

            $("button[name='verify-otp']").click(function() {
                let otp = "";
                $(".otp-input").toArray().forEach(ele => {
                    otp += ele.value;
                });

                if (otp != "" && otp.length == 6) {
                    sendAjaxReq({
                        otp: otp,
                        type: "otp"
                    }, "OTP VERIFIED SUCCESSFULLY", "INVALID OTP");
                }
                //
                else {
                    dangerAlert("PLEASE! FILL ALL DIGITS OF OTP");
                }
            });

            $("button[name='change-password']").click(function() {
                let newPass = $("input[name='new-password']").val();
                let confPass = $("input[name='confirm-password']").val();

                if (newPass != "" && newPass == confPass) {
                    sendAjaxReq({
                        password: newPass,
                        type: "password"
                    }, "PASSWORD CHANGED SUCCESFULLY", "SOMETHING WENT WRONG TRY AGAIN LATER");

                    location.href = "http://localhost/php/CashFlow/index.php";
                }
                //
                else dangerAlert("NEW PASSWORD AND CONFIRM PASSWORD HAS NOT BEEN MATCHED");
            });




            //! All Functions
            function sendAjaxReq(data, trueAlert, falseAlert) {
                $(".submit-btn").addClass("loading");
                $.ajax({
                    type: "POST",
                    url: "http://localhost/php/CashFlow/email/forgot-pass.php",
                    data: data,
                    success: function(res) {
                        if (res == "true") $(".alert").text(trueAlert);
                        else $(".alert").text(falseAlert);

                        showAlert({
                            type: data.type,
                            res: res
                        });
                    },
                    error: function() {
                        $(".alert").text("NETWORK ERROR - PLEASE! TRY AGAIN LATER");

                        showAlert("false");
                    }
                });
            }

            function showAlert(data) {
                if (data.res == "true") {
                    $(".alert").addClass("alert-success");
                    $(".alert").removeClass("alert-danger");
                }
                //
                else {
                    $(".alert").addClass("alert-danger");
                    $(".alert").removeClass("alert-success");
                }

                $("input[name='email']").val("");
                $(".alert").addClass("active");
                $(".submit-btn").removeClass("loading");

                if (data.res == "true") {
                    if (data.type == "email") {
                        $(".email-form").hide();
                        $(".otp-form").show();
                    } else if (data.type == "otp") {
                        $(".otp-form").hide();
                        $(".password-form").show();
                    } else {
                        $(".password-form").hide();
                        $(".email-form").show();
                    }
                }

                setTimeout(() => {
                    $(".alert").removeClass("active");
                }, 3000);
            }

            function dangerAlert(text) {
                $(".alert").addClass("alert-danger");
                $(".alert").removeClass("alert-success");
                $(".alert").text(text);
                $(".alert").addClass("active");

                setTimeout(() => {
                    $(".alert").removeClass("active");
                }, 3000);
            }
        });
    </script>
</body>

</html>