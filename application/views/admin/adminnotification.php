<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>
    <!-- Include your CSS and JS libraries here -->
</head>

<body>
    <?php
    session_start();
    require_once 'auth.php';

    include_once '../../../conn.php';
    include_once 'nav.php';
    include_once 'header.php';
    include_once 'footer.php';

    $sql = "SELECT * FROM bookings b
    LEFT JOIN customers c ON b.customer_id = c.custid
    LEFT JOIN halls h ON h.hall_id = b.hall_id
    LEFT JOIN transactions tr ON tr.refID = c.custid

    WHERE b.booking_status = 0 
    ORDER BY b.booking_id DESC";
    $query = mysqli_query($conn, $sql);
    ?>

    <center>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="all-order" role="tabpanel">
                                <!-- Filter and search form here if needed -->

                                <div class="table-responsive">
                                    <table id="tblCustomer" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Hall</th>
                                                <th>Due</th>
                                                <th>Paid</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($query) {
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    // Extract relevant data
                                                    $customer = $row['firstname'];
                                                    $bid = $row['booking_id'];
                                                    $hall = $row['hall_type'];

                                                    $credit = $row['credit'];

                                                    $debit = $row['debit'];
                                                    $date = date('Y-m-d', strtotime($row['created_at']));
                                                    $startTime = $row['starttime'];
                                                    $endTime = $row['endtime'];
                                                    $balance = $row['debit'] - $row['credit'];
                                                    $bookingStatus = $row['booking_status'];


                                                    echo "<tr>";
                                                    echo "<td>" . $customer . "</td>";
                                                    echo "<td>" . $hall . "</td>";
                                                    if ($credit == 0) {
                                                        echo "<td>0$</td>";
                                                    } else {
                                                        echo "<td>{$credit}$</td>";
                                                    }
                                                    if ($debit == 0) {
                                                        echo "<td>0$</td>";
                                                    } else {
                                                        echo "<td>{$debit}$</td>";
                                                    }

                                                    echo "<td>" . $date . "</td>";

                                                    echo "<td>" . $startTime . "</td>";
                                                    echo "<td>" . $endTime . "</td>";
                                                    echo "<td>" . $balance . "</td>";

                                                    echo "<td>";
                                                    if ($bookingStatus == 0) {
                                                        echo "Pending";
                                                    }
                                                    echo "</td>";
                                                    echo "<td>
                                                    <li class='list-inline-item'>
                                                    <a href='#' class='text-success p-2 approve-btn'  data-id='$bid'><i class='fas fa-check-circle'></i></a>
                                                    </li>
                                                    <li class='list-inline-item'>
                                                    <a href='#' class='text-danger p-2 reject-btn' data-id='$bid'> <i class='fas fa-times-circle'></i></a>
                                                </li></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='10'>No Records Found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <!-- Add Bootstrap JS (Optional) -->
    <!-- You can include it at the end of the body tag if needed -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>  -->
</body>

</html>
<!-- Include jQuery library -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<!-- JavaScript/jQuery code -->
<script>
    // Function to handle the "Approve" button click
    $('.approve-btn').on('click', function (event) {
        event.preventDefault();
        var aproveid = $(this).data('id');

        // Send AJAX request to update the booking_status
        $.ajax({
            url: 'update_booking_status.php', // Replace with your PHP script URL
            method: 'POST',
            data: {
                aproveid: aproveid,
                booking_status: 'approve', // Change to 'rejected' for the Reject button

            },
            success: function (response) {
                // Handle the response if needed
                window.location.href = "adminnotification.php";
            },
            error: function (xhr, status, error) {
                // Handle errors if any
                console.error(error);
            }
        });
    });

    // Function to handle the "Reject" button click
    $('.reject-btn').on('click', function (event) {
        event.preventDefault();
        var rid = $(this).data('id');

        // Send AJAX request to update the booking_status
        $.ajax({
            url: 'update_booking_status.php', // Replace with your PHP script URL
            method: 'POST',
            data: {
                rid: rid,
                booking_status: 'reject', // Change to 'approved' for the Approve button
            },
            success: function (response) {
                // Handle the response if needed
                window.location.href = "adminnotification.php";
            },
            error: function (xhr, status, error) {
                // Handle errors if any
                console.error(error);
            }
        });
    });
</script>