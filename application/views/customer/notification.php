
<style>
    .mt5{
        margin-top: -55%;
    }
</style>

<?php 
 include_once '../../../conn.php'; 
include_once 'header.php'; 

include_once 'footer.php'; 
// include_once 'nav.php'; 
?>
 

<?php

$email = $_SESSION['email'];
// Retrieve the bookings for the customer from the database
$sql = "SELECT * FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.custid
        WHERE c.email = '$email' and booking_status in (1,2)";
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
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    // Display each booking as a row in the table
                    $bid=$row['booking_id'];
                    echo "<tr>";
                    echo "<td>" . $row['booking_id'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    $bstatus = $row['booking_status'];
                    echo "<td>";
                    if ($bstatus == 1) {
                        echo "Your booking is approved";
                    } else if ($bstatus == 2) {
                        echo "Your booking is cancelled";
                    }
                    echo "</td>";
                    echo "<td>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-id='$bid'><i class='bx bxs-edit-alt'></i></a>
                                                                    </li>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-danger p-2 delete-btn' data-item-id='$bid'><i class='bx bxs-trash'></i></a>
                                                                </li></td>";
                    echo "</tr>";
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
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script> -->
</body>
</html>
