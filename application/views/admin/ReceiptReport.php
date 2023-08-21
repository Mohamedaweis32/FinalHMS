<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<?php include '../../../conn.php'; ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Receipt Reports</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
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
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="statusFilter">Booking Status</label>
                                        <select class="form-control" id="statusFilter">
                                            <option value="">All</option>
                                            <?php
                                            $sql = "SELECT * FROM customers";
                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $customerId = $row['custid'];
                                                $customerName = $row['firstname'];
                                                echo "<option value='$customerId'>$customerName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
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
                                    <button type="button" class="btn btn-secondary mt-4" id="printButton">Print</button>
                                </div>
                            </div>
                            <div class="table-responsive">

                                <table id="dtBasicExample" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>CustID</th>
                                            <th>Customer Name</th>
                                            <th>RefID</th>
                                            <th>Amount</th>
                                            <th>Trantype</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                            <th>Action Date</th>
                                            <!-- Add more <th> elements for any other transaction columns you have -->
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
.dataTables_wrapper {
    padding: 20px;
}

.dataTables_filter {
    float: right;
}

.dataTables_paginate {
    float: right;
}

#dtBasicExample th,
td {
    text-align: center;
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

    $('#printButton').click(function() {
        // Create a new print window
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Receipt Report</title>');
        // Include necessary styles for printing
        printWindow.document.write(
            '<style>@media print { table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; text-align: center; } h1 { text-align: center; } }</style>'
        );
        printWindow.document.write('</head><body>');

        // Add a heading above the table
        printWindow.document.write('<h1>Booking Report</h1>');

        // Get the table's HTML content
        var tableContent = $('#dtBasicExample').prop('outerHTML');

        // Write the table content to the print window
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');

        // Print and close the print window
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });
    // Center-align text in all DataTable cells
    dataTable.cells().every(function() {
        $(this.node()).addClass('text-center');
    });

    function fetchData(startDate, endDate, statusFilter) {
        // Make an AJAX request to the PHP file to fetch data from the database
        $.ajax({
            url: 'getReceiptReport.php',
            type: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                console.log(response); // Check the response in the console to verify its structure

                // Clear the existing table rows
                dataTable.clear().draw();

                // Append the new data to the table
                for (var i = 0; i < response.length; i++) {
                    if (statusFilter === '' || response[i].custid === statusFilter) {
                        var row = [
                            response[i].custid,
                            (statusFilter === '' || response[i].custid !== statusFilter) ?
                            response[i].firstname : response[i].firstname,
                            response[i].refID,
                            response[i].amount,
                            response[i].tranType,
                            response[i].credit,
                            response[i].Balance,
                            response[i].transactionDate
                        ];
                        dataTable.row.add(row).draw();

                    }
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
    fetchData(startDate, endDate, '');

    // Add a click event listener to the 'Show' button
    $('#showButton').click(function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var statusFilter = $('#statusFilter').val(); // Get the selected status filter
        fetchData(startDate, endDate, statusFilter);
    });
});
</script>