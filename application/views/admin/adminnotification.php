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
    LEFT JOIN transactions tr ON tr.custid = b.customer_id
    LEFT JOIN halls h ON h.hall_id = b.hall_id
    WHERE booking_status = 0
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
                                                    $hall = $row['hall_type'];
                                                    $credit = $row['credit'];
                                                    $debit = $row['debit'];
                                                    $date = date('Y-m-d', strtotime($row['created_at']));
                                                    $startTime = $row['starttime'];
                                                    $endTime = $row['endtime'];
                                                    $balance = $row['debit']-$row['credit'];
                                                    $bookingStatus = $row['booking_status'];

                                                    echo "<tr>";
                                                    echo "<td>" . $customer . "</td>";
                                                    echo "<td>" . $hall . "</td>";
                                                    echo "<td>" . $credit . "</td>";
                                                    echo "<td>" . $debit . "</td>";
                                                    echo "<td>" . $balance . "</td>";
                                                    echo "<td>" . $date . "</td>";
                                                    echo "<td>" . $startTime . "</td>";
                                                    echo "<td>" . $endTime . "</td>";
                                                  
                                                    echo "<td>";
                                                    if ($bookingStatus == 0) {
                                                        echo "Pending";
                                                    }
                                                    echo "</td>";
                                                    echo "<td>
                                                            <a href='#' class='text-success p-2 approve-btn' 
                                                               data-id='" . $row['booking_id'] . "'>
                                                               Approve
                                                           </a>
                                                           <a href='#' class='text-danger p-2 reject-btn' 
                                                              data-id='" . $row['booking_id'] . "'>
                                                              Reject
                                                          </a>
                                                          </td>";
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

    <script>
    // JavaScript/jQuery code for handling approve and reject buttons
    $(document).ready(function() {
        $('.approve-btn').on('click', function(event) {
            event.preventDefault();
            var bookingId = $(this).data('id');
            updateBookingStatus(bookingId, 'approve');
        });

        $('.reject-btn').on('click', function(event) {
            event.preventDefault();
            var bookingId = $(this).data('id');
            updateBookingStatus(bookingId, 'reject');
        });

        function updateBookingStatus(bookingId, status) {
            $.ajax({
                url: 'update_booking_status.php', // Replace with correct URL
                method: 'POST',
                data: {
                    bookingId: bookingId,
                    bookingStatus: status
                },
                success: function(response) {
                    // Handle the response if needed
                    window.location.href = "adminnotification.php";
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        }
    });
    </script>
</body>

</html>