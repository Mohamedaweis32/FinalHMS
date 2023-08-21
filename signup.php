<?php 
    session_start();            
    include 'conn.php';
    // Check if the login form is submitted
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Query the database for the user
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Set up the session with user information
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['username'] = $row['username'];        
            print_r($row['email']);
            $_SESSION['email'] = $row['email'];       
            // Redirect to the appropriate dashboard
            if ($_SESSION['type'] === 'admin') {
                header("Location: application/views/admin/adminDashboard.php");
                
            exit();
            } 
                header("Location: application/views/customer/dashboard.php");
           
            exit();
        } else {
            // Handle invalid login credentials
            $error_message = "Invalid username or password!";
        }
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
                        <h5 class="text-center text-primary ">Welcome Back !</h5>
                        <?php if(isset($error_message)) { ?>
                        <p class="error-message"><?php echo $error_message; ?></p>
                        <?php } ?>

                        <form id="signupForm" action="signupHandler.php" style="padding-left:20% ;padding-right:20%;">
                            <div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Full Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="Address"
                                    placeholder="Enter Address">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="Phone"
                                    placeholder="Enter Phone">
                            </div>

                            <div class="mb-3">
                                <div class="float-end">

                                </div>
                                <label class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Enter password" aria-label="Password"
                                        aria-describedby="password-addon">
                                    <button class="btn btn-light " type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                                <label class="form-label">Confirm Password </label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" id="Confirm" name="confirmPassword" class="form-control"
                                        placeholder="Enter Confirm password" aria-label="Password"
                                        aria-describedby="password-addon">
                                    <button class="btn btn-light " type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-check">
                                <label class="form-check-label" for="remember-check">
                                    Remember me
                                </label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">sign Up</button>
                            </div>
                        </form>
                        <div class="mt-5 text-center">
                            <p>ALready exsist? <a href="login.php" class="fw-medium text-primary">
                                    Log In Now </a> </p>
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

</body>

</html>
<script>
 $('#signupForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission behavior

        // Collect form data
        var formData = $(this).serialize();

        // AJAX request
        $.ajax({
            url: 'signupHandler.php',
            type: 'POST',
            data: formData,
            success: function(resp) {
                var res = jQuery.parseJSON(resp);
                if (res.status == 200) {
                    // User created successfully
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                    }).then(function() {
                        window.location.href = "login.php"; // Redirect to success page
                    });
                } else {
                    // Failed to create user
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle error response from the server
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + error,
                });
            }
        });
    });
});
</script>