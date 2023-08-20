<?php
session_start();
// Establish your database connection ($conn) here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Assuming the email is submitted through a form

    // Escape the email input to prevent SQL injection
    $safeEmail = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM Users WHERE email='$safeEmail'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $record = mysqli_fetch_assoc($result);

        if ($record) {
            // Email exists in the database, you can proceed to show OTP form
            $_SESSION['email'] = $safeEmail;
            header("Location: forgot_password.html?step=otp");
        } else {
            // Email doesn't exist in the database
            header("Location: forgot_password.html?error=email_not_found");
        }
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }

    // Don't forget to close the database connection when you're done
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">


<!-- Mirrored from skote-h-light.codeigniter.themesbrand.com/auth-login-2 by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Jun 2023 12:23:26 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8" />
    <title>Login 2 | Skote - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- CSS styles -->
    <style>
    .sign {
        background: #00487a;
        /* background: #485ec4; */
    }

    .log {
        background: #FFFFFF;
    }


    .text-center {
        margin-top: 70px;
    }

    .btn-primary {
        color: #fff;
        background-color: #00487a !important;
        border-color: #00487a !important;
    }

    .full-height-container {
        height: 100vh;
    }

    .error-message {
        color: red;
        font-size: 16px;
        margin-top: 10px;
        margin-left: 20px;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .otp-form-wrapper {
        max-width: 500px;
        margin: 0 auto;
    }

    .form-number {
        width: 100%;
        height: 50px;
        border-radius: 0px;
        background: #ffffff;
        border: 1px solid #c0c0c0;
        padding: 12px 19px;
        font-size: 16px;
        line-height: 1.2;
        font-weight: 400;
        color: #212121;
        transition: all 0.3s ease-in-out;
        outline: none !important;
        text-align: center;
    }

    .form-number:focus {
        border-color: #000;
    }

    .code-inputs {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }
    </style>

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container-fluid full-height-container ">
        <div class="row">
            <div class="sign col-xl-6 min-vh-100">


                <div style="border-radius: 10px 0 0 10px;">
                    <div class="">
                        <div>
                            <div class="bg"></div>
                            <div class="d-flex flex-column">

                                <div class="p-12 mt-auto ">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10" style="padding-top:25%;">
                                            <div class=" text-center">

                                                <h4 class="mb-4 text-white pt-12"><i
                                                        class="bx bxs-quote-alt-left text-white h1 align-middle me-3"></i><span
                                                        class="text-white">5k</span>+ Satisfied clients <i
                                                        class="bx bxs-quote-alt-right text-white h1 align-middle me-3"></i>
                                                </h4>
                                                <div dir="ltr" class="mt-20">
                                                    <div class="owl-carousel owl-theme auth-review-carousel"
                                                        id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-6">
                                                                <p class="font-size-16 mb-6 text-white t">
                                                                    Fantastic
                                                                    theme with a ton of options.
                                                                    If you just want the HTML to integrate with your
                                                                    project,
                                                                    then this is the package. You can find the files
                                                                    in
                                                                    the 'dist' folder...
                                                                    no need to install git and all the other stuff
                                                                    the
                                                                    documentation talks about. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-white">Aweys</h4>
                                                                    <p class="font-size-14 mb-0 text-white">- Skote
                                                                        User
                                                                    </p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <!-- end col -->
            </div>
            <div class="log col-xl-6 min-vh-100"
                style="border-radius: 0 10px 10px 0;  box-shadow: 5px 5px 10px rgb(49 48 48 / 50%);">

                <div class="d-grid justify-coneten-center align-items-center min-vh-100">
                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <h5 class="text-center text-primary" id="headerTitle">Forget Password</h5>
                        <div class="text-center" id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </div>

                        <!-- Email Form -->
                        <div id="emailColapse" style="padding-left:20% ;padding-right:20%;">
                            <form action="#" method="post" id="emailForm">
                                <div class="alert alert-danger text-center" id="emailNotFoundMessage"
                                    style="display: none;">
                                    Email not found in the database.
                                </div>
                                <div class="">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Email">
                                </div>
                                <button class="btn btn-primary waves-effect waves-light mt-4 float-end" type="submit"
                                    id="checkEmailButton">Check Email</button>

                            </form>
                        </div>

                        <!-- OTP Form -->
                        <form action="" method="post" style="padding-left:20% ;padding-right:20%;display: none;"
                            id="otpForm">
                            <div class="alert alert-danger text-center" id="otpMessage" style="display: none;">
                                your otp is wrong! please make sure you put here the otp we send you.
                            </div>
                            <div class="otp-form-wrapper" id="otpColapse">
                                <div class="code-inputs">
                                    <input type="number" maxlength="1" class="form-control form-number">
                                    <input type="number" maxlength="1" class="form-control form-number">
                                    <input type="number" maxlength="1" class="form-control form-number">
                                    <input type="number" maxlength="1" class="form-control form-number">
                                </div>
                                <button id="backToEmail" class="btn btn-secondary mt-3 btn-sm flot-end">Back to
                                    Email</button>
                            </div>
                        </form>
                        <form action="change_password.php" method="post"
                            style="padding-left:20% ;padding-right:20%;display: none;" id="changePasswordForm">
                            <div class="alert text-center" id="changeMessage" style="display: none;">

                            </div>
                            <div class="mb-3">

                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    placeholder="Enter new password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Confirm password">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Change
                                    Password</button>
                            </div>
                        </form>
                        <div class="mt-5 text-center">
                            <p>If You Are Customer ? <a href="login.php" class="fw-medium text-primary">Remember</a>
                            </p>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
    <!-- end container-fluid -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <!-- owl.carousel js -->
    <script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>

    <!-- auth-2-carousel init -->
    <script src="assets/js/pages/auth-2-carousel.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
    function auto_tab_input() {
        $(".code-inputs .form-control").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).nextAll(".code-inputs .form-control:enabled:first").focus();
            }
        });
    }

    function auto_backspace() {
        $(".code-inputs .form-control").keyup(function(e) {
            if (e.keyCode == 8) {
                if ($(this).prev().length > 0) {
                    $(this).prev("input").focus();
                }
            }
        });
    }

    $(document).ready(function() {
        auto_tab_input();
        auto_backspace();
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

    <script>
    function BackToEmail() {
        $("#emailColapse").show();
        $("#otpColapse").hide();
        $("#changeColopse").hide();
        $("#headerTitle").text("Forget Password");
    };

    function generateOTP() {
        var otp = "";
        var digits = "0123456789";

        for (var i = 0; i < 4; i++) {
            otp += digits[Math.floor(Math.random() * 10)];
        }

        return otp;
    }
    var Otp;
    $(document).ready(function() {
        const $loadingElement = $("#loading");

        $("#checkEmailButton").click(function(event) {
            event.preventDefault(); // Prevent form submission

            const email = $("#email").val().trim();
            if (email) {
                showLoading();
                // Send email to the API using AJAX
                $.ajax({
                    url: "apis/ForgetPassword/check_existance_of_email.php",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(response) {

                        if (response === "email_exists") {
                            // Show OTP form elements
                            var email = $("#email").val()
                            Otp = generateOTP();
                            console.log(Otp)
                            $.ajax({
                                type: 'POST',
                                url: 'apis/ForgetPassword/veryfy_otp.php', // Update with the actual path to your PHP script
                                data: {
                                    email: email,
                                    otp: Otp
                                },
                                success: function(response) {

                                    $("#emailColapse").hide();
                                    $("#emailNotFoundMessage").hide();
                                    $("#otpForm").show();
                                    $("#headerTitle").text("Enter OTP");
                                    hideLoading();

                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        } else if (response === "email_not_found") {
                            $("#emailNotFoundMessage").show();
                        } else {
                            console.log("Error: " + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error: " + error);
                    }
                });
            }
        });

        function showLoading() {
            $loadingElement.show();
            $("#emailNotFoundMessage").hide();
        }

        function hideLoading() {
            $loadingElement.hide();
        }



        const $otpInputs = $('.form-number'); // Select all OTP input fields
        const $otpForm = $('#otpForm'); // Select the OTP form
        const $emailForm = $('#emailForm'); // Assuming there's an email form with this ID

        // Back to Email button click handler
        $('#backToEmail').click(function(e) {
            e.preventDefault();
            $otpForm.hide();
            $emailForm.show();
        });

        // Listen for input changes in OTP fields
        $otpInputs.on('input', function() {
            const otpValue = getCompleteOTP();
            if (otpValue.length === 4) {
                showLoading();

                // Simulate a 2-second delay using setTimeout
                setTimeout(function() {
                    if (otpValue === Otp) {
                        $("#headerTitle").text("CHANGE PASSWORD");
                        $("#changePasswordForm").show();
                        $("#otpMessage").hide();
                        $("#otpForm").hide();
                        hideLoading();
                    } else {
                        $("#changePasswordForm").hide();
                        $("#otpMessage").show();
                        $("#otpForm").show();
                        hideLoading();
                    }
                }, 2000); // 2000 milliseconds = 2 seconds
            }
        });


        // Function to get the complete entered OTP value
        function getCompleteOTP() {
            let otpValue = '';
            $otpInputs.each(function() {
                otpValue += $(this).val();
            });
            return otpValue;
        }



        const $newPasswordInput = $('#newPassword');
        const $confirmPasswordInput = $('#confirmPassword');
        const $changePasswordForm = $('#changePasswordForm');

        $changePasswordForm.submit(function(event) {
            event.preventDefault(); // Prevent form submission

            const newPassword = $newPasswordInput.val();
            const confirmPassword = $confirmPasswordInput.val();

            // Passwords match
            showLoading();

            // Send AJAX request to change password
            $.ajax({
                url: 'apis/ForgetPassword/change_password.php', // Update with the actual path to your PHP script
                method: 'POST',
                data: {
                    newPassword: newPassword,
                    confirmPassword: confirmPassword,
                    email: $("#email").val()
                },
                success: function(response) {
                    console.log(response)
                    var trimmedResponse = response.trim();
                    if (trimmedResponse == "Password updated successfully") {

                        $("#changeMessage").text(response);
                        $("#changeMessage").addClass('alert-success');
                        $("#changeMessage").show();
                        window.location.href = "login.php";
                    } else {
                        $("#changeMessage").text(response);
                        $("#changeMessage").addClass('alert-danger');
                        $("#changeMessage").show();
                    }
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    $("#changeMessage").text(error);
                    $("#changeMessage").addClass('alert-danger');
                    $("#changeMessage").show();
                    hideLoading();
                }
            });

        });
    });
    </script>




</body>

</html>