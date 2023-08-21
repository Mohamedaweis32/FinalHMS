<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<?php include '../../../conn.php'; 

$email=$_SESSION['email'];
?>


<?php 
            
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM customers";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $customers = $row['total'];
            } else {
                $customers = 0;
            }
            $conn->close();
        ?>

<?php 
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT COUNT(*) AS num_bookings
            FROM bookings b LEFT join customers c on b.customer_id=c.custid 
            WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $num_bookings = $row['num_bookings'];
            } else {
                $num_bookings = 0;
            }
            $conn->close();
        ?>

<?php 
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT custid, 
            (SELECT SUM(credit) 
             FROM transactions 
             WHERE custid = c.custid) AS total_amount_paid
     FROM customers c
     WHERE email = '$email'
     ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total_amount_paid = $row['total_amount_paid'];
            } else {
                $total_amount_paid = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT custid, 
            (SELECT SUM(debit-credit) 
             FROM transactions 
             WHERE custid = c.custid) AS balance
     FROM customers c
     WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $balance = $row['balance'];
            } else {
                $balance = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM bookings WHERE booking_status = 0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pendingCount = $row['total'];
            } else {
                $pendingCount = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM bookings WHERE booking_status = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ApprovedCount = $row['total'];
            } else {
                $ApprovedCount = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM bookings WHERE booking_status not in (0,1)";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $CancelledCount = $row['total'];
            } else {
                $CancelledCount = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM bookings";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $TotalCount = $row['total'];
            } else {
                $TotalCount = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            $now = new DateTime();
            $SDate = $now->format('Y-m-01');
            $EDate = $now->format('Y-m-t');
            // Query to retrieve the data from the database
            $sql = "SELECT SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) as total FROM transactions WHERE created_at BETWEEN '$SDate' AND '$EDate';";
            $result = $conn->query($sql);       
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ThisMonth = $row['total'];
            } else {
                $ThisMonth = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            $SDate = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
            $EDate = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
            // Query to retrieve the data from the database
            $sql = "SELECT SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) as total FROM transactions WHERE created_at BETWEEN '$SDate' AND '$EDate'";
            $result = $conn->query($sql);       
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $PreMonth = $row['total'];
            } else {
                $PreMonth = 0;
            }
            $conn->close();
        ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card" id="editProfileCard">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-group"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Your Profile</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h6>Change Personal Info</h6>
                                        <div class="d-flex">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-hotel"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Number of Bookings</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $num_bookings; ?></h4>
                                        <div class="d-flex">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bxs-food-menu"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Amount Paid</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $total_amount_paid."$"; ?></h4>

                                        <div class="d-flex">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Balance</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $balance; ?></h4>

                                        <div class="d-flex">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Hall Analytics</h4>

                            <div>
                                <div id="donut-chart" class="apex-charts"></div>
                                <script src="../../../assets/js/pages/saas-dashboard.init.js"></script>
                            </div>
                            <div class="text-center text-muted">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mt-3">
                                            <p class="mb-2 text-truncate"><i
                                                    class="mdi mdi-circle text-primary me-1"></i>Pending Halls</p>
                                            <h5><?php echo $pendingCount; ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mt-3">
                                            <p class="mb-2 text-truncate"><i
                                                    class="mdi mdi-circle text-success me-1"></i>Approved Halls</p>
                                            <h5><?php echo $ApprovedCount; ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mt-3">
                                            <p class="mb-2 text-truncate"><i
                                                    class="mdi mdi-circle text-danger me-1"></i>Cancelled Halls</p>
                                            <h5><?php echo $CancelledCount; ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mt-3">
                                            <p class="mb-2 text-truncate"><i
                                                    class="mdi mdi-circle text-info me-1"></i>Total Halls</p>
                                            <h5><?php echo $TotalCount; ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-end">
                                    <div class="input-group input-group-sm">
                                        <select class="form-select form-select-sm" id="monthSelect"
                                            onchange="updateH4Value()">
                                            <option value="JA">Jan</option>
                                            <option value="FE">Feb</option>
                                            <option value="MR">Mar</option>
                                            <option value="AP">Apr</option>
                                            <option value="MA">May</option>
                                            <option value="JU">Jun</option>
                                            <option value="JL">Jul</option>
                                            <option value="AU">Aug</option>
                                            <option value="SE">Seb</option>
                                            <option value="OC">Oct</option>
                                            <option value="NO">Nov</option>
                                            <option value="DE">Dec</option>
                                        </select>
                                        <label class="input-group-text">Month</label>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Earning</h4>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-muted">
                                        <div class="mb-4">
                                            <p>This month</p>
                                            <h4><?php echo $ThisMonth; ?></h4>
                                            <div><span class="badge badge-soft-success font-size-12 me-1"> + 0.2%
                                                </span> From previous period</div>
                                        </div>

                                        <div>
                                            <a href="#" class="btn btn-primary waves-effect waves-light btn-sm">View
                                                Details <i class="mdi mdi-chevron-right ms-1"></i></a>
                                        </div>

                                        <div class="mt-4">
                                            <p class="mb-2">Last month</p>
                                            <h4 id="preMonthValue"><?php echo $PreMonth; ?></h4>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div id="line-chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div> -->

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="EditProfile" method="Post" action="ProfileUpdate.php">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName"
                                placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Password </label>
                            <input type="tel" class="form-control" id="pass" name="pass"
                                placeholder="Enter your phone number">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- End Page-content -->
