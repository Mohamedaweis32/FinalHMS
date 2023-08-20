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
                            <h4 class="mb-sm-0 font-size-18">Customer</h4>

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
                                                    <div class="mb-3">
                                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i class="mdi mdi-plus me-1"></i> Add Customer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="table-responsive">
                                            <table id="tblCustomer" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Full Name</th>
                                                        <th scope="col">Phone Number</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Created Date</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Action</th>
                                                    </tr>    
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // Select query
                                                        $sql = "SELECT * FROM customers WHERE 1";
                                                        $result = mysqli_query($conn, $sql);
                                                        $n=1;

                                                        // Check if the query was successful
                                                        if ($result) {
                                                            // Check if there are any rows returned
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $cid = $row['custid'];
                                                                    $address = $row['address'];
                                                                    $name = $row['firstname'];
                                                                    $email = $row['email'];
                                                                    $phone = $row['phone'];
                                                                
                                                                    $date = $row['date'];
                                                            
                                                                    // Display the data
                                                                    echo "<tr>";
                                                                    echo "<td>$n</td>";                         
                                                                    echo "<td>$name</td>";                         
                                                                    echo "<td>$email</td>";
                                                                
                                                                    echo "<td>$phone</td>";
                                                                    echo "<td>$date</td>";
                                                                    echo "<td>$address</td>";
                                                                    echo "<td>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-id='$cid'><i class='bx bxs-edit-alt'></i></a>
                                                                    </li>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-danger p-2 delete-btn' data-item-id='$cid'><i class='bx bxs-trash'></i></a>
                                                                </li></td>";
                                                                    echo "</tr>";
                                                                    $n++;
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='6'>No Customers found</td></tr>";
                                                            }
                                                        } else {
                                                            echo "Error: " . mysqli_error($conn);
                                                        }

                                                        mysqli_close($conn);
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
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

        <!-- Modal -->
        <div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderdetailsModalLabel">Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="customers" action="../../../apis/customers/customers.php" method="post">
                    <input type="hidden" class="form-control" id="cid" name="cid">
                            <div class="mb-3">
                                <label for="formrow-firstname-input" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="cname" name="cname" placeholder="Enter Fullname">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-address-input" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="number" name="number" placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-email-input" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                    
                                    <div class="mb-3">
                                        <label for="formrow-email-input" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Customer Email">
                                    </div>
                                    

                                
                                

                            </div>
                            <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"  id="btnCustomer">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                    </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end modal -->     
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
    <!-- Add this to your HTML file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <script>

        $(document).ready(function(){

            $('#tblCustomer').DataTable();
            $('.dataTables_length').addClass('bs-select');

            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var itemId = $(this).data('item-id');
                deleteItem(itemId);
            });
        
            $("#error").css("display", "none");
            $("#success").css("display", "none");
   
        })
            
        $("#customers").submit(function(e){   
            e.preventDefault();
            $.ajax({
                url:"../../../apis/customers/customers.php",
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
                                window.location.href = 'customer.php';
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
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
           
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var cid = parseInt($(this).data('id'), 10);
                $.ajax({
                    url: "../../../apis/customers/getCustomers.php",
                    type: 'POST',
                    data: { custid: cid },
                    success: function(response) {
                        
                        var customerData = JSON.parse(response);
                        
                        console.log(customerData.cname);
                        $('#cname').val(customerData.cname);
                        $('#cid').val(customerData.cid);
                        $('#address').val(customerData.caddress);
                        $('#number').val(customerData.cphone);
                        $('#email').val(customerData.cemail);
                
                
                    }
                });
            });
        });

        function deleteItem(itemId) {
            // Show SweetAlert confirmation popup
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'To delete this Customer',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicked "OK" (Confirmed), proceed with the deletion
                    $.ajax({
                        url: "../../../apis/customers/delete.php",
                        method: 'POST',
                        data: { itemId: itemId },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The item has been successfully deleted.',
                                timer: 2000, // The notification will automatically close after 2 seconds
                                showConfirmButton: false,
                            });
                            window.location.href = 'customer.php';
                        },
                        error: function (xhr, status, error) {
                            // Handle errors
                            console.error(error);
                        }
                    });
                } else {
                    // If the user clicked "Cancel," do nothing
                    console.log('Deletion canceled.');
                }
            });
        }

    </script>