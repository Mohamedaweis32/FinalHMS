<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8" />
    <title>HMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../../assets/images/ArmaanHall.ico">
    <!-- Bootstrap Css -->
    <link href="../../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Add this to your HTML file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>


<body data-topbar="dark" data-layout="horizontal">
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <?php

                session_start();

                require_once "auth.php";
                ?>
                <div class="d-flex">
                </div>


                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <span class="badge bg-danger rounded-pill" id="notificationCount"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small" key="t-view-all" onclick="updateViewStatus()"> Mark
                                            Read</a>
                                    </div>
                                </div>
                            </div>
                            <div id="notificationsContainer" data-simplebar style="max-height: 230px;"></div>

                            <div class="p-2 border-top d-grid">
                                <a href="bookingsHistory.php" id="viewAllNotificationsLink"
                                    class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                        More..</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="../../../assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            <?php
                            require_once '../../../conn.php';
                            $email = $_SESSION['email'];

                            $sql = "SELECT * FROM customers WHERE email='$email'";
                            $query = mysqli_query($conn, $sql);

                            if ($query && mysqli_num_rows($query) > 0) {
                                $data = mysqli_fetch_array($query);
                                $name = $data['firstname'];
                            } else {
                                $name = "Customer named is not found";
                            }

                            ?>
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">
                                <?php echo $name; ?>
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="../../../login.php"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Logout</span></a>
                        </div>

                    </div>
                </div>

            </div>
        </header>




        <!-- Add jQuery library (Make sure to download the latest version and adjust the URL accordingly) -->
        <!-- Google CDN link for the latest version of jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.x.x/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


        <script>
            // Function to update the notification count using AJAX
            function updateNotificationCount() {
                $.ajax({
                    url: 'notification_count_endpoint.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        // Update the notification count element
                        $('#notificationCount').text(data.count);
                    },
                    error: function () {
                        // Handle AJAX error here
                        $('#notificationCount').text('Error loading notification count.');
                    }
                });
            }

            // Call the function to update the notification count initially
            updateNotificationCount();

            // Set an interval to update the notification count every few seconds (e.g., 10 seconds)
            setInterval(updateNotificationCount, 10000);

            $(document).ready(function () {
                // Add a click event listener to the "View All" link
                $('#viewAllNotificationsLink').on('click', function (event) {
                    event.preventDefault(); // Prevent the default link behavior
                    var url = $(this).attr('href'); // Get the URL from the link's 'href' attribute

                    // Redirect to the "notification.php" page
                    window.location.href = url;
                });
            });

            function updateViewStatus() {
                // Get the notificationCount element
                var notificationCountElement = $("#notificationCount");

                // Get the current value of notificationCount (number of notifications)
                var notificationCount = parseInt(notificationCountElement.text());

                // If there are notifications (count > 0), update the view_status via AJAX
                if (notificationCount > 0) {
                    // Prepare the data to send in the request
                    var data = {
                        view_status: 1
                    };

                    // Send the AJAX request with jQuery
                    $.ajax({
                        type: "POST",
                        url: "../admin/update_view_status.php",
                        data: data,
                        success: function (response) {
                            // Handle successful response here
                            // You can update the UI or perform other actions
                        },
                        error: function (xhr, status, error) {
                            // Handle AJAX error here
                            console.error(error);
                        }
                    });

                    // Update the notificationCount display (optional)
                    notificationCountElement.text("0");
                }
            }

            function fetchNotifications() {
                $.ajax({
                    url: 'fetch_notifications.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var notificationsContainer = $('#notificationsContainer');
                        notificationsContainer.empty();

                        $.each(data, function (index, notification) {
                            var notificationHtml = `
                                <a href="javascript:void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-cart"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">`;

                            if (notification.status == 1) {
                                notificationHtml += `Thank you for booking with us ${notification.firstname}`;
                            } else if (notification.status == 2) {
                                notificationHtml += `Your booking is cancelled ${notification.firstname}`;
                            }

                            notificationHtml += `</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>${notification.time}</span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                `;
                            notificationsContainer.append(notificationHtml);
                        });
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error here
                        console.error(error);
                    }
                });
            }

            // Fetch notifications initially and then fetch every 30 seconds
            fetchNotifications();
            setInterval(fetchNotifications, 30000);
        </script>
</body>

</html>