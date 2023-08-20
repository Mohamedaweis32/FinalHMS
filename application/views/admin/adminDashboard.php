<?php
require_once 'header.php'; ?>
<?php include 'nav.php'; 

// ... rest of your code ...
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php 
            include '../../../conn.php';
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
            $sql = "SELECT count(*) as total FROM halls";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $halls = $row['total'];
            } else {
                $halls = 0;
            }
            $conn->close();
        ?>

<?php 
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM food";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $food = $row['total'];
            } else {
                $food = 0;
            }
            $conn->close();
        ?>

<?php
            include '../../../conn.php';
            // Query to retrieve the data from the database
            $sql = "SELECT count(*) as total FROM users";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $users = $row['total'];
            } else {
                $users = 0;
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-group"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Customers</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $customers; ?></h4>
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
                                        <h5 class="font-size-14 mb-0">Halls</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $halls; ?></h4>
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
                                        <h5 class="font-size-14 mb-0">Food</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $food; ?></h4>

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
                                        <h5 class="font-size-14 mb-0">Users</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4><?php echo $users; ?></h4>

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
            <div class="row">
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
    </div>
    <!-- End Page-content -->
</div>
<?php include 'footer.php'; ?>
<!-- Include jQuery -->
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
</script>