</div>
<?php include 'footer.php'; ?>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<!-- Add this to your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Add the id attribute to the h4 element -->
<!-- Add the id attribute to the h4 element -->
<h4 id="preMonthValue"><?php echo $PreMonth; ?></h4>

<script>
function updateH4Value() {
    const selectedMonth = document.getElementById("monthSelect").value;
    const h4Element = document.getElementById("preMonthValue");

    const monthColumns = {
        "JA": "january_column",
        "FE": "february_column",
        "MR": "march_column",
        "AP": "april_column",
        "MA": "may_column",
        "JU": "june_column",
        "JL": "july_column",
        "AU": "august_column",
        "SE": "september_column",
        "OC": "october_column",
        "NO": "november_column",
        "DE": "december_column"
    };

    if (monthColumns[selectedMonth]) {
        const columnName = monthColumns[selectedMonth];
        fetchMonthValueFromDatabase('table_name', columnName).then(value => {
            h4Element.innerHTML = value;
        }).catch(error => {
            console.error(error);
            h4Element.innerHTML = "Error: Failed to fetch value";
        });
    } else {
        h4Element.innerHTML = "No data available for this month";
    }
}

function fetchMonthValueFromDatabase(tableName, columnName) {
    return fetch(`fetch_data.php?table=${tableName}&column=${columnName}`)
        .then(response => response.json())
        .then(data => {
            return data.total || 0;
        });
}



$(document).ready(function() {
    // When the "Edit Profile" card is clicked
    $('#editProfileCard').click(function() {
        // Fetch customer information using AJAX
        $.ajax({
            url: 'fetch_customer_info.php', // Replace with your backend endpoint
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Update the form fields with fetched data
                $('#fullName').val(response.customer.fullName);
                $('#email').val(response.customer.email);
                $('#phone').val(response.customer.phone);
                $('#pass').val(response.user.password);

                // Show the modal
                $('#profileModal').modal('show');
            },

            error: function(xhr, status, error) {
                console.error(error);
                //showAlert('danger', 'An error occurred while fetching data.'.status);
            },
            complete: function() {
                // This block will be executed regardless of success or error
            }
        });
    });




    $("#EditProfile").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "ProfileUpdate.php",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                var res = jQuery.parseJSON(resp);

                if (res.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'profile.php';
                        }
                    });
                } else if (res.status == 404) {
                    // Use SweetAlert for error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });
});
</script>