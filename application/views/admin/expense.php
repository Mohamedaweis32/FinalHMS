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
                                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i class="mdi mdi-plus me-1"></i> Add Expense</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="table-responsive">
                                            <table id="tblCustomer" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Expense Type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Paid</th>
                                                        <th scope="col">Due</th>
                                                        <th scope="col">Created Date</th>
                                                   
                                                        <th scope="col">Action</th>
                                                    </tr>    
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // Select query
                                                     $sql="SELECT 
                                                  e.expenseid as expenseid,
                                                    e.type as type,
                                                    e.amount as amount,
                                                    SUM(tr.credit) as credit,
                                                    SUM(tr.debit - tr.credit) as due,
                                                    e.date as date
                                                    
                                                 FROM 
                                                     expenses e
                                                 LEFT JOIN 
                                                     transactions tr ON e.expenseid = tr.refID
                                                 GROUP BY 
                                                     e.expenseid, e.type, e.amount;
                                                 ";
                                                        $result = mysqli_query($conn, $sql);
                                                        $n=1;

                                                        // Check if the query was successful
                                                        if ($result) {
                                                            // Check if there are any rows returned
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $expid = $row['expenseid'];
                                                                    $type = $row['type'];
                                                                    $amount = $row['amount'];
                                                                    $due = $row['due'];
                                                                    $paid = $row['credit'];
                                                                    $date = $row['date'];
                                                                
                                                        
                                                            
                                                                    // Display the data
                                                                    echo "<tr>";
                                                                    echo "<td>$n</td>";                         
                                                                    echo "<td>$type</td>";                         
                                                                    echo "<td>$amount</td>";
                                                              
                                                                    echo "<td>$paid</td>";
                                                                    echo "<td>$due</td>";
                                                                    echo "<td>$date</td>";
                                                                
                                                                    echo "<td>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal'  data-item-id='$expid'><i class='bx bxs-edit-alt'></i></a>
                                                                    </li>
                                                                    <li class='list-inline-item'>
                                                                    <a href='#' class='text-danger p-2 delete-btn' data-item-id='$expid'><i class='bx bxs-trash'></i></a>
                                                                    <a href='#' class='text-info p-2 pay-btn' data-bs-toggle='modal' data-bs-target='.payModal' data-item-id='$expid'><i class='bx bxs-box'></i></a>
                                                                </li></td>";
                                                                
                                                                    echo "</tr>";
                                                                    $n++;
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='6'>No Expenses found</td></tr>";
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
                        <h5 class="modal-title" id="orderdetailsModalLabel">Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="Expense" action="../../../apis/expenses/expense.php" method="post">
    <input type="hidden" class="form-control" id="expense_id" name="expense_id">
    
    <div class="mb-3">
        <label for="formrow-expense-type-input" class="form-label">Expense Type</label>
        <input type="text" class="form-control" id="expense_type" name="expense_type" placeholder="Enter Expense Type">
    </div>

    <div class="row">
      
            <div class="mb-3">
                <label for="formrow-amount-input" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Expense Amount">
            </div>
    
      
    </div>

    <div class="row">
        <div class="mb-3">
            <label for="formrow-description-input" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Expense Description"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnExpense">Save Expense</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
    </div>
</form>

                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end modal -->   
         <!-- Payment modal -->
         <div class="modal fade payModal" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderdetailsModalLabel">Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="Pay" action="../../../apis/expenses/pay.php" method="post">
    <input type="hidden" class="form-control" id="payid" name="payid">
    <input type="hidden" class="form-control" id="expensesId" name="expensesId">
    <div class="row">
      
      <div class="mb-3">
          <label for="formrow-amount-input" class="form-label">Expense Type</label>
          <input type="text" class="form-control" id="extype" name="extype" placeholder="Enter Expense type">
      </div>
      <div class="mb-3">
          <label for="formrow-amount-input" class="form-label">Expense due</label>
          <input type="number" class="form-control" id="expdue" name="expdue" placeholder="Enter Expense Due">
      </div>


</div>
    <div class="mb-3">
        <label for="formrow-expense-type-input" class="form-label">Payment Type</label>
        <select name="paytype" class="form-control" id="paytype" >
            <option value="">Choose Payment Type</option>
            <option value="EVC">EVC</option>
            <option value="">EDAHAB</option>
            <option value="">Premier Wallet</option>
        </select>
    </div>

    <div class="row">
      
            <div class="mb-3">
                <label for="formrow-amount-input" class="form-label">Amount</label>
                <input type="number" class="form-control" id="payamount" name="payamount" placeholder="Enter Expense Amount">
            </div>
    
      
    </div>



    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnExpense">Save Payment</button>
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
            
        $("#Expense").submit(function(e){   
            e.preventDefault();
            $.ajax({
                url:"../../../apis/expenses/expense.php",
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
                                window.location.href = 'expense.php';
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
        $("#Pay").submit(function(e){   
            e.preventDefault();
            $.ajax({
                url:"../../../apis/expenses/Pay.php",
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
                                window.location.href = 'expense.php';
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

                var expense_id = parseInt($(this).data('item-id'), 10);
             
                $.ajax({
                    url: "../../../apis/expenses/getExpense.php",
                    type: 'POST',
                    data: { expense_id: expense_id },
                    success: function(response) {
                        
                        var customerData = JSON.parse(response);
                        
                        // console.log(customerData.type);
                        $('#amount').val(customerData.amount);
                        $('#expense_type').val(customerData.type);
                        $('#expense_id').val(customerData.expid);
                        $('#description').val(customerData.desc);

                
                    }
                });
            });
        });
        $(document).ready(function() {
            $('.pay-btn').click(function() {

                var expense_id = parseInt($(this).data('item-id'), 10);
             
                $.ajax({
                    url: "../../../apis/expenses/getExpense.php",
                    type: 'POST',
                    data: { expense_id: expense_id },
                    success: function(response) {
                        
                        var customerData = JSON.parse(response);
                        
                        // console.log(customerData.type);
                        $('#extype').val(customerData.type);
                        $('#expdue').val(customerData.amount);
                        $('#expensesId').val(customerData.expid);

                
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
                        url: "../../../apis/expenses/delete.php",
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
                            window.location.href = 'expense.php';
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