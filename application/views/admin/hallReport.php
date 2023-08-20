<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<?php include '../../../conn.php'; ?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Customer Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="adminDashboard.php">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h4 class="card-title">Hall DataTable</h4> -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" class="form-control" id="startDate">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="endDate">End Date</label>
                                        <input type="date" class="form-control" id="endDate">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary mt-4" id="showButton">Show</button>
                                </div>
                            </div>

                            <div class="table-responsive">

                                <table id="dtBasicExample" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>FullNAme</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Gmail</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
/* Custom styles for the table */
.dataTables_wrapper {
    padding: 20px;
}

.dataTables_filter {
    float: right;
}

.dataTables_paginate {
    float: right;
}
</style>

<!-- Include jQuery, Bootstrap, and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize the DataTable with options (including searching)
    var dataTable = $('#dtBasicExample').DataTable({
        searching: true
    });

    function fetchData(startDate, endDate) {
        // Make an AJAX request to the PHP file to fetch data from the database
        $.ajax({
            url: 'getData.php',
            type: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                // Parse the received JSON data
                var data = JSON.parse(response);

                // Clear the existing table rows
                dataTable.clear().draw();

                // Append the new data to the table
                for (var i = 0; i < data.length; i++) {
                    var row = [
                        data[i].custid,
                        data[i].firstname,
                        data[i].phone,
                        data[i].address,
                        data[i].email,
                        data[i].date
                    ];
                    dataTable.row.add(row).draw();
                }
            },
            error: function(error) {
                // Handle errors if needed
                console.log(error);
            }
        });
    }

    $('.dataTables_length').addClass('bs-select');

    // Get the current date and set it as the end date
    var currentDate = new Date();
    var endDate = currentDate.toISOString().split('T')[0]; // Format as 'YYYY-MM-DD'

    // Calculate the start date by subtracting 30 days from the end date
    var startDate = new Date(currentDate);
    startDate.setDate(startDate.getDate() - 1);
    startDate = startDate.toISOString().split('T')[0]; // Format as 'YYYY-MM-DD'

    // Set the input fields with the calculated date values
    $('#startDate').val(startDate);
    $('#endDate').val(endDate);

    // Fetch and display data based on the initial date range
    fetchData(startDate, endDate);

    // Add a click event listener to the 'Show' button
    $('#showButton').click(function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        fetchData(startDate, endDate);
    });
});
</script>