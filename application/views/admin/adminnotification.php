
<style>
    .mt5{
        margin-top: -55%;
    }
</style>
<?php
session_start(); 

require_once 'auth.php';

 include_once '../../../conn.php'; 
 include_once 'nav.php'; 
include_once 'header.php'; 
include_once 'footer.php'; 


// Retrieve the bookings for the customer from the database
$sql = "SELECT * FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.custid
        LEFT JOIN halls h on h.hall_id=b.hall_id where booking_status=0 
        order by b.booking_id desc
       ";
$query = mysqli_query($conn, $sql);
if($query){
?>
<center>
<div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Tab panes -->
                                <div class="tab-content p-3">
                                    <div class="tab-pane active" id="all-order" role="tabpanel">
                                        <form>
                                            <div class="row">
                                                <div class="col-xl col-sm-6">
                                                </div>
                                                <div class="col-xl col-sm-6">
                                                </div>
                                                <div class="col-xl col-sm-6">
                                                </div>
                                                <div class="col-xl col-sm-6">
                                                </div>
                                                <div class="col-xl col-sm-6">
                                                </div>
                                                <div class="col-xl col-sm-6 align-self-end">
                                                   
                                                </div>
                                            </div>
                                        </form>



        <div class="table-responsive">
            <table id="tblCustomer" class="table table-bordered dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Hall</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                

              
                while ($row = mysqli_fetch_assoc($query)) {
                    $starttime_seconds = strtotime($row['starttime']);
                    $endtime_seconds = strtotime($row['endtime']);
                    // Step 2: Calculate the total time in seconds
                    $total_seconds =$starttime_seconds -$endtime_seconds ;
                    // Step 3: Calculate the total time in hours
                    //$total_hours = $total_seconds / 3600;
                    // Display each booking as a row in the table
                    $bid=$row['booking_id'];
                    $hall=$row['hall_type'];
                    // Step 1: Create a DateTime object from the datetime string
                    $datetime = new DateTime($row['created_at']);
                    // Step 2: Format the DateTime object to display only the date
                    $date = $datetime->format('Y-m-d');
                    echo "<tr>";
                    echo "<td>" . $bid . "</td>";
                    echo "<td>" . $hall. "</td>";
                    // echo "<td>" . $row['starttime'] . "</td>";
                    echo "<td>" . $date. "</td>";
                    echo "<td>" . $total_seconds . " hours</td>";
                    // echo "<td>" . $row['endtime'] . "</td>";
                    $bstatus = $row['booking_status'];
                    echo "<td>";
                    if ($bstatus == 0) {
                        echo "Your booking is Pending";
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
            }
            else{
                ?>
                <span> No Records Found</span>
                <?php
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
                booking_status: 'reject',// Change to 'approved' for the Approve button
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